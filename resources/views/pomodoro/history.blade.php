@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3>Pomodoro History</h3>
                </div>

                <div class="card-body">
                    @if($sessions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Task</th>
                                        <th>Durasi</th>
                                        <th>Waktu Selesai</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sessions as $session)
                                    <tr>
                                        <td>{{ $session->created_at->format('M d, Y H:i') }}</td>
                                        <td>{{ $session->task ? $session->task->title : 'No Task' }}</td>
                                        <td>{{ $session->duration }} minutes</td>
                                        <td>{{ floor($session->completed_time / 60) }}m {{ $session->completed_time % 60 }}s</td>
                                        <td>
                                            <span class="badge bg-{{ $session->status == 'completed' ? 'success' : ($session->status == 'running' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($session->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $sessions->links() }}
                        </div>
                    @else
                        <p>No pomodoro sessions recorded yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection