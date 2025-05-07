<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PomodoroSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'duration',
        'completed_time',
        'status',
        'started_at',
        'completed_at'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}