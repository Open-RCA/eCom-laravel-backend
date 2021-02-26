<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ProductCategoryController extends Controller
{
    public function all(): JsonResponse
    {
        try {
            $productCategories = ProductCategory::query()->paginate(20);
            return response()->json($productCategories);
        }
        catch (Exception $exception) {
            $RESPONSE = [
                'success' => false,
                'message' => $exception->getMessage(),
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
            return response()->json($RESPONSE);
        }
    }

    public function show(ProductCategory $productCategory): JsonResponse
    {
        try {
            return response()->json($productCategory);
         }
        catch (Exception $exception) {
            $RESPONSE = [
                'success' => false,
                'message' => $exception->getMessage(),
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
            return response()->json($RESPONSE);
        }
    }


    public function create(Request $request): JsonResponse {
        try {
            $validator = Validator::make($request->json()->all(), [
                'category' => 'required|string|min:1|max:50|unique:product_categories',
                'description' => 'required|string|min:1|max:50'
            ]);

            if ($validator->fails())
                return response()->json($validator->errors());


            $productCategory = ProductCategory::query()->create([
                'category' => $request->json()->get('category'),
                'description' => $request->json()->get('description')
            ]);

            return response()->json($productCategory);
        }
        catch (Exception $exception) {
            $RESPONSE = [
                'success' => false,
                'message' => $exception->getMessage(),
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
            return response()->json($RESPONSE);
        }
    }


    public function update(Request $request, ProductCategory $productCategory): JsonResponse
    {
        try {
            $validator = Validator::make($request->json()->all(), [
                'category' => 'required|string|min:1|max:50|unique:product_categories',
                'description' => 'required|string|min:1|max:50'
            ]);

            if ($validator->fails())
                return response()->json($validator->errors());

            $productCategory = ProductCategory::query()->update([
                'category' => $request->json()->get('category'),
                'description' => $request->json()->get('description')
            ]);

            return response()->json($productCategory);
        }
        catch (Exception $exception) {
            $RESPONSE = [
                'success' => false,
                'message' => $exception->getMessage(),
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
            return response()->json($RESPONSE);
        }
    }


    public function delete(ProductCategory $productCategory): JsonResponse
    {
        try {
            return response()->json($productCategory->delete());
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
