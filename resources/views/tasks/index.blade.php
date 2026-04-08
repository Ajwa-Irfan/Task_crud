@extends('layouts.app')
@section('title', 'Tasks')
@section('page-title', 'Tasks')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div></div>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Assign New Task
            </a>
        @endif
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body py-3">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search tasks..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        @foreach(['pending','in_progress','completed','cancelled'] as $s)
                            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Priority</label>
                    <select name="priority" class="form-select">
                        <option value="">All Priorities</option>
                        @foreach(['low','medium','high','urgent'] as $p)
                            <option value="{{ $p }}" {{ request('priority') == $p ? 'selected' : '' }}>{{ ucfirst($p) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tasks Table -->
    <div class="tf-table">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Task Title</th>
                    <th>Assigned To</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($tasks as $task)
                    <tr>
                        <td class="text-muted" style="font-family:'JetBrains Mono',monospace;font-size:0.8rem;">#{{ $task->id }}</td>
                        <td>
                            <div class="fw-600">{{ $task->title }}</div>
                            @if($task->description)
                                <div class="text-muted" style="font-size:0.78rem;">{{ Str::limit($task->description, 50) }}</div>
                            @endif
                        </td>
                        <td>
                            @if($task->assignee)
                                <div class="d-flex align-items-center gap-2">
                                    <div class="user-avatar" style="width:28px;height:28px;font-size:0.7rem;">{{ strtoupper(substr($task->assignee->name,0,2)) }}</div>
                                    {{ $task->assignee->name }}
                                </div>
                            @else
                                <span class="text-muted fst-italic">Unassigned</span>
                            @endif
                        </td>
                        <td><span class="badge-status badge-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span></td>
                        <td>
                            @if(auth()->user()->id === $task->assigned_to || auth()->user()->isAdmin())
                                <form action="{{ route('tasks.status', $task) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="width:auto;display:inline-block;padding:3px 8px;font-size:0.78rem;">
                                        @foreach(['pending','in_progress','completed','cancelled'] as $s)
                                            <option value="{{ $s }}" {{ $task->status == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            @else
                                <span class="badge-status badge-{{ $task->status }}">{{ ucfirst(str_replace('_',' ',$task->status)) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($task->due_date)
                                <span class="{{ $task->isOverdue() ? 'text-danger fw-600' : '' }}">{{ $task->due_date->format('M d, Y') }}</span>
                            @else <span class="text-muted">—</span> @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-secondary" title="View"><i class="fas fa-eye"></i></a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-5">No tasks found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $tasks->withQueryString()->links() }}</div>
@endsection
