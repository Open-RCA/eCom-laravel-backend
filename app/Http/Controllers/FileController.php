<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class FileController extends Controller
{
    //
    public function save(Request $request): JsonResponse {
        try {
//            $validator = $request->validate([
//                'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
//            ]);
            $validator = Validator::make($request->json()->all(), [
                'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            ]);
            if ($validator->fails())
                return response()->json($validator->errors());

            $product = Product::query()->create([
                'name' => $request->json()->get('name'),
                'product_sub_category_id' => $request->json()->get('product_sub_category_id'),
                'unit_price' => $request->json()->get('unit_price'),
                'quantity' => $request->json()->get('quantity')
            ]);

            if($request->file()) {
//                $file = File::query()->create([
//                    'file_url' => ,
//                    'file_name' => ,
//                    'file_size' =>,
//                    'file_size_type' =>,
//                    'file_type' => ,
//                    'status' => 'SAVED'
//                ]);
                $file = [
                    'name' => $request->file()->getClientOriginalName(),
                    'filePath' => $request->file('file')->storeAs('uploads', 'test', 'public'),
                    'path' => $request->file()->getClientOriginalName(),
                ];

            }

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
