<?php

namespace App\Http\Controllers;

use App\Models\ProductRating;
use App\Models\ProductSubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mockery\Exception;

class ProductRatingController extends Controller
{

    public function all(): JsonResponse {
        try {
            $product_ratings = ProductRating::all();
            return response()->json($product_ratings);
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

    public function show(ProductRating $productRating): JsonResponse {
        try {
            return response()->json($productRating);
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

    public function create(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->json()->all(), [
                'product_id' => 'required|string|min:1|max:50|exists:products, _id',
                'rate' => ['integer', Rule::in([20, 40, 60, 80, 100])],
                'user_id' => 'required|string|min:1|max:50|exists:users, _id',
                'comment'
            ]);

            if ($validator->fails())
                return response()->json($validator->errors());

            $productSubCategory = ProductRating::query()->create([
                'category' => $request->json()->get('category'),
                'product_category_id' => $request->json()->get('product_category_id'),
                'description' => $request->json()->get('description')
            ]);

            return response()->json($productSubCategory);
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
