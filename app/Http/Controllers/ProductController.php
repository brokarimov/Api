<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AttributeCharacteristic;
use App\Models\Element;
use App\Models\Option;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {}

    public function store(Request $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);

        $element = Element::create([
            'title' => $request->title,
            'product_id' => $product->id,
            'price' => $request->price,
        ]);
        $existing_attribute_characteristic_id = AttributeCharacteristic::where('attribute_id', $request->attribute_id)->where('characteristic_id', $request->characteristic_id)->exists();
        if (!$existing_attribute_characteristic_id) {
            $existing_attribute_characteristic_id = AttributeCharacteristic::create([
                'attribute_id' => $request->attribute_id,
                'characteristic_id' => $request->characteristic_id,
            ]);
        } else {
            $existing_attribute_characteristic_id = AttributeCharacteristic::where('attribute_id', $request->attribute_id)->where('characteristic_id', $request->characteristic_id)->first();
        }

        $option = Option::create([
            'element_id' => $element->id,
            'attribute_characteristic_id' => $existing_attribute_characteristic_id->id,
        ]);

        $option = Option::with('attributeCharacteristic.attributes', 'attributeCharacteristic.characteristic')
            ->find($option->id);

        $data = [
            'name' => $product->name,
            'category_id' => $product->categories->name,
            'description' => $product->description,
            'title' => $element->title,
            'price' => $element->price,
            'attribute_characteristic_id' => $option->attributeCharacteristic->attributes->name. ' = ' .$option->attributeCharacteristic->characteristic->name,
        ];
        return response()->json($data);
    }
}
