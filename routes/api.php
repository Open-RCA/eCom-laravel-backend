<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductSubCategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix'=>'roles'
], function(){
    Route::get('/', [RoleController::class, 'all']);
    Route::post('/', [RoleController::class, 'create'])->middleware('isAdmin');
    Route::group(['prefix' => '{role}'], function(){
        Route::put('', [RoleController::class, 'edit'])->middleware('isAdmin');
        Route::delete('', [RoleController::class, 'delete'])->middleware('isAdmin');
    });
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function(){
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/refresh', [UserController::class, 'refresh']);
    Route::get('/currentUser', [UserController::class, 'currentUser']);
    Route::group(['prefix' => '{user}'], function(){
        Route::put('', [UserController::class, 'update']);
        Route::delete('', [UserController::class, 'delete']);
    });
});

Route::group(['prefix' => 'products'], function () {
    Route::get("/", [ProductController::class, "all"]);
    Route::post("/", [ProductController::class, "create"]);
    Route::group(['prefix' => '{product}'], function (){
        Route::get('', [ProductController::class, "show"]);
        Route::put('', [ProductController::class, "edit"]);
        Route::delete('', [ProductController::class, "delete"]);
    });
});



Route::group(['prefix' => 'product-categories'], function () {
    Route::get('/', [ProductCategoryController::class, 'all']);
    Route::post('/', [ProductCategoryController::class, 'create']);
    Route::get('/sub-categories/{productCategory}', [ProductCategoryController::class, 'getSubCategories']);
    Route::group(['prefix' => '{productCategory}'], function() {
        Route::get('', [ProductCategoryController::class, 'show']);
        Route::put('', [ProductCategoryController::class, 'edit']);
        Route::delete('', [ProductCategoryController::class, 'delete']);
    });
});



Route::group(['prefix' => 'product-sub-categories'], function () {
    Route::get('/', [ProductSubCategoryController::class, 'all']);
    Route::post('/', [ProductSubCategoryController::class, 'create']);
    Route::group(['prefix' => '{productSubCategory}'], function() {
        Route::get('', [ProductSubCategoryController::class, 'show']);
        Route::put('', [ProductSubCategoryController::class, 'edit']);
        Route::delete('', [ProductSubCategoryController::class, 'delete']);
    });
});
