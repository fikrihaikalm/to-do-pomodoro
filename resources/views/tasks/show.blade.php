@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Task Details</h4>
                    <div>
                        <input type="checkbox" class="form-check-input" {{ $task->completed ? 'checked' : '' }} onchange="window.location.href='{{ route('tasks.complete', $task) }}'">
                        <span class="ms-2">{{ $task->completed ? 'Completed' : 'Mark Complete' }}</span>
                    </div>
                </div>

                <div class="card-body">
                    <h3 class="{{ $task->completed ? 'text-decoration-line-through' : '' }}">{{ $task->title }}</h3>
                    <p class="text-muted">Created: {{ $task->created_at->format('M d, Y H:i') }}</p>
                    
                    <div class="mb-3">
                        <strong>Prioritas:</strong>
                        <span class="badge bg-{{ $task->priority >= 4 ? 'danger' : ($task->priority >= 3 ? 'warning' : 'primary') }}">
                            {{ $task->priority }}
                        </span>
                    </div>

                    @if($task->due_date)
                    <div class="mb-3">
                        <strong>Tenggat Waktu:</strong> {{ $task->due_date->format('M d, Y H:i') }}
                    </div>
                    @endif

                    <div class="mb-3">
                        <strong>Deskripsi:</strong>
                        <p>{{ $task->description ?? 'No description' }}</p>
                    </div>

                    <div class="d-flex">
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary me-2">Edit</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection