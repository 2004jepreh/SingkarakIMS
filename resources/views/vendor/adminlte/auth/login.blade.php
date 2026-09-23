@extends('adminlte::auth.auth-page', ['authType' => 'login'])

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@php
    $loginUrl = View::getSection('login_url') ?? config('adminlte.login_url', 'login');
    $loginUrl = $layoutHelper->makeUrl($loginUrl);
@endphp

{{-- Kosongkan header agar tidak ada tulisan "Sign in to start your session" --}}
@section('auth_header', '')

@section('auth_body')
    <form action="{{ $loginUrl }}" method="post">
        @csrf

        {{-- Email field --}}
        <div class="form-group mb-3">
            <label for="email" class="font-weight-normal text-secondary small">Email Address</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0">
                        <i class="fas fa-envelope text-muted" style="font-size: 0.85rem;"></i>
                    </span>
                </div>
                <input type="email" name="email" id="email"
                    class="form-control border-left-0 @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="name@example.com" autofocus required>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        {{-- Password field --}}
        <div class="form-group mb-4">
            <label for="password" class="font-weight-normal text-secondary small">Password</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0">
                        <i class="fas fa-lock text-muted" style="font-size: 0.85rem;"></i>
                    </span>
                </div>
                <input type="password" name="password" id="password"
                    class="form-control border-left-0 @error('password') is-invalid @enderror"
                    placeholder="••••••••" required>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-dark btn-block font-weight-semibold shadow-sm py-2 rounded-lg"
            style="background-color: #0f172a; border: none; font-size: 0.95rem;">
            <i class="fas fa-sign-in-alt mr-1" style="font-size: 0.85rem;"></i> Sign In
        </button>
    </form>
@stop

{{-- Kosongkan footer agar tautan Forgot Password & Register hilang --}}
@section('auth_footer', '')

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .card {
            border-radius: 12px !important;
            border: none !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
        }
        .card-header {
            display: none !important;
        }
        .input-group-text {
            border-right: none;
            background-color: #fff;
        }
        .form-control {
            border-left: none;
            box-shadow: none !important;
            height: calc(2.5rem + 2px);
        }
        .form-control:focus {
            border-color: #ced4da;
        }
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: #80bdff;
        }
    </style>
@stop
