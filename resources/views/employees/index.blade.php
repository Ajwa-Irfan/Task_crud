@extends('layouts.app')
@section('title', 'Employees')
@section('page-title', 'Employee Management')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div></div>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-2"></i>Add Employee
        </a>
    </div>

    <div class="row g-4">
        @forelse($employees as $employee)
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="user-avatar" style="width:52px;height:52px;font-size:1.1rem;border-radius:14px;">
                                {{ strtoupper(substr($employee->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="fw-bold">{{ $employee->name }}</div>
                                <div style="font-size:0.8rem;color:#9CA3AF;">{{ $employee->department ?? 'No Department' }}</div>
                                <span class="badge {{ $employee->is_active ? 'bg-success' : 'bg-danger' }}" style="font-size:0.65rem;">
                                    {{ $employee->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-3" style="font-size:0.82rem;color:#6B7280;">
                            <div><i class="fas fa-envelope me-2"></i>{{ $employee->email }}</div>
                            @if($employee->phone)
                                <div class="mt-1"><i class="fas fa-phone me-2"></i>{{ $employee->phone }}</div>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('employees.show', $employee) }}" class="btn btn-sm btn-outline-primary flex-grow-1">View</a>
                            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('Delete employee?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="fas fa-users fa-3x mb-3 d-block"></i>No employees yet.
            </div>
        @endforelse
    </div>
    <div class="mt-4">{{ $employees->links() }}</div>
@endsection
