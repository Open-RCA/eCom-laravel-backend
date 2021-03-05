<?php

namespace App\Http\Controllers;

use App\Models\File;;
use Illuminate\Support\Str;
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


            $file = $file['file'];

//            dd($file);
//            dd($file->getFilename());
            $newFile = [
                'file_url' => 'dsfdsf',
                'file_name' => ((string) Str::uuid()) .  "." . $file->getExtension(),
                'file_size_type' => 'B',
                'file_size' => $file->getSize(),
                'file_type' => $file->getExtension(),
                'status' => 'SAVED'
            ];
//
            dd($newFile);
//                        dd($newFile);



//            $newFile = File::query()->create([
//                'file_url' => 'dsfdsf',
//                'file_name' => $file->originalName,
//                'file_size' =>,
//                'file_size_type' =>,
//                'file_type' =>,
//                'status' =>
//            ]);


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
