<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderControlller extends Controller
{
    //
    public function placeOrder(Request $req)
    {
        if (auth('sanctum')->check()) {
            $validator = Validator::make($req->all(), [
                'name' => 'required|max:191',
                'phoneNum' => 'required|max:191',
                'email' => 'required|max:191',
                'address' => 'required|max:191',
                'city' => 'required|max:191',
                'state' => 'required|max:191',
                'zip' => 'required|max:191',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'validation_errors' => $validator->messages(),
                ]);
            } else {
                $user_id = auth('sanctum')->user()->id;

                $order = new Order();
                $order->user_id = auth('sanctum')->user()->id;
                $order->name = $req->input('name');
                $order->phoneNum = $req->input('phoneNum');
                $order->email = $req->input('email');
                $order->address = $req->input('address');
                $order->city = $req->input('city');
                $order->state = $req->input('state');
                $order->zip = $req->input('zip');
                $order->payment_mode = $req->input('payment_mode');
                $order->tracking_no = 'fundaecom' . rand(1111, 9999);
                $order->status = $req->input('status') == true ? '1' : '0';
                $order->remark = "Remark";
                $order->save();

                $cart = Cart::where('user_id', $user_id)->get();
                $orderitems = [];
                foreach ($cart as $item) {
                    $orderitems[] = [
                        'product_id' => $item->product_id,
                        'color' => $item->product->color_id,
                        'qty' => $item->product_qty,
                        'price' => $item->product->price,
                    ];

                    $item->product->update([
                        'qty' => $item->product->qty - $item->product_qty
                    ]);
                }

                $order->orderitems()->createMany($orderitems);
                Cart::destroy($cart);

                return response()->json([
                    'status' => 200,
                    'message' => "Order Added Successfully",
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                "message" => "Login for Checkout"
            ]);
        }
    }

    public function validateOrder(Request $req)
    {
        if (auth('sanctum')->check()) {
            $validator = Validator::make($req->all(), [
                'name' => 'required|max:191',
                'phoneNum' => 'required|max:191',
                'email' => 'required|max:191',
                'address' => 'required|max:191',
                'city' => 'required|max:191',
                'state' => 'required|max:191',
                'zip' => 'required|max:191',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'validation_errors' => $validator->messages(),
                ]);
            } else {

                return response()->json([
                    'status' => 200,
                    'message' => "Form Validated Successfully",
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                "message" => "Login for Checkout"
            ]);
        }
    }

    public function viewOrder(Request $req)
    {
        if (auth('sanctum')->check()) {

            $order = Order::all();


            return response()->json([
                'status' => 200,
                'message' => "Get data Order Successfull",
                'order' => $order,
            ]);
        } else {
            return response()->json([
                'status' => 401,
                "message" => "Login to View Order Status"
            ]);
        }
    }

    public function viewDetailOrder(Request $req, $id)
    {
        if (auth('sanctum')->check()) {
            $orderDetail = DB::table('orders')
                ->join('orders_items', 'orders_items.order_id', '=', 'orders.id')
                ->join('color', 'color.id', '=', 'orders_items.color')
                ->join('product_color', 'product_color.id', '=', 'orders_items.product_id')
                ->join('products', 'products.id', '=', 'product_color.product_id')
                ->join('brand', 'brand.id', '=', 'products.brand_id')
                ->select('orders_items.qty', 'orders_items.price', 'color.name as colorName', 'products.name as productName', 'products.weight', 'products.unit', 'brand.name as brandName')
                ->where('orders.id', '=', $id)->get();


            return response()->json([
                'status' => 200,
                'orderDetail' => $orderDetail,
            ]);
        } else {
            return response()->json([
                'status' => 401,
                "message" => "Login to View Order Status"
            ]);
        }
    }
}
