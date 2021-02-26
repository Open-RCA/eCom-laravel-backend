<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;


class UserController extends Controller
{
    /**
     * Create a new UserController instance.
     * 
     * @return void
     */

    public function _construct(){
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Register a User.
     * 
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(Request $request) {        
        /**
        * Validate user inputs
        * 
        * @return \Illuminate\Http\JsonResponse
        */
         
        $validator = Validator::make($request->all(), [
             'first_name' => 'required|string|between:3,255',
             'last_name' => 'required|string|between:3,255',
             'username' => 'required|string|between:3,255',
             'email' => 'required|string|email|max:255|unique:users',
             'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
             'password' => 'required|string|confirmed|min:8',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }

    /**
     * Get a JWT via provided credentials for login.
     * 
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request){
        /**
         * Validate user inputs
         * 
         * @return \Illuminate\Http\JsonResponse
         */
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        
        if(!$token = auth('api')->attempt($validator->validate())){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Get the authenticated User
     * 
     * @return \Illuminate\Http|JsonResponse
     */
    public function currentUser(){
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     * 
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout(){
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(){
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     * 
     * @param string $token
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
         return response()->json([
             'access_token' => $token,
             'token_type' => 'bearer',
             'expires_in' => auth('api')->factory()->getTTL() * 60,
             'user' => auth()->user()
         ]);


    }
}