<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all():JsonResponse
    {
       return response()->json(Order::all());
    }

    public function getProductsOrder(Order $order):JsonResponse{
        try {
            return response()->json($order::with('products')->get());
        } catch (Exception $th) {
            //throw $th;

            $RESPONSE = [
                'success' => false,
                'message' => $th->getMessage(),
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR 
            ];

            return response()->json($RESPONSE);
        }
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
         $validator = Validator::make($request->json()->all(), [

            'user_id'=>'required|string|exists:users,_id',
            'address'=>'required|string|min:1|max:255',
            'city'=>'required|string|min:1|max:255',
            'country'=>'required|string|min:1|max:255',
            'phone_number'=>'required|string|min:1|max:20',
            'items' => 'required|array',
            'items.*.product_id' => 'required|string|exists:products,_id',
            'items.*.quantity' => 'required|integer|min:0'
         ]);

         

         if($validator->fails())
             return response()->json($validator->errors(), 400);

             $order = Order::query()->create([
                 'user_id'=>$request->json()->get('user_id'),
                 'address'=>$request->json()->get('address'),
                 'city'=>$request->json()->get('city'),
                 'country'=>$request->json()->get('country'),
                 'phone_number'=>$request->json()->get('phone_number')
             ]);
             
             $order->items()->createMany($request->json()->get("items"));

             $order->items;

             return response()->json($order);

        } catch (Exception $th) {
            $RESPONSE = [
                'success' => false,
                'message' => $th->getMessage(),
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];

            return response()-json($RESPONSE);

            //throw $th;
        }
        //
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
    try {
        return response()->json($order);
    } catch (Exception $th) {
        $RESPONSE = [
            'success' => false,
            'message' => $th->getMessage(),
            'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
        ];
        return response()->json($RESPONSE);
    }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        try {
            $validator = Validator::make($request->json()->all(),[
                'user_id'=>'required|string|exists:users,_id',
                'address'=>'required|string|min:1|max:255',
                'city'=>'required|string|min:1|max:255',
                'country'=>'required|string|min:1|max:255',
                'phone_number'=>'required|string|min:1|max:20',
                'items' => 'required|array',
                'items.*.product_id' => 'required|string|exists:products,_id',
                'items.*.quantity' => 'required|integer|min:0'
            ]);
            if($validator->fails())
            return response()->json($validator->errors());

            $order = Order::query()->update([
                'user_id'=>$request->json()->get('user_id'),
                'address'=>$request->json()->get('address'),
                'city'=>$request->json()->get('city'),
                'country'=>$request->json()->get('country'),
                'phone_number'=>$request->json()->get('phone_number')
            ]);
            return response()->json($order);

        } catch (Exception $th) {
            //throw $th;
            $RESPONSE = [
                'success'=>false,
                'message'=>$th->getMessage(),
                'status'=>JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            ];
            return responde()->json($RESPONSE);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function delete(Order $order)
    {
        try {
            return response()->json($order->delete());
        } catch (Exception $th) {
           return response()->json(['message' => 'Failed to cancel your order'], 500);
        }
    }
}
