<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class FileController extends Controller
{
    //
    public function save(Request $request): JsonResponse {
        try {
            $file = $request->only('file');
            if (empty($file)){
                $RESPONSE = [
                    'success' => false,
                    'message' => 'File not found',
                    'status' => JsonResponse::HTTP_BAD_REQUEST
                ];
                return response()->json($RESPONSE);
            }


//            dd($file);
            $validator = Validator::make($file, [
                'file' => 'required|mimes:jpeg,jpg,png,gif|max:2048'
            ]);

            if ($validator->fails())
                return response()->json($validator->errors());

            dd($file);


            $file = File::query()->create([
                'category' => $request->json()->get('category'),
                'description' => $request->json()->get('description')
            ]);


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
