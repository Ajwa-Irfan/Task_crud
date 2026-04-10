@extends('layouts.app')
@section('title', 'Edit Task')
@section('page-title', 'Edit Task')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header py-3 px-4">
                    <i class="fas fa-edit me-2" style="color:#6C63FF;"></i>Edit: {{ $task->title }}
                </div>
                <div class="card-body p-4">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row g-4">

                            <div class="col-12">
                                <label class="form-label">Task Title *</label>
                                <input type="text" name="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title', $task->title) }}"
                                       maxlength="255">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description"
                                          class="form-control @error('description') is-invalid @enderror"
                                          rows="4">{{ old('description', $task->description) }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Assign To</label>
                                <select name="assigned_to"
                                        class="form-select @error('assigned_to') is-invalid @enderror">
                                    <option value="">-- Select Employee --</option>
                                    @foreach($employees as $emp)
                                        <option value="{{ $emp->id }}"
                                            {{ old('assigned_to', $task->assigned_to) == $emp->id ? 'selected' : '' }}>
                                            {{ $emp->name }} ({{ $emp->department ?? 'No dept' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('assigned_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Priority *</label>
                                <select name="priority"
                                        class="form-select @error('priority') is-invalid @enderror">
                                    @foreach(['low','medium','high','urgent'] as $p)
                                        <option value="{{ $p }}"
                                            {{ old('priority', $task->priority) == $p ? 'selected' : '' }}>
                                            {{ ucfirst($p) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status *</label>
                                <select name="status"
                                        class="form-select @error('status') is-invalid @enderror">
                                    @foreach(['pending','in_progress','completed','cancelled'] as $s)
                                        <option value="{{ $s }}"
                                            {{ old('status', $task->status) == $s ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $s)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Due Date</label>
                                <input type="date" name="due_date"
                                       class="form-control @error('due_date') is-invalid @enderror"
                                       value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                                @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 d-flex gap-3">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Update Task
                                </button>
                                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
