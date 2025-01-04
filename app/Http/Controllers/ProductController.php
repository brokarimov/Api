<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\AttributeCharacteristic;
use App\Models\Element;
use App\Models\Option;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        
        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);

        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);

    }
    public function update(Product $product, Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required'
        ]);

        $product->update($validate);

        
        return new ProductResource($product);
    }
    
    public function delete(Product $product)
    {
        $product->delete();
        $data = [
            'message' => 'success',
        ];

        return response()->json($data);
    }
}
