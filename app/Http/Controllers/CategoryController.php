<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        
        return CategoryResource::collection($categories);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
                'name' => 'required|max:255',
            ]
        );
        $model = Category::create($validate);
        $data = [
            'model' => $model,
            'message' => 'success',
        ];

        return response()->json($data);
    }
    public function show(Category $category)
    {
        $data = [
            'model' => $category,
            'message' => 'success',
        ];

        return response()->json($data);
    }
    public function update(Category $category, Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:255',
        ]);

        $category->update($validate);

        $data = [
            'model' => $category,
            'message' => 'success',
        ];
        return response()->json($data);
    }
    
    public function delete(Category $category)
    {
        $category->delete();
        $data = [
            'message' => 'success',
        ];

        return response()->json($data);
    }
}
