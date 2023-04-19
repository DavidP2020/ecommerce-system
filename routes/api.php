<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CartControlller;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ColorController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\WeightController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Category
Route::post('category', [CategoryController::class, 'addCategory']);
Route::post('category/{id}', [CategoryController::class, 'updateCategory']);
Route::delete('category/{id}', [CategoryController::class, 'deleteCategory']);
Route::get('category', [CategoryController::class, 'viewCategory']);
Route::get('all-category', [CategoryController::class, 'getCategory']);
Route::get('category/{id}', [CategoryController::class, 'viewIdCategory']);

//Product
Route::get('products', [ProductController::class, 'viewProduct']);
Route::post('products', [ProductController::class, 'addProduct']);
Route::post('products/{id}', [ProductController::class, 'updateProduct']);
Route::delete('detail-products/{id}', [ProductController::class, 'deleteDetailProduct']);
Route::delete('products/{id}', [ProductController::class, 'deleteProduct']);

Route::get('detail-products/{id}', [ProductController::class, 'getDetail']);
Route::post('detail-products/{id}', [ProductController::class, 'addDetailProduct']);
Route::delete('detail-products/{id}', [ProductController::class, 'deleteDetailProduct']);
Route::post('update-detail-products/{id}', [ProductController::class, 'editDetailProduct']);

Route::get('fetchProduct/{slug}', [ProductController::class, 'fetchProduct']);
Route::get('fetchProduct/{slug}/{product}', [ProductController::class, 'fetchDetailProduct']);
Route::get('detailProduct/{id}', [ProductController::class, 'getDetailItem']);

Route::post('cart', [CartControlller::class, 'addToCart']);
Route::get('cart', [CartControlller::class, 'viewCart']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('checkingAuthenticated', function () {
        return response()->json([
            'message' => 'You are in!',
            'status' => 200
        ], 200);
    });

    //Brand

    Route::get('brand', [BrandController::class, 'viewBrand']);
    Route::post('brand', [BrandController::class, 'addBrand']);
    Route::post('brand/{id}', [BrandController::class, 'updateBrand']);
    Route::delete('brand/{id}', [BrandController::class, 'deleteBrand']);
    Route::get('all-brand', [BrandController::class, 'getBrand']);

    //Color

    Route::get('color', [ColorController::class, 'viewColor']);
    Route::post('color', [ColorController::class, 'addColor']);
    Route::post('color/{id}', [ColorController::class, 'updateColor']);
    Route::delete('color/{id}', [ColorController::class, 'deleteColor']);
    Route::get('all-color', [ColorController::class, 'getColor']);

    //Weight

    Route::get('weight', [WeightController::class, 'viewWeight']);
    Route::post('weight', [WeightController::class, 'addWeight']);
    Route::post('weight/{id}', [WeightController::class, 'updateWeight']);
    Route::delete('weight/{id}', [WeightController::class, 'deleteWeight']);

    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
