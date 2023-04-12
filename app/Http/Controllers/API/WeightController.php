<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Weight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeightController extends Controller
{
    //
    public function viewWeight(Request $req){
        $weight = Weight::all();
          return response()->json([
            'status' => 200,
            'message' => "Get data weight Successfull",
            'weight' => $weight
        ]);
    }
    public function getWeight(Request $req){
        $weight = Weight::where('status','1')->get();
          return response()->json([
            'status' => 200,
            'message' => "Get data weight Successfull",
            'weight' => $weight
        ]);
    }

    public function addWeight(Request $req){
        $validator = Validator::make($req->all(), [
            'numWeight' => 'required|max:191',
        ]);
    
        if($validator->fails()){    
            return response()->json([
                'status' => 403,
                'validation_errors' => $validator->messages(),
            ]);
        }
        else{
        $weight = new Weight();
        $weight->numWeight = $req->input('numWeight');
        $weight->status = $req->input('status') == true ? '1' : '0';
        $weight->save();
        
        return response()->json([
            'status' => 200,
            'message' => "Weight Added Successfully",
        ]);
        }
    }
    
    public function updateWeight(Request $req, $id){
      $validator = Validator::make($req->all(), [
        'numWeight' => 'required|max:191'
      ]);

      if ($validator->fails()){
        return response()->json([
            'status' => 422,
            'validation_errors' => $validator->messages(),
        ]);
      }
      else{
        $weight = Weight::find($id);
        if($weight){
            $weight->numWeight = $req->input('numWeight');
            $weight->status = $req->input('status') == true ? '1' : '0';
            $weight->save();
            
            return response()->json([
                'status' => 200,
                'message' => "Weight Updated Successfully",
            ]);
        }
        else{
            return response()->json([
                'status' => 404,
                'message' => "Weight ID Not Found",
            ]);
        }

      }
    }

    public function deleteWeight($id){
         $weight = Weight::find($id);

            if($weight){
                $weight->delete();
                return response()->json([
                    'status' => 200,
                    'message' => "Weight Deleted Successfully",
                ]);

            }
            else{
                return response()->json([
                    'status' => 404,
                    'message' => "Weight ID Not Found",
                ]);
            }
    }
}
