@extends('layouts.app')
@section('title', 'Employee Detail')
@section('page-title', 'Employee Detail')

@section('content')
    <div class="card">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="user-avatar" style="width:60px;height:60px;font-size:1.3rem;border-radius:14px;">
                    {{ strtoupper(substr($employee->name, 0, 2)) }}
                </div>
                <div>
                    <h5 class="mb-0">{{ $employee->name }}</h5>
                    <div style="color:#9CA3AF;">{{ $employee->department ?? 'No Department' }}</div>
                    <span class="badge {{ $employee->is_active ? 'bg-success' : 'bg-danger' }}">
                        {{ $employee->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            <div class="mb-2"><i class="fas fa-envelope me-2"></i>{{ $employee->email }}</div>
            @if($employee->phone)
                <div class="mb-2"><i class="fas fa-phone me-2"></i>{{ $employee->phone }}</div>
            @endif
            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('employees.edit', $employee) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
