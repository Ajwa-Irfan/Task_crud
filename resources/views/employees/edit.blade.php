@extends('layouts.app')
@section('title', 'Edit Employee')
@section('page-title', 'Edit Employee')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header py-3 px-4">
                    <i class="fas fa-user-edit me-2" style="color:#6C63FF;"></i>Edit: {{ $employee->name }}
                </div>
                <div class="card-body p-4">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('employees.update', $employee) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $employee->name) }}"
                                       maxlength="255">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email Address *</label>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $employee->email) }}">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $employee->phone) }}"
                                       maxlength="20">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Department</label>
                                <input type="text" name="department"
                                       class="form-control @error('department') is-invalid @enderror"
                                       value="{{ old('department', $employee->department) }}"
                                       maxlength="100">
                                @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="is_active" class="form-select">
                                    <option value="1" {{ $employee->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$employee->is_active ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="col-12 d-flex gap-2 mt-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Update Employee
                                </button>
                                <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
