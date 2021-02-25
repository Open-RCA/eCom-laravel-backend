<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function all(): JsonResponse
    {

        return response()->json(Product::all());
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    public function create(Request $request){
        $valid = Validator::make($request->json()->all(), [
            'name' => 'required|string|min:3',
            'description' => 'required|string|min:10'
        ]);

        if($valid->fails()) return response()->json($valid->errors(), 400);

        $product = Product::query()->create([
            'name' => $request->json()->get('name'),
            'description' => $request->json()->get('description'),
        ]);

        if(!$product) return response()->json(['message' => 'Failed to create a product'], 500);
        return response()->json($product);
    }

    public function edit(Product $product, Request $request){
        $valid = Validator::make($request->json()->all(), [
            'name' => 'required|string|min:3',
            'description' => 'required|string|min:10'
        ]);

        if($valid->fails()) return response()->json($valid->errors(), 400);

        $product = $product->update([
            'name' => $request->json()->get('name'),
            'description' => $request->json()->get('description'),
        ]);

        if(!$product) return response()->json(['message' => 'Failed to create a product'], 500);
        return response()->json(["message" => "Updated the product successfully"]);
    }

    public function delete(Product $product): JsonResponse
    {
        try {
            return response()->json($product->delete());
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to delete the product'], 500);
        }
    }
}
