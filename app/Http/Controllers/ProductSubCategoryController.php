<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSubCategory;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductSubCategoryController extends Controller
{

    public function all(): JsonResponse
    {
        try {
            $productSubCategories = ProductSubCategory::with('productCategory')->get();
            return response()->json($productSubCategories);
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
    public function getProducts(Product  $product): JsonResponse
    {
        try {
            return response()->json($product::with('productSubCategory')->get());
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




    public function show(ProductSubCategory $productSubCategory): JsonResponse
    {
        try {
            return response()->json($productSubCategory);
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
                'category' => 'required|string|min:1|max:50|unique:product_sub_categories',

                'product_category_id' => 'required|string|exists:product_categories,_id',
                'description' => 'required|string|min:1|max:50'
            ]);

            if ($validator->fails())
                return response()->json($validator->errors());

            $productSubCategory = ProductSubCategory::query()->create([
                'category' => $request->json()->get('category'),
                'product_category_id' => $request->json()->get('product_category_id'),
                'description' => $request->json()->get('description')
            ]);

            return response()->json($productSubCategory);
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


    public function update(Request $request, ProductSubCategory $productSubCategory): JsonResponse
    {
        try {
            $validator = Validator::make($request->json()->all(), [
                'category' => 'required|string|min:1|max:50|unique:product_sub_categories',
                'product_category_id' => 'required|string|min:24|max:24',
                'description' => 'required|string|min:1|max:50'
            ]);

            if ($validator->fails())
                return response()->json($validator->errors());

            $productCategory = ProductSubCategory::query()->update([
                'category' => $request->json()->get('category'),
                'product_category_id' => $request->json()->get('product_category_id'),
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


    public function delete(ProductSubCategory $productSubCategory): JsonResponse
    {
        try {
            return response()->json($productSubCategory->delete());
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

