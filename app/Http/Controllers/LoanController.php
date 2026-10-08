<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Loan;
use App\Models\LoanPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    /**
     * (Opsional) Jika masih digunakan untuk fallback
     */
    public function index()
    {
        $loans = Loan::with('employee')->latest()->paginate(10);
        return view('loans.index', compact('loans'));
    }

    /**
     * Menampilkan form pengajuan pinjaman baru.
     */
    public function create(Request $request)
    {
        // Ambil karyawan yang belum memiliki pinjaman aktif
        $employees = Employee::whereDoesntHave('loans', function ($query) {
            $query->where('status', 'active');
        })->get();

        // Oper parameter employee_id jika diklik langsung dari baris karyawan
        $selectedEmployeeId = $request->query('employee_id');

        return view('loans.create', compact('employees', 'selectedEmployeeId'));
    }

    /**
     * Menyimpan pinjaman baru karyawan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount'      => 'required|numeric|min:1000',
        ]);

        // Cek kembali apakah karyawan masih memiliki pinjaman aktif
        $hasActiveLoan = Loan::where('employee_id', $request->employee_id)
            ->where('status', 'active')
            ->exists();

        if ($hasActiveLoan) {
            return back()->withInput()->withErrors([
                'employee_id' => 'Karyawan ini masih memiliki pinjaman aktif yang belum lunas.'
            ]);
        }

        Loan::create([
            'employee_id'      => $request->employee_id,
            'amount'           => $request->amount,
            'remaining_amount' => $request->amount,
            'status'           => 'active',
        ]);

        // Redirect kembali ke halaman Karyawan
        return redirect()->route('employees.index')
            ->with('success', 'Pinjaman karyawan berhasil dicatat.');
    }

    /**
     * Memproses pencicilan / pemotongan pinjaman rutin.
     */
    public function pay(Request $request, Loan $loan)
    {
        $request->validate([
            'amount_paid'  => 'required|numeric|min:1000|max:' . $loan->remaining_amount,
            'payment_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $loan) {
            $amountPaid = $request->amount_paid;

            // 1. Catat riwayat pencicilan
            LoanPayment::create([
                'loan_id'      => $loan->id,
                'amount_paid'  => $amountPaid,
                'payment_date' => $request->payment_date,
            ]);

            // 2. Hitung sisa pinjaman baru
            $newRemaining = $loan->remaining_amount - $amountPaid;

            // 3. Update sisa pinjaman & ubah status ke paid_off jika sisa = 0
            $loan->update([
                'remaining_amount' => max(0, $newRemaining),
                'status'           => $newRemaining <= 0 ? 'paid_off' : 'active',
            ]);
        });

        // Redirect ke riwayat pinjaman tersebut
        return redirect()->route('loans.history', $loan->id)
            ->with('success', 'Cicilan berhasil diproses dan sisa pinjaman telah berkurang.');
    }

    /**
     * Menampilkan riwayat pencicilan dari suatu pinjaman.
     */
    public function history(Loan $loan)
    {
        $loan->load(['employee', 'payments' => function ($query) {
            $query->latest();
        }]);

        return view('loans.history', compact('loan'));
    }

    /**
     * Menghapus data pinjaman.
     */
    public function destroy(Loan $loan)
    {
        $loan->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Data pinjaman berhasil dihapus.');
    }
}
