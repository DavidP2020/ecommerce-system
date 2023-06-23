<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product_Color;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WishListControlller extends Controller
{
    //    
    public function addToWishlist(Request $req)
    {
        if (auth()->user()) {
            $user_id = auth()->user()->id;
            $product_id = $req->product_id;

            $checkWish = Product_Color::where('id', $product_id)->first();
            if ($checkWish) {

                if (Wishlist::where('product_id', $product_id)->where('user_id', $user_id)->exists()) {
                    $wishlist = Wishlist::where('product_id', $product_id)->where('user_id', $user_id)->first();
                    $wishlist->delete();
                    return response()->json([
                        'status' => 200,
                        "message" => "Wishlist Updated"
                    ]);
                } else {
                    $wishItem = new Wishlist;
                    $wishItem->user_id = $user_id;
                    $wishItem->product_id = $product_id;
                    $wishItem->save();

                    return response()->json([
                        'status' => 201,
                        "message" => "Add to Wishlist"
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
                "message" => "Login to Add to Wishlist"
            ]);
        }
    }

    public function viewWish()
    {

        if (auth()->user()) {
            $user_id = auth()->user()->id;

            // $cart = Cart::where('user_id', $user_id)->get();
            $wishlist = DB::table('wishlist')->join('product_color', 'wishlist.product_id', '=', 'product_color.id')->join('products', 'product_color.product_id', '=', 'products.id')->join('color', 'product_color.color_id', '=', 'color.id')->select('wishlist.*', 'product_color.price', 'products.name as productName', 'products.photo', 'color.name as colorName', 'color.color', 'product_color.qty as qty')->where('user_id', $user_id)->get();

            return response()->json([
                'status' => 200,
                "wishlist" => $wishlist
            ]);
        } else {
            return response()->json([
                'status' => 401,
                "message" => "Login to View Wishlist"
            ]);
        }
    }

    public function deleteWish($wish_id)
    {
        if (auth()->user()) {
            $user_id = auth()->user()->id;
            $wishItem = Wishlist::where('id', $wish_id)->where('user_id', $user_id)->first();

            if ($wishItem) {
                $wishItem->delete();
                return response()->json([
                    'status' => 200,
                    "message" => "Wishlist Removed Successfully"
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                "message" => "Login to Remove Wishlist"
            ]);
        }
    }
}
