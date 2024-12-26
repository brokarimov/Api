<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return PostResource::collection($posts);
    }

    public function store(Request $request)
    {
        $validate = $request->validate(
            [
                'title' => 'required|max:255',
                'category_id' => 'required|exists:categories,id',
                'description' => 'required|max:255',
                'text' => 'required|max:255',
                'image' => 'required',
            ]
        );

        $model = Post::create($validate);
        $data = [
            'model' => $model,
        ];

        return PostResource::collection($data);
    }
    public function show(Post $post)
    {
        $data = [
            'model' => $post,

        ];

        return PostResource::collection($data);
    }
    public function update(Post $post, Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|max:255',
            'text' => 'required|max:255',
            'image' => 'required',
        ]);

        $post->update($validate);

        $data = [
            'model' => $post,

        ];
        return PostResource::collection($data);
    }

    public function delete(Post $post)
    {
        $post->delete();
        $data = [
            'message' => 'success',
        ];

        return response()->json($data);
    }
}
