<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CartControlller;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ColorController;
use App\Http\Controllers\API\OrderControlller;
use App\Http\Controllers\API\PDFControlller;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\WeightController;
use App\Http\Controllers\API\WishListControlller;
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
Route::get('all-product', [ProductController::class, 'getProduct']);
Route::delete('products/{id}', [ProductController::class, 'deleteProduct']);

Route::get('detail-products/{id}', [ProductController::class, 'getDetail']);
Route::post('detail-products/{id}', [ProductController::class, 'addDetailProduct']);
Route::delete('detail-products/{id}', [ProductController::class, 'deleteDetailProduct']);
Route::put('update-detail-products/{id}', [ProductController::class, 'editDetailProduct']);

Route::get('fetchProduct/{slug}', [ProductController::class, 'fetchProduct']);
Route::get('fetchProduct/{slug}/{product}', [ProductController::class, 'fetchDetailProduct']);
Route::get('trending-product', [ProductController::class, 'trendingProduct']);
Route::get('fetchBrand/{name}', [ProductController::class, 'fetchBrand']);

Route::get('detailProduct/{id}', [ProductController::class, 'getDetailItem']);

Route::post('cart', [CartControlller::class, 'addToCart']);
Route::get('cart', [CartControlller::class, 'viewCart']);
Route::put('cart-updateQuantity/{cart_id}/{scope}', [CartControlller::class, 'updateQuantity']);
Route::delete('cart/{cart_id}', [CartControlller::class, 'deleteCart']);

Route::post('wishlist', [WishListControlller::class, 'addToWishlist']);
Route::get('wishlist', [WishListControlller::class, 'viewWish']);
Route::delete('wishlist/{wish_id}', [WishListControlller::class, 'deleteWish']);

Route::post('place-order', [OrderControlller::class, 'placeOrder']);
Route::post('place-order/{id}', [OrderControlller::class, 'paymentOrder']);
Route::post('cancel-order/{id}', [OrderControlller::class, 'cancelOrder']);
Route::post('finish-order/{id}', [OrderControlller::class, 'setStatusTransaction']);
Route::post('setStatusTransaction/{id}', [OrderControlller::class, 'cancelOrder']);
// Route::post('validate-order', [OrderControlller::class, 'validateOrder']);
Route::post('order-status/{id}', [OrderControlller::class, 'setPayment']);
Route::get('admin-order/{id}', [OrderControlller::class, 'viewOrder']);
Route::get('detail-order/{id}', [OrderControlller::class, 'viewDetailOrder']);

// Payment Check
Route::post('payment', [OrderControlller::class, 'payment']);
Route::post('paymentCheck/{id}', [OrderControlller::class, 'paymentOrderCheck']);

Route::post('forgot-password', [AuthController::class, 'forgotPassword']);

Route::get('all-brand', [BrandController::class, 'getBrand']);
Route::get('export_pdf', [PDFControlller::class, 'exportPDF']);



Route::group(['middleware' => 'api'], function () {
    Route::get('checkingAuthenticated', function () {
        return response()->json([
            'message' => 'You are in!',
            'status' => 200
        ], 200);
    });
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    //Brand
    Route::get('brand', [BrandController::class, 'viewBrand']);
    Route::post('brand', [BrandController::class, 'addBrand']);
    Route::post('brand/{id}', [BrandController::class, 'updateBrand']);
    Route::delete('brand/{id}', [BrandController::class, 'deleteBrand']);

    //Color

    Route::get('color', [ColorController::class, 'viewColor']);
    Route::post('color', [ColorController::class, 'addColor']);
    Route::put('color/{id}', [ColorController::class, 'updateColor']);
    Route::delete('color/{id}', [ColorController::class, 'deleteColor']);
    Route::get('all-color', [ColorController::class, 'getColor']);

    Route::get('users', [AuthController::class, 'viewUser']);
    Route::put('user-status/{id}', [AuthController::class, 'setStatus']);
    Route::post('profile', [AuthController::class, 'profile']);
    Route::put('profile/{id}', [AuthController::class, 'setProfile']);
    Route::get('profile/{email}', [AuthController::class, 'getProfile']);
    Route::post('reset/{id}', [AuthController::class, 'reset']);
    Route::post('forgot/{email}', [AuthController::class, 'reset']);
    Route::put('change-pass/{id}', [AuthController::class, 'changePass']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('send-verify-mail/{email}', [AuthController::class, 'sendVerifyMail']);
    Route::get('dashboard/{year}', [OrderControlller::class, 'analystData']);
    Route::get('dashboard-analyst/{year}', [OrderControlller::class, 'analystDashboard']);
    Route::get('dashboard-analyst-cancel/{year}', [OrderControlller::class, 'analystCancelDashboard']);
    Route::get('dashboard-analyst-done/{year}', [OrderControlller::class, 'analystDoneDashboard']);
    Route::get('dashboard-analyst-status/{year}', [OrderControlller::class, 'analystStatusDashboard']);
    Route::get('dashboard-analyst-statusOrderan/{year}', [OrderControlller::class, 'analystStatusOrderanDashboard']);
    Route::get('dashboard-order', [OrderControlller::class, 'viewUnpaidOrder']);
    Route::get('dashboard-process', [OrderControlller::class, 'viewProcessOrder']);
    Route::get('laporan-tahunan/{year}', [OrderControlller::class, 'dataAdmin']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
