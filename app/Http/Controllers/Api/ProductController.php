<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    public function index()
    {
        return ProductResource::collection(Product::latest()->get());
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_desc' => 'nullable|string',
            'product_price' => 'required|numeric',
            'product_image' => 'nullable|string',
        ]);

        $product = Product::create($validated);

        return response()->json(['data' => $product], 201);
    }
    public function show(Product $product)
    {
        return new ProductResource($product);
    }


    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'sometimes|required|string|max:255',
            'product_desc' => 'sometimes|nullable|string',
            'product_price' => 'sometimes|required|numeric',
            'product_image' => 'sometimes|nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product->update($request->all());
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 204);
    }
}
