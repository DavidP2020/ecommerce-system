<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderControlller extends Controller
{
    //
    public function placeOrder(Request $req)
    {
        if (auth()->user()) {
            if (auth()->user()->is_verified === 1) {

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
                    $user_id = auth()->user()->id;

                    $order = new Order();
                    $order->user_id = auth()->user()->id;
                    $order->name = $req->input('name');
                    $order->phoneNum = $req->input('phoneNum');
                    $order->email = $req->input('email');
                    $order->address = $req->input('address');
                    $order->city = $req->input('city');
                    $order->state = $req->input('state');
                    $order->zip = $req->input('zip');
                    $order->payment_mode = $req->input('payment_mode');
                    $order->gross_amount = $req->input('gross_amount');

                    if ($req->input('payment_mode') == 'COD') {
                        $order->transaction_id = 'Ecommerce' . rand(1111, 9999);
                        $order->order_id = 'Order' . rand(1111, 9999);
                        $order->status = $req->input('status');
                    } else {
                        $order->transaction_id = $req->input('transaction_id');
                        $order->order_id = $req->input('order_id');
                        $order->payment_code = $req->input('payment_code');
                        $order->pdf_url = $req->input('pdf_url');
                        $order->status = $req->input('status');
                    }
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

                        if ($order->status == 'settlement') {
                            $order->paidBy = $req->input('paidBy');
                            $item->product->update([
                                'qty' => $item->product->qty - $item->product_qty
                            ]);
                        }
                    }

                    $order->orderitems()->createMany($orderitems);
                    Cart::destroy($cart);

                    return response()->json([
                        'status' => 200,
                        'message' => "Order Added Successfully",
                        'mid' => env("MIDTRANS_SERVER_KEY"),
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 403,
                    "message" => "Please Verified Your Account First!"
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                "message" => "Login for Checkout"
            ]);
        }
    }

    public function paymentOrder(Request $req, $id)
    {
        if (auth()->user()) {
            if (auth()->user()->is_verified === 1) {

                $order = Order::find($id);
                if ($order) {
                    if ($req->input('payment_mode') == 'COD') {
                        $order->transaction_id = 'Ecommerce' . rand(1111, 9999);
                        $order->order_id = 'Order' . rand(1111, 9999);
                        $order->status = $req->input('status');
                    } else {
                        $order->transaction_id = $req->input('transaction_id');
                        $order->order_id = $req->input('order_id');
                        $order->payment_code = $req->input('payment_code');
                        $order->pdf_url = $req->input('pdf_url');
                        $order->status = $req->input('status');
                    }
                    $order->update();

                    $ord = OrderItems::where('order_id', $id)->get();
                    foreach ($ord as $item) {
                        if ($order->status == 'settlement') {
                            $order->paidBy = $req->input('paidBy');
                            $item->product->update([
                                'qty' => $item->product->qty - $item->qty
                            ]);
                        }
                    }

                    return response()->json([
                        'status' => 200,
                        'message' => "Pembayaran Berhasil",
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 403,
                    "message" => "Please Verified Your Account First!"
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                "message" => "Login for Checkout"
            ]);
        }
    }

    public function cancelOrder(Request $req, $id)
    {
        if (auth()->user()) {
            $order = Order::find($id);
            if ($order) {
                $order->status = $req->input('status');
                $order->cancelBy = $req->input('cancelBy');
                if ($req->input('status') == "Cancel") {
                    $ord = OrderItems::where('order_id', $id)->get();
                    foreach ($ord as $item) {
                        $item->product->update([
                            'qty' => $item->product->qty + $item->qty
                        ]);
                    }
                    $order->update();
                    return response()->json([
                        'status' => 200,
                        'message' => "Cancel Order Successfully",
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "Order ID Not Found",
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
        if (auth()->user()) {
            if (auth()->user()->is_verified === 1) {

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
                    'status' => 403,
                    "message" => "Please Verified Your Account First!"
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                "message" => "Login for Checkout"
            ]);
        }
    }

    public function viewOrder(Request $req, $id)
    {
        if (auth()->user()) {
            $admin = User::where('id', $id)->first();

            if ($admin->role == 'ADMIN') {
                $order = Order::all();
            } else {
                $order = Order::where('user_id', $id)->get();
            }

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
        if (auth()->user()) {
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

    public function setPayment(Request $req, $id)
    {
        if (auth()->user()) {
            $paid = Order::find($id);
            if ($paid) {
                $paid->status = $req->input('status');
                $paid->acceptBy = $req->input('acceptBy');
                $paid->update();

                return response()->json([
                    'status' => 200,
                    'message' => "Transaction Paid",
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    "message" => "Transaction Not Found"
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                "message" => "Login to View Order Status"
            ]);
        }
    }

    public function payment(Request $req)
    {
        if (auth()->user()) {
            if (auth()->user()->is_verified === 1) {

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
                    // Set your Merchant Server Key
                    \Midtrans\Config::$serverKey = env("MIDTRANS_SERVER_KEY");
                    // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
                    \Midtrans\Config::$isProduction = false;
                    // Set sanitization on (default)
                    \Midtrans\Config::$isSanitized = true;
                    // Set 3DS transaction for credit card to true
                    \Midtrans\Config::$is3ds = true;
                    $user_id = auth()->user()->id;
                    $cart = Cart::where('user_id', $user_id)->get();
                    // $Sum = DB::table('cart')
                    //     ->join('product_color', 'cart.product_id', '=', 'product_color.id')
                    //     ->where('user_id', $user_id)
                    //     ->sum('cart.quantity');
                    foreach ($cart as $item) {
                        // $gross = $item->product_qty * $item->product->price;
                        $params = array(
                            'transaction_details' => array(
                                'order_id' => rand(),
                                'gross_amount' => $req->get('gross_amount'),
                            ),
                            'customer_details' => array(
                                'first_name' => $req->get('name'),
                                'last_name' => "",
                                'email' => $req->get('email'),
                                'phone' => $req->get('phoneNum'),
                            ),
                        );
                    }


                    $snapToken = \Midtrans\Snap::getSnapToken($params);

                    return response()->json([
                        'status' => 200,
                        'snapToken' => $snapToken,
                        'message' => "Order Added Successfully",
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 403,
                    "message" => "Please Verified Your Account First!"
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                "message" => "Login to View Order Status"
            ]);
        }
    }

    public function paymentOrderCheck(Request $req, $id)
    {
        if (auth()->user()) {
            if (auth()->user()->is_verified === 1) {

                // Set your Merchant Server Key
                \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_K');
                // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
                \Midtrans\Config::$isProduction = false;
                // Set sanitization on (default)
                \Midtrans\Config::$isSanitized = true;
                // Set 3DS transaction for credit card to true
                \Midtrans\Config::$is3ds = true;
                $user_id = auth()->user()->id;
                $order = Order::where('user_id', $user_id)->where('id', $id)->first();
                $params = array(
                    'transaction_details' => array(
                        'order_id' => rand(),
                        'gross_amount' => $order->gross_amount,
                    ),
                    'customer_details' => array(
                        'first_name' => $order->name,
                        'last_name' => "",
                        'email' => $order->email,
                        'phone' => $order->phoneNum,
                    ),
                );


                $snapToken = \Midtrans\Snap::getSnapToken($params);

                return response()->json([
                    'status' => 200,
                    'snapToken' => $snapToken,
                    'message' => "Order Added Successfully",
                ]);
            } else {
                return response()->json([
                    'status' => 403,
                    "message" => "Please Verified Your Account First!"
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                "message" => "Login to View Order Status"
            ]);
        }
    }

    public function analystData(Request $req)
    {
        if (auth()->user()) {
            $totalProduct = Product::all()->count();
            $totalCategory = Category::all()->count();
            $totalUser = User::where('role', 'USER')->where('status', 1)->count();

            $totalOrder = Order::where('user_id', auth()->user()->id)->count();
            $totalOrderAll = Order::all()->count();

            $totalPurchase = Order::where('status', '=', "settlement")->where('user_id', auth()->user()->id)->count();
            $totalMoneyPurchasing = Order::where('status', '=', "settlement")->where('user_id', auth()->user()->id)->sum('gross_amount');
            $totalMoneyPurchasingAll = Order::where('status', '=', "settlement")->sum('gross_amount');
            $totalPurchaseAll = Order::where('status', '=', "settlement")->count();

            $totalUnpaid = Order::where('status', '!=', "settlement")->where('user_id', auth()->user()->id)->count();
            $totalMoneyUnpaid = Order::where('status', '!=', "settlement")->where('user_id', auth()->user()->id)->sum('gross_amount');
            $totalUnpaidAll = Order::where('status', '!=', "settlement")->count();
            return response()->json([
                'status' => 200,
                "totalOrder" => $totalOrder,
                "totalOrderAll" => $totalOrderAll,
                "totalPurchase" => $totalPurchase,
                "totalMoneyPurchasing" => $totalMoneyPurchasing,
                "totalMoneyPurchasingAll" => $totalMoneyPurchasingAll,
                "totalPurchaseAll" => $totalPurchaseAll,
                "totalUnpaid" => $totalUnpaid,
                "totalMoneyUnpaid" => $totalMoneyUnpaid,
                "totalUnpaidAll" => $totalUnpaidAll,
                "totalProduct" => $totalProduct,
                "totalCategory" => $totalCategory,
                "totalUser" => $totalUser,
                "user" => auth()->user(),
            ]);
        } else {
            return response()->json([
                'status' => 401,
                "message" => "Login to View Data Dashboard"
            ]);
        }
    }
}
