<?php

namespace App\Http\Controllers;

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
            $productSubCategories = ProductSubCategory::query()->paginate(20);
            return response()->json($productSubCategories);
        }
        catch (Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

    public function show(ProductSubCategory $productSubCategory): JsonResponse
    {
        try {
            return response()->json($productSubCategory);
        }
        catch (Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }


    public function create(Request $request): JsonResponse {
        try {
            $validator = Validator::make($request->json()->all(), [
                'category' => 'required|string|min:1|max:50|unique:product_sub_categories',
                'product_category_id' => 'required|string|min:24|max:24',
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
            return response()->json($exception->getMessage());
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
            return response()->json($exception->getMessage());
        }
    }


    public function delete(ProductSubCategory $productSubCategory): JsonResponse
    {
        try {
            return response()->json($productSubCategory->delete());
        } catch (Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }




}
