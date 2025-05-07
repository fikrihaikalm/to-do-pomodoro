@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card text-center">
            <div class="card-header bg-primary text-white">
                <h3>Pomodoro Timer</h3>
            </div>
            <div class="card-body">
                <div id="pomodoro-container">
                    <div id="tree-container" class="mb-4">
                        <div id="tree" class="mx-auto" style="width: 200px; height: 200px; background-color: #5cb85c; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <div id="timer-display" class="text-white" style="font-size: 2.5rem;">25:00</div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <select id="task-select" class="form-select">
                            <option value="">-- Pilih Task (Optional) --</option>
                            @forelse($tasks as $task)
                                <option value="{{ $task->id }}">{{ $task->title }}</option>
                            @empty
                                <option value="" disabled>Tidak Ada Task Tersedia</option>
                            @endforelse
                        </select>
                        @if($tasks->isEmpty())
                            <small class="text-muted"><a href="{{ route('tasks.create') }}">Buat Task Baru</a></small>
                        @endif
                    </div>
                    
                    <div class="btn-group mb-3">
                        <button class="btn btn-outline-primary" data-duration="25">25 min</button>
                        <button class="btn btn-outline-primary" data-duration="15">15 min</button>
                        <button class="btn btn-outline-primary" data-duration="5">5 min</button>
                        <input type="number" id="custom-duration" class="form-control" style="width: 70px;" placeholder="Min" min="1">
                    </div>
                    
                    <div>
                        <button id="start-btn" class="btn btn-success btn-lg">Mulai</button>
                        <button id="pause-btn" class="btn btn-warning btn-lg" disabled>Jeda</button>
                        <button id="stop-btn" class="btn btn-danger btn-lg" disabled>Berhenti</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-info text-white">
                        <h3>Tasks Hari Ini</h3>
                    </div>
                    <div class="card-body">
                        <!-- @forelse($tasks as $task)
                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 border-bottom">
                                <div>
                                    <input type="checkbox" class="form-check-input me-2" 
                                           {{ $task->completed ? 'checked' : '' }} 
                                           onchange="window.location.href='{{ route('tasks.complete', $task) }}'">
                                    <span class="{{ $task->completed ? 'text-decoration-line-through' : '' }}">
                                        {{ $task->title }}
                                    </span>
                                </div>
                                <span class="badge bg-{{ $task->priority >= 4 ? 'danger' : ($task->priority >= 3 ? 'warning' : 'primary') }}">
                                    {{ $task->priority }}
                                </span>
                            </div>
                        @empty
                            <p>No tasks yet. <a href="{{ route('tasks.create') }}">Create one!</a></p>
                        @endforelse -->

                        @forelse($tasks as $task)
                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 border-bottom">
                                <div>
                                    <form action="{{ route('tasks.complete', $task) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input 
                                            type="checkbox" 
                                            class="form-check-input me-2" 
                                            {{ $task->completed ? 'checked' : '' }}
                                            onchange="this.form.submit()"
                                        >
                                        <span class="{{ $task->completed ? 'text-decoration-line-through' : '' }}">
                                            {{ $task->title }}
                                        </span>
                                    </form>
                                </div>
                                <span class="badge bg-{{ $task->priority >= 4 ? 'danger' : ($task->priority >= 3 ? 'warning' : 'primary') }}">
                                    {{ $task->priority }}
                                </span>
                            </div>
                        @empty
                            <p>No tasks yet. <a href="{{ route('tasks.create') }}">Create one!</a></p>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-secondary text-white">
                        <h3>Sesi Terakhir</h3>
                    </div>
                    <div class="card-body">
                        @forelse($recentSessions as $session)
                            <div class="mb-2 p-2 border-bottom">
                                <div class="d-flex justify-content-between">
                                    <strong>
                                        @if($session->task)
                                            {{ $session->task->title }}
                                        @else
                                            No Task
                                        @endif
                                    </strong>
                                    <span class="badge bg-{{ $session->status == 'completed' ? 'success' : ($session->status == 'running' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($session->status) }}
                                    </span>
                                </div>
                                <div class="text-muted small">
                                    {{ floor($session->completed_time / 60) }}m {{ $session->completed_time % 60 }}s 
                                    of {{ $session->duration }}m
                                </div>
                                <div class="small">
                                    {{ $session->created_at->timezone('Asia/Jakarta')->format('H:i') }}
                                </div>
                            </div>
                        @empty
                            <p>No sessions recorded yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection