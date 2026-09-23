@extends('adminlte::page')

@section('title', 'Add User')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <div class="d-flex align-items-center">
                <h1 class="font-weight-bold text-dark mb-0" style="font-size: 2rem; line-height: 1;">
                    Add User
                </h1>
            </div>
            <div class="text-muted small mt-1">
                <a href="{{ url('/') }}" class="text-muted text-decoration-none">Home</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <a href="{{ route('users.index') }}" class="text-muted text-decoration-none">Users</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <span>Create</span>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm" style="border-radius: 8px;">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="mr-3 d-flex align-items-center justify-content-center bg-light rounded-circle"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-user-plus text-secondary"></i>
                        </div>
                        <div>
                            <h5 class="m-0 font-weight-bold text-dark">User Details</h5>
                            <small class="text-muted">Enter new user information and assign a role</small>
                        </div>
                    </div>

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        {{-- Name --}}
                        <div class="form-group mb-3">
                            <label for="name" class="font-weight-normal text-secondary">Full Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-user text-muted"></i></span>
                                </div>
                                <input type="text" name="name" class="form-control border-left-0 @error('name') is-invalid @enderror" id="name" placeholder="John Doe" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="form-group mb-3">
                            <label for="email" class="font-weight-normal text-secondary">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-envelope text-muted"></i></span>
                                </div>
                                <input type="email" name="email" class="form-control border-left-0 @error('email') is-invalid @enderror" id="email" placeholder="example@mail.com" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="form-group mb-3">
                            <label for="password" class="font-weight-normal text-secondary">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-lock text-muted"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control border-left-0 @error('password') is-invalid @enderror" id="password" placeholder="Minimum 8 characters" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Select Single Role --}}
                        <div class="form-group mb-4">
                            <label for="role" class="font-weight-normal text-secondary">Assign Role <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-user-shield text-muted"></i></span>
                                </div>
                                <select name="role" id="role" class="form-control border-left-0 @error('role') is-invalid @enderror" required>
                                    <option value="" disabled selected>-- Select Role --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <a href="{{ route('users.index') }}" class="btn btn-light border mr-2 px-4">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-dark px-4" style="background-color: #343a40; border-color: #343a40;">
                                <i class="fas fa-save mr-2"></i> Save
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .input-group-text { border-right: none; background-color: #fff; }
        .form-control { border-left: none; box-shadow: none !important; }
        .form-control:focus { border-color: #ced4da; }
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control { border-color: #80bdff; }
    </style>
@stop
