<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    //
     public function viewBrand(Request $req){
        $brand = Brand::all();
          return response()->json([
            'status' => 200,
            'message' => "Get data brand Successfull",
            'brand' => $brand
        ]);
    }
    public function getBrand(Request $req){
        $brand = Brand::where('status','1')->get();
          return response()->json([
            'status' => 200,
            'message' => "Get data brand Successfull",
            'brand' => $brand
        ]);
    }

    public function addBrand(Request $req){
        $validator = Validator::make($req->all(), [
            'name' => 'required|max:191',
        ]);
    
        if($validator->fails()){    
            return response()->json([
                'status' => 403,
                'validation_errors' => $validator->messages(),
            ]);
        }
        else{
        $brand = new Brand();
        $brand->name = $req->input('name');
        $brand->status = $req->input('status') == true ? '1' : '0';
        $brand->save();
        
        return response()->json([
            'status' => 200,
            'message' => "Brand Added Successfully",
        ]);
        }
    }
    
   public function updateBrand(Request $req, $id){
        $validator = Validator::make($req->all(), [
            'name' => 'required|max:191',
        ]);
    
        if($validator->fails()){    
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->messages(),
            ]);
        }
        else{
            $category = Brand::find($id);

            if($category){
                $category->name = $req->input('name');
                $category->status = $req->input('status') == true ? '1' : '0';
                $category->update();
                
                return response()->json([
                    'status' => 200,
                    'message' => "Category Updated Successfully",
                ]);
                
            }
            else{
                return response()->json([
                    'status' => 404,
                    'message' => "Category ID Not Found",
                ]);
            }
       }
    }
    
    public function deleteBrand($id){
         $brand = Brand::find($id);

            if($brand){
                $brand->delete();
                return response()->json([
                    'status' => 200,
                    'message' => "Brand Deleted Successfully",
                ]);

            }
            else{
                return response()->json([
                    'status' => 404,
                    'message' => "Brand ID Not Found",
                ]);
            }
    }
}
