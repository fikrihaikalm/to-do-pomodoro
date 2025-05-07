@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Tasks</h3>
                    <a href="{{ route('tasks.create') }}" class="btn btn-success">Add New Task</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Task</th>
                                    <th>Priority</th>
                                    <th>Due Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- @foreach($tasks as $task)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input" {{ $task->completed ? 'checked' : '' }} onchange="window.location.href='{{ route('tasks.complete', $task) }}'">
                                    </td>
                                    <td class="{{ $task->completed ? 'text-decoration-line-through' : '' }}">
                                        <a href="{{ route('tasks.show', $task) }}">{{ $task->title }}</a>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $task->priority >= 4 ? 'danger' : ($task->priority >= 3 ? 'warning' : 'primary') }}">
                                            {{ $task->priority }}
                                        </span>
                                    </td>
                                    <td>{{ $task->due_date ? $task->due_date->format('M d, Y') : '-' }}</td>
                                    <td>
                                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach -->

                                @foreach($tasks as $task)
                                    <tr>
                                        
                                        <td>
                                            <form action="{{ route('tasks.complete', $task) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input 
                                                    type="checkbox" 
                                                    class="form-check-input me-2" 
                                                    {{ $task->completed ? 'checked' : '' }}
                                                    onchange="this.form.submit()"
                                                >
                                            </form>
                                        </td>
                                        <td class="{{ $task->completed ? 'text-decoration-line-through' : '' }}">
                                            <a href="{{ route('tasks.show', $task) }}">{{ $task->title }}</a>
                                        </td>

                                        <td>
                                            <span class="badge bg-{{ $task->priority >= 4 ? 'danger' : ($task->priority >= 3 ? 'warning' : 'primary') }}">
                                                {{ $task->priority }}
                                            </span>
                                        </td>
                                        <td>{{ $task->due_date ? $task->due_date->format('M d, Y') : '-' }}</td>
                                        <td>
                                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection