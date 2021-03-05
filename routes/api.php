<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductSubCategoryController;
use App\Http\Controllers\FileController;
use League\CommonMark\Inline\Element\Image;

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
    'prefix' => 'auth'
], function($router){
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/refresh', [UserController::class, 'refresh']);
    Route::get('/currentUser', [UserController::class, 'currentUser']);
    Route::post('/{user}', [UserController::class, 'update']);
    Route::post('/{user}', [UserController::class, 'delete']);
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
    Route::get('/products/{productSubCategory}', [ProductSubCategoryController::class, 'getProducts']);
    Route::group(['prefix' => '{productSubCategory}'], function() {
        Route::get('', [ProductSubCategoryController::class, 'show']);
        Route::put('', [ProductSubCategoryController::class, 'edit']);
        Route::delete('', [ProductSubCategoryController::class, 'delete']);
    });
});



Route::group(['prefix' => 'products'], function () {
    Route::get('/', [ProductController::class, 'all'])->name('Get Products');
    Route::post('/', [ProductController::class, 'create']);
    Route::group(['prefix' => '{product}'], function() {
        Route::get('', [ProductController::class, 'show']);
        Route::post('/upload-file', [ProductController::class, 'saveProductImage'])->name('Save');
        Route::put('', [ProductController::class, 'edit']);
        Route::delete('', [ProductController::class, 'delete']);
    });
});

