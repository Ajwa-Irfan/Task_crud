@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon" style="background:#EDE9FF;">
                        <i class="fas fa-tasks" style="color:#6C63FF;"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $stats['total_tasks'] }}</div>
                <div class="stat-label">Total Tasks</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon" style="background:#FEF9C3;">
                        <i class="fas fa-clock" style="color:#CA8A04;"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $stats['pending'] }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon" style="background:#DBEAFE;">
                        <i class="fas fa-spinner" style="color:#2563EB;"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $stats['in_progress'] }}</div>
                <div class="stat-label">In Progress</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon" style="background:#D1FAE5;">
                        <i class="fas fa-check-circle" style="color:#16A34A;"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $stats['completed'] }}</div>
                <div class="stat-label">Completed</div>
            </div>
        </div>
    </div>

    @if(auth()->user()->isAdmin())
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon mb-3" style="background:#FCE7F3;">
                        <i class="fas fa-users" style="color:#DB2777;"></i>
                    </div>
                    <div class="stat-value">{{ $stats['total_employees'] }}</div>
                    <div class="stat-label">Employees</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon mb-3" style="background:#FEE2E2;">
                        <i class="fas fa-exclamation-triangle" style="color:#DC2626;"></i>
                    </div>
                    <div class="stat-value">{{ $stats['overdue'] }}</div>
                    <div class="stat-label">Overdue</div>
                </div>
            </div>
        </div>
    @endif

    <div class="row g-4">
        <!-- Recent Tasks -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center py-3 px-4">
                    <span><i class="fas fa-list me-2" style="color:#6C63FF;"></i>Recent Tasks</span>
                    <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table tf-table mb-0">
                        <thead>
                        <tr>
                            <th>Task</th>
                            <th>Assigned To</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Due Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($recentTasks as $task)
                            <tr>
                                <td>
                                    <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none fw-600" style="color:var();">
                                        {{ $task->title }}
                                    </a>
                                </td>
                                <td>
                                    @if($task->assignee)
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="user-avatar" style="width:28px;height:28px;font-size:0.7rem;">
                                                {{ strtoupper(substr($task->assignee->name, 0, 2)) }}
                                            </div>
                                            {{ $task->assignee->name }}
                                        </div>
                                    @else
                                        <span class="text-muted">Unassigned</span>
                                    @endif
                                </td>
                                <td><span class="badge-status badge-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span></td>
                                <td><span class="badge-status badge-{{ $task->status }}">{{ ucfirst(str_replace('_',' ',$task->status)) }}</span></td>
                                <td>
                                    @if($task->due_date)
                                        <span class="{{ $task->isOverdue() ? 'text-danger fw-600' : 'text-muted' }}">
                                        {{ $task->due_date->format('M d, Y') }}
                                    </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">No tasks found.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Employee Summary (Admin only) -->
        @if(auth()->user()->isAdmin())
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header py-3 px-4">
                        <i class="fas fa-users me-2" style="color:#6C63FF;"></i>Team Overview
                    </div>
                    <div class="card-body p-0">
                        @forelse($employees as $emp)
                            <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                                <div class="user-avatar">{{ strtoupper(substr($emp->name, 0, 2)) }}</div>
                                <div class="flex-grow-1">
                                    <div class="fw-600" style="font-size:0.85rem;">{{ $emp->name }}</div>
                                    <div style="font-size:0.75rem; color:#9CA3AF;">{{ $emp->department ?? 'No dept' }}</div>
                                </div>
                                <div class="text-end">
                                    <div style="font-size:1rem; font-weight:700; color:#6C63FF;">{{ $emp->assigned_tasks_count }}</div>
                                    <div style="font-size:0.72rem; color:#9CA3AF;">tasks</div>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-muted">No employees yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
