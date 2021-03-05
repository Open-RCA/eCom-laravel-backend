<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ProductController extends Controller
{

    public function all(): JsonResponse
    {
        try {
            $products = Product::with('productSubCategory')->get();
            return response()->json($products);
        } catch (Exception $exception) {
            $RESPONSE = [
                'success' => false,
                'message' => $exception->getMessage(),
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
            return response()->json($RESPONSE);
        }
    }

    public function show(Product $product): JsonResponse
    {
        try {
            return response()->json($product);
        } catch (Exception $exception) {
            $RESPONSE = [
                'success' => false,
                'message' => $exception->getMessage(),
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
            return response()->json($RESPONSE);
        }
    }


    public function create(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->json()->all(), [
                'name' => 'required|string|min:1|max:50|unique:product_sub_categories',
                'product_sub_category_id' => 'required|string|exists:product_categories,_id',
                'unit_price' => 'required|numeric|min:1',
                'quantity' => 'required|numeric|min:1'
            ]);

            if ($validator->fails())
                return response()->json($validator->errors());

            $product = Product::query()->create([
                'name' => $request->json()->get('name'),
                'product_sub_category_id' => $request->json()->get('product_sub_category_id'),
                'unit_price' => $request->json()->get('unit_price'),
                'quantity' => $request->json()->get('quantity'),
                'status' => 'ACTIVE'
            ]);

            return response()->json($product);
        } catch (Exception $exception) {
            $RESPONSE = [
                'success' => false,
                'message' => $exception->getMessage(),
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
            return response()->json($RESPONSE);
        }

    }


    public function update(Request $request, Product $product): JsonResponse
    {
        try {
            $validator = Validator::make($request->json()->all(), [
                'name' => 'required|string|min:1|max:50|unique:product_sub_categories',
                'product_sub_category_id' => 'required|string|exists:product_categories,_id',
                'unit_price' => 'required|numeric|min:1',
                'quantity' => 'required|numeric|min:1',
            ]);

            if ($validator->fails())
                return response()->json($validator->errors());

            $product = Product::query()->create([
                'name' => $request->json()->get('name'),
                'product_sub_category_id' => $request->json()->get('product_sub_category_id'),
                'unit_price' => $request->json()->get('unit_price'),
                'quantity' => $request->json()->get('quantity')
            ]);

            return response()->json($product);
        } catch (Exception $exception) {
            $RESPONSE = [
                'success' => false,
                'message' => $exception->getMessage(),
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
            return response()->json($RESPONSE);
        }
    }


    public function saveImage(Request $request, Product $product): JsonResponse
    {
        try {
            $validator = Validator::make($request->json()->all(), [
                'name' => 'required|string|min:1|max:50|unique:product_sub_categories',
                'product_sub_category_id' => 'required|string|exists:product_categories,_id',
                'unit_price' => 'required|numeric|min:1',
                'quantity' => 'required|numeric|min:1',
            ]);

            if ($validator->fails())
                return response()->json($validator->errors());

            $product = Product::query()->create([
                'name' => $request->json()->get('name'),
                'product_sub_category_id' => $request->json()->get('product_sub_category_id'),
                'unit_price' => $request->json()->get('unit_price'),
                'quantity' => $request->json()->get('quantity')
            ]);

            return response()->json($product);
        } catch (Exception $exception) {
            $RESPONSE = [
                'success' => false,
                'message' => $exception->getMessage(),
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
            return response()->json($RESPONSE);
        }
    }

    public function delete(Product $product): JsonResponse
    {
        try {
            return response()->json($product->delete());
        } catch (Exception $exception) {
            $RESPONSE = [
                'success' => false,
                'message' => $exception->getMessage(),
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
            return response()->json($RESPONSE);
        }
    }




}
