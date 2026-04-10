@extends('layouts.app')
@section('title', 'Assign Task')
@section('page-title', 'Assign New Task')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header py-3 px-4">
                    <i class="fas fa-plus-circle me-2" style="color:#6C63FF;"></i>Create & Assign Task
                </div>
                <div class="card-body p-4">

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">

                            <div class="col-12">
                                <label class="form-label">Task Title *</label>
                                <input type="text" name="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title') }}"
                                       placeholder="Enter task title..."
                                       maxlength="255">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description"
                                          class="form-control @error('description') is-invalid @enderror"
                                          rows="4"
                                          placeholder="Task details...">{{ old('description') }}</textarea>
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
                                            {{ old('assigned_to') == $emp->id ? 'selected' : '' }}>
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
                                    <option value="">-- Select Priority --</option>
                                    @foreach(['low','medium','high','urgent'] as $p)
                                        <option value="{{ $p }}"
                                            {{ old('priority','medium') == $p ? 'selected' : '' }}>
                                            {{ ucfirst($p) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Due Date</label>
                                <input type="date" name="due_date"
                                       class="form-control @error('due_date') is-invalid @enderror"
                                       value="{{ old('due_date') }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Due date cannot be in the past.</small>
                            </div>

                            <div class="col-12 d-flex gap-3 mt-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-check me-2"></i>Create Task
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
