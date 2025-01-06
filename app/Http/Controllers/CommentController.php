<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'text' => 'required'
        ]);

        $comment = Comment::create($comment);

        return new CommentResource($comment);
    }
}
