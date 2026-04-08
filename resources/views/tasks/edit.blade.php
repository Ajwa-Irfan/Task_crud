@extends('layouts.app')
@section('title', 'Edit Employee')
@section('page-title', 'Edit Employee')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header py-3 px-4">
                    <i class="fas fa-user-edit me-2" style="color:#6C63FF;"></i>Edit: {{ $task->name }}
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Task Title *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('title', $task->title) }}">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Description *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('description', $task->description) }}">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="is_active" class="form-select">
                                    <option value="1" {{ $task->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$task->is_active ? 'selected' : '' }}>Inactive</option>
                                </select>
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
