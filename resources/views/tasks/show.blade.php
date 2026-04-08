@extends('layouts.app')
@section('title', $employee->name)
@section('page-title', 'Employee Profile')

@section('content')
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card text-center p-4">
                <div class="user-avatar mx-auto mb-3" style="width:72px;height:72px;font-size:1.5rem;border-radius:18px;">
                    {{ strtoupper(substr($employee->name, 0, 2)) }}
                </div>
                <h5 class="fw-700">{{ $employee->name }}</h5>
                <p class="text-muted mb-1" style="font-size:0.85rem;">{{ $employee->email }}</p>
                @if($employee->department)
                    <span class="badge bg-light text-dark">{{ $employee->department }}</span>
                @endif
                <hr>
                <div class="row g-2 text-center">
                    <div class="col-4">
                        <div style="font-size:1.4rem;font-weight:700;color:#6C63FF;">{{ $tasks->count() }}</div>
                        <div style="font-size:0.72rem;color:#9CA3AF;">Total</div>
                    </div>
                    <div class="col-4">
                        <div style="font-size:1.4rem;font-weight:700;color:#16A34A;">{{ $tasks->where('status','completed')->count() }}</div>
                        <div style="font-size:0.72rem;color:#9CA3AF;">Done</div>
                    </div>
                    <div class="col-4">
                        <div style="font-size:1.4rem;font-weight:700;color:#CA8A04;">{{ $tasks->where('status','pending')->count() }}</div>
                        <div style="font-size:0.72rem;color:#9CA3AF;">Pending</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="tf-table">
                <div class="p-3 border-bottom fw-700" style="font-size:0.9rem;">
                    <i class="fas fa-tasks me-2" style="color:#6C63FF;"></i>Assigned Tasks
                </div>
                <table class="table mb-0">
                    <thead>
                    <tr><th>Title</th><th>Priority</th><th>Status</th><th>Due Date</th></tr>
                    </thead>
                    <tbody>
                    @forelse($tasks as $task)
                        <tr>
                            <td><a href="{{ route('tasks.show', $task) }}" class="text-decoration-none fw-600" style="color:var(--text-dark);">{{ $task->title }}</a></td>
                            <td><span class="badge-status badge-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span></td>
                            <td><span class="badge-status badge-{{ $task->status }}">{{ ucfirst(str_replace('_',' ',$task->status)) }}</span></td>
                            <td>{{ $task->due_date?->format('M d, Y') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">No tasks assigned.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">← Back to Employees</a>
            </div>
        </div>
    </div>
@endsection
