<?php

namespace App\Http\Controllers;

use App\Models\PomodoroSession;
use App\Models\Task;
use Illuminate\Http\Request;

class PomodoroController extends Controller
{
    public function start(Request $request)
    {
        try {
            $validated = $request->validate([
                'task_id' => 'nullable|exists:tasks,id',
                'duration' => 'required|integer|min:1|max:120'
            ]);

            $session = PomodoroSession::create([
                'task_id' => $validated['task_id'],
                'duration' => $validated['duration'],
                'status' => 'running',
                'started_at' => now(),
                'completed_time' => 0
            ]);

            return response()->json([
                'success' => true,
                'session_id' => $session->id,
                'message' => 'Pomodoro session started'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, PomodoroSession $session)
    {
        try {
            $validated = $request->validate([
                'completed_time' => 'required|integer|min:0'
            ]);

            $session->update([
                'completed_time' => $validated['completed_time']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Session updated'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function complete(PomodoroSession $session)
    {
        try {
            $session->update([
                'status' => 'completed',
                'completed_at' => now(),
                'completed_time' => $session->duration * 60 // Set as completed fully
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Session completed successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function cancel(PomodoroSession $session)
    {
        try {
            $session->update([
                'status' => 'canceled',
                'completed_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Session canceled'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function history()
    {
        $sessions = PomodoroSession::with('task')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        return view('pomodoro.history', compact('sessions'));
    }
}