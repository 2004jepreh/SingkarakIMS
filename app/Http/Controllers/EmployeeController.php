<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Menampilkan daftar karyawan beserta status pinjaman aktifnya.
     */
    public function index()
    {
        $employees = Employee::with('activeLoan')->latest()->paginate(10);
        return view('employees.index', compact('employees'));
    }

    /**
     * Menampilkan form tambah karyawan.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Menyimpan data karyawan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'salary'         => 'required|numeric|min:0',
            'salary_type'    => 'required|in:weekly,monthly',
            'incentive'      => 'nullable|numeric|min:0',
            'incentive_type' => 'required|in:weekly,monthly',
            'payday_date'    => 'required|date',
        ]);

        Employee::create([
            'name'           => $request->name,
            'salary'         => $request->salary,
            'salary_type'    => $request->salary_type,
            'incentive'      => $request->incentive ?? 0,
            'incentive_type' => $request->incentive_type,
            'payday_date'    => $request->payday_date,
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit karyawan.
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    /**
     * Memperbarui data karyawan.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'salary'         => 'required|numeric|min:0',
            'salary_type'    => 'required|in:weekly,monthly',
            'incentive'      => 'nullable|numeric|min:0',
            'incentive_type' => 'required|in:weekly,monthly',
            'payday_date'    => 'required|date',
        ]);

        $employee->update([
            'name'           => $request->name,
            'salary'         => $request->salary,
            'salary_type'    => $request->salary_type,
            'incentive'      => $request->incentive ?? 0,
            'incentive_type' => $request->incentive_type,
            'payday_date'    => $request->payday_date,
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Menghapus data karyawan.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }
}
