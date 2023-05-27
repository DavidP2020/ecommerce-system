<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //

    public function viewCategory(Request $req)
    {
        $category = Category::all();
        return response()->json([
            'status' => 200,
            'message' => "Get data category Successfull",
            'category' => $category
        ]);
    }
    public function getCategory(Request $req)
    {
        $category = Category::where('status', '1')->get();
        return response()->json([
            'status' => 200,
            'message' => "Get data category Successfull",
            'category' => $category
        ]);
    }

    public function addCategory(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|max:191',
            'slug' => 'required|max:191',
            'photo' => 'required',
            'description' => 'max:255',
            'photo' => 'required|max:2048|image|mimes:jpg,png,jpeg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 403,
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $category = new Category();
            $category->name = $req->input('name');
            $category->slug = $req->input('slug');
            $category->description = $req->input('description');
            $category->status = $req->input('status') == true ? '1' : '0';
            if ($req->hasFile('photo')) {
                $file = $req->file('photo');
                $ext = $file->getClientOriginalExtension();

                $fileName = time() . '.' . $ext;
                $file->move('uploads/category/', $fileName);
                $category->photo = 'uploads/category/' . $fileName;
            }
            $category->save();

            return response()->json([
                'status' => 200,
                'message' => "Category Added Successfully",
            ]);
        }
    }
    public function updateCategory(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|max:191',
            'slug' => 'required|max:191',
            'description' => 'max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $category = Category::find($id);

            if ($category) {
                $category->name = $req->input('name');
                $category->slug = $req->input('slug');
                $category->description = $req->input('description');
                if ($req->hasFile('photo')) {
                    $path = $category->photo;
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                    $file = $req->file('photo');
                    $ext = $file->getClientOriginalExtension();

                    $fileName = time() . '.' . $ext;
                    $file->move('uploads/category/', $fileName);
                    $category->photo = 'uploads/category/' . $fileName;
                }
                $category->status = $req->input('status') == true ? '1' : '0';
                $category->update();

                return response()->json([
                    'status' => 200,
                    'message' => "Category Updated Successfully",
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "Category ID Not Found",
                ]);
            }
        }
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->delete();
            return response()->json([
                'status' => 200,
                'message' => "Category Deleted Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Category ID Not Found",
            ]);
        }
    }
}
