<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
    public function viewProduct(Request $req)
    {
        $product = Product::all();
        return response()->json([
            'status' => 200,
            'message' => "Get data products Successfull",
            'product' => $product
        ]);
    }

    public function getDetail($id)
    {
        $getDetail = DB::table('product_color')->join('products', 'product_id', '=', 'products.id')->join('color', 'color_id', '=', 'color.id')->select('product_color.*', 'color.name as colorName', 'products.name')->where('product_id', 'like', $id)->get();
        return response()->json([
            'status' => 200,
            'message' => "Get Data Detail Product Successfull",
            'getDetail' => $getDetail
        ]);
    }

    public function addProduct(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'category_id' => 'required|max:191',
            'name' => 'required|max:191',
            'slug' => 'required|max:191',
            'photo' => 'required',
            'photo.*' => 'required|max:2048|image|mimes:jpg,png,jpeg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 403,
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $product = new Product();
            $product->category_id = $req->input('category_id');
            $product->name = $req->input('name');
            $product->slug = $req->input('slug');
            $product->description = $req->input('description');
            $product->brand_id = $req->input('brand_id');


            if ($req->hasFile('photo')) {
                $file = $req->file('photo');
                $ext = $file->getClientOriginalExtension();

                $fileName = time() . '.' . $ext;
                $file->move('uploads/products/', $fileName);
                $product->photo = 'uploads/products/' . $fileName;
            }

            $product->status = $req->input('status') == true ? '1' : '0';

            $product->save();

            return response()->json([
                'status' => 200,
                'message' => "Products Added Successfully",
            ]);
        }
    }

    public function addDetailProduct(Request $req, $id)
    {
        $detailProduct = Product::find($id);
        $validator = Validator::make($req->all(), [
            'color_id' => 'required|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 403,
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            if ($detailProduct) {
                if ($req->input('color_id')) {
                    if ($detailProduct->colors()->where('color_id', $req->input('color_id'))->get()->isEmpty()) {
                        $detailProduct->colors()->attach($req->input('color_id'), ['weight' => $req->weight, 'qty' => $req->qty, 'original_price' => $req->original_price, 'price' => $req->price, 'status' => $req->status]);

                        $detailProduct->save();
                        return response()->json([
                            'status' => 200,
                            'message' => "Detail Products Added Successfully",
                        ]);
                    } else {
                        $detailProduct->colors()->updateExistingPivot($req->input('color_id'), ['weight' => $req->weight, 'qty' => $req->qty, 'original_price' => $req->original_price, 'price' => $req->price, 'status' => $req->status]);
                        return response()->json([
                            'status' => 200,
                            'message' => "Detail Products Updated Successfully",
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "Detail Products ID Not Found",
                ]);
            }
        }
    }

    public function updateProduct(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'category_id' => 'required|max:191',
            'name' => 'required|max:191',
            'slug' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $product = Product::find($id);

            if ($product) {
                $product->category_id = $req->input('category_id');
                $product->name = $req->input('name');
                $product->slug = $req->input('slug');
                $product->brand_id = $req->input('brand_id');
                $product->description = $req->input('description');

                if ($req->hasFile('photo')) {
                    $path = $product->photo;
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                    $file = $req->file('photo');
                    $ext = $file->getClientOriginalExtension();

                    $fileName = time() . '.' . $ext;
                    $file->move('uploads/products/', $fileName);
                    $product->photo = 'uploads/products/' . $fileName;
                }

                $product->status = $req->input('status') == true ? '1' : '0';

                $product->update();

                return response()->json([
                    'status' => 200,
                    'message' => "Products Updated Successfully",
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "Products ID Not Found",
                ]);
            }
        }
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return response()->json([
                'status' => 200,
                'message' => "Product Deleted Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Product ID Not Found",
            ]);
        }
    }

    public function deleteDetailProduct($id)
    {
        $detailProduct = Product_Color::find($id);

        if ($detailProduct) {
            $detailProduct->delete();
            return response()->json([
                'status' => 200,
                'message' => "Detail Product Deleted Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Detail Product ID Not Found",
            ]);
        }
    }

    public function fetchProduct($slug)
    {
        $category = Category::where('slug', $slug)->where('status', '1')->first();
        if ($category) {
            // $product = Product::where('category_id', $category->id)->where('status', '0')->get();
            $product = DB::table('products')->join('categories', 'category_id', '=', 'categories.id')->select('products.*', 'categories.slug as slugName', 'categories.name as categoryName')->where('category_id', $category->id)->where('products.status', '1')->get();

            if ($product) {
                return response()->json([
                    'status' => 200,
                    'product' => $product
                ]);
            }
        }
    }

    public function fetchDetailProduct($slug, $productSlug)
    {
        $category = Category::where('slug', $slug)->where('status', '1')->first();
        if ($category) {
            $product = DB::table('products')
                ->join(
                    'categories',
                    'category_id',
                    '=',
                    'categories.id'
                )->join('brand', 'brand_id', '=', 'brand.id')
                ->select('products.*', 'categories.slug as slugName', 'categories.name as categoryName', 'brand.name as brandName')
                ->where('category_id', $category->id)
                ->where(
                    'products.slug',
                    $productSlug
                )->where('products.status', '1')
                ->get();

            $getDetail = DB::table('product_color')
                ->join('products', 'product_color.product_id', '=', 'products.id')
                ->join('color', 'product_color.color_id', '=', 'color.id')
                ->select('product_color.id as _id', 'product_color.product_id', 'product_color.color_id', 'product_color.qty', 'product_color.price', 'product_color.status', 'color.*', 'color.name as colorName', 'products.name')
                ->where('products.slug', 'like', $productSlug)
                ->get();

            $Sum = DB::table('product_color')
                ->join('products', 'product_id', '=', 'products.id')
                ->join('color', 'color_id', '=', 'color.id')
                ->select('product_color.*', 'color.*', 'color.name as colorName', 'products.name')
                ->where('products.slug', 'like', $productSlug)
                ->sum('product_color.qty');


            if ($product) {
                return response()->json([
                    'status' => 200,
                    'product' => $product,
                    'detailProduct' => $getDetail,
                    'total' => $Sum
                ]);
            }
        }
    }

    public function getDetailItem($id)
    {

        $detailProduct = DB::table('product_color')->join('products', 'product_id', '=', 'products.id')->join('color', 'color_id', '=', 'color.id')->select('product_color.*', 'color.name as colorName', 'products.name')->where('product_color.id', 'like', $id)->get();
        return response()->json([
            'status' => 200,
            'message' => "Get Data Detail Product Successfull",
            'getDetail' => $detailProduct
        ]);
    }
}
