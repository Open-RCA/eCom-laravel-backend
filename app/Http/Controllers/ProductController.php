<?php

namespace App\Http\Controllers;

use App\Models\File;
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
            $products = $this->returnImages(Product::with('productSubCategory')->get(), true);
            return response()->json($products);
        } catch (Exception $exception) {
            dd($exception);
            $RESPONSE = [
                'success' => false,
                'message' => $exception->getMessage(),
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
            return response()->json($RESPONSE);
        }
    }

    private function returnImages($products, $many=false) {
        $productFiles = array();
        if ($many) {
            foreach ($products as $product) {
                $productFiles = array();
                foreach ($product->images as $image) {
                    $file = File::query()->find($image);

                    $domain = (env('APP_MODE') == 'development') ? env('APP_DEV_URL') : env('APP_PROD_URL');
                    $productFile = array(
                        'id' => $image,
                        'file_path' => $file->file_url,
                        'file_url' => $domain . ($file->file_url));
                    array_push($productFiles, $productFile);
                }
                $product->images = $productFiles;
            }
            return $products;
        }
        else {
            $product = $products;
                foreach ($product->images as $image) {
                    $file = File::query()->find($image);
                    $domain = (env('APP_MODE') == 'development') ? env('APP_DEV_URL') : env('APP_PROD_URL');
                    $productFile = array(
                        'id' => $image,
                        'file_path' => $file->file_url,
                        'file_url' => $domain . ($file->file_url));
                    array_push($productFiles, $productFile);
                }
                $product->images = $productFiles;
            }
            return $products;
    }
    public function show(Product $product): JsonResponse
    {
        try {

            $product = Product::with('productSubCategory')->find($product->id);
            $product = $this->returnImages($product);
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
                "sizes.*"  => "numeric|distinct|min:1",
                'description' => 'required|string|min:10',
                'quantity' => 'required|numeric|min:1'
            ]);

            if ($validator->fails())
                return response()->json($validator->errors());

            $product = Product::query()->create([
                'name' => $request->json()->get('name'),
                'description' => $request->json()->get('description'),
                'product_sub_category_id' => $request->json()->get('product_sub_category_id'),
                'unit_price' => $request->json()->get('unit_price'),
                'images' => array(),
                'sizes' => $request->json()->get('sizes'),
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
                "sizes.*"  => "numeric|distinct|min:1",
                'description' => 'required|string|min:10',
                'quantity' => 'required|numeric|min:1',
            ]);

            if ($validator->fails())
                return response()->json($validator->errors());

            $product = Product::query()->create([
                'name' => $request->json()->get('name'),
                'description' => $request->json()->get('description'),
                'product_sub_category_id' => $request->json()->get('product_sub_category_id'),
                'unit_price' => $request->json()->get('unit_price'),
                'sizes' => $request->json()->get('sizes'),
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


    public function saveProductImage(Request $request, Product $product): JsonResponse {
        try {

            $file = $request->only('file');
            $color = $request->only('color');

            if (empty($file)){
                $RESPONSE = [
                    'success' => false,
                    'message' => 'File not found',
                    'status' => JsonResponse::HTTP_BAD_REQUEST
                ];
                return response()->json($RESPONSE);
            }


            $fileValidator = Validator::make($file, [
                'file' => 'required|mimes:jpeg,jpg,png,gif|max:2048'
            ]);

            $colorValidator = Validator::make($color, [
                'color' => ['string', 'min:3' , 'regex:/^(#(?:[0-9a-f]{2}){2,4}|#[0-9a-f]{3}|(?:rgba?|hsla?)\((?:\d+%?(?:deg|rad|grad|turn)?(?:,|\s)+){2,3}[\s\/]*[\d\.]+%?\))$/i'],
            ]);

            if ($fileValidator->fails() || $colorValidator->fails())
                return response()->json(['file' => $fileValidator->errors(), 'color' => $colorValidator->errors()]);


            $file = $file['file'];
            $savedFile = (new FileController)->save($file);

            $image = array('file' => $savedFile->id, 'color' => $color['color']);


            $product->push('images', $image);

            $product->save();
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
            if ($product->delete()) {
                $RESPONSE = [
                    'success' => true,
                    'message' => 'Deleted Successfully',
                    'status' => JsonResponse::HTTP_OK
                ];
            return response()->json($RESPONSE);
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
