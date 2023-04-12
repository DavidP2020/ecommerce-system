<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product_Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartControlller extends Controller
{
    //

    public function addToCart(Request $req)
    {

        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $product_id = $req->product_id;
            $product_qty = $req->product_qty;

            $checkCart = Product_Color::where('id', $product_id)->first();
            if ($checkCart) {

                if (Cart::where('product_id', $product_id)->where('user_id', $user_id)->exists()) {
                    return response()->json([
                        'status' => 409,
                        "message" => "Already Add to Cart"
                    ]);
                } else {
                    $cartItem = new Cart;
                    $cartItem->user_id = $user_id;
                    $cartItem->product_id = $product_id;
                    $cartItem->product_qty = $product_qty;
                    $cartItem->save();

                    return response()->json([
                        'status' => 201,
                        "message" => "Add to Cart"
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    "message" => "Product Not Found"
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                "message" => "Login to Add to Cart"
            ]);
        }
    }

    public function viewCart()
    {

        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;

            // $cart = Cart::where('user_id', $user_id)->get();
            $cart = DB::table('cart')->join('product_color', 'cart.product_id', '=', 'product_color.id')->join('products', 'product_color.product_id', '=', 'products.id')->join('color', 'product_color.color_id', '=', 'color.id')->select('cart.*', 'product_color.price', 'products.name as productName', 'products.photo', 'color.name as colorName', 'product_color.qty as qty')->where('user_id', $user_id)->get();
            return response()->json([
                'status' => 200,
                "cart" => $cart
            ]);
        } else {
            return response()->json([
                'status' => 401,
                "message" => "Login to View Cart"
            ]);
        }
    }
}
