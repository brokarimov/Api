<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'task_id',
        'text',
    ];

    public function tasks()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
