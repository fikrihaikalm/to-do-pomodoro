<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\PomodoroSession;

class HomeController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('completed')
                   ->orderBy('priority', 'desc')
                   ->orderBy('due_date')
                   ->get();
        
        $recentSessions = PomodoroSession::with('task')
                           ->orderBy('created_at', 'desc')
                           ->take(3)
                           ->get();
        
        return view('pomodoro.timer', compact('tasks', 'recentSessions'));
    }
}