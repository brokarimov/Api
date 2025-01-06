<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return TaskResource::collection($tasks);
    }
    public function store(Request $request)
    {
        $task = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
        ]);
        $task['user_id'] = auth()->user()->id;
        $task = Task::create($task);

        return new TaskResource($task);
    }
}
