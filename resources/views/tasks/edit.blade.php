@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ isset($task) ? 'Edit Task' : 'Buat Task Baru' }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ isset($task) ? route('tasks.update', $task) : route('tasks.store') }}">
                        @csrf
                        @if(isset($task))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ isset($task) ? $task->title : old('title') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ isset($task) ? $task->description : old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="due_date" class="form-label">Tenggat Waktu</label>
                            <input type="datetime-local" class="form-control" id="due_date" name="due_date" value="{{ isset($task) ? $task->due_date->format('Y-m-d\TH:i') : old('due_date') }}">
                        </div>

                        <div class="mb-3">
                            <label for="priority" class="form-label">Prioritas (1-5)</label>
                            <input type="number" class="form-control" id="priority" name="priority" min="1" max="5" value="{{ isset($task) ? $task->priority : old('priority', 1) }}">
                        </div>

                        <button type="submit" class="btn btn-primary">{{ isset($task) ? 'Update' : 'Create' }}</button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection