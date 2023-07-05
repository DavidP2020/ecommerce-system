<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    //
    public function viewColor(Request $req)
    {
        $color = Color::all();
        return response()->json([
            'status' => 200,
            'message' => "Get data color Successfull",
            'color' => $color
        ]);
    }
    public function getColor(Request $req)
    {
        $color = Color::where('status', '1')->get();
        return response()->json([
            'status' => 200,
            'message' => "Get data color Successfull",
            'color' => $color
        ]);
    }

    public function addColor(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 403,
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $color = new Color();
            $color->name = $req->input('name');
            $color->color = $req->input('color');
            $color->status = $req->input('status') == true ? '1' : '0';
            $color->save();

            return response()->json([
                'status' => 200,
                'message' => "Color Added Successfully",
            ]);
        }
    }

    public function updateColor(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $color = Color::find($id);

            if ($color) {
                $color->name = $req->input('name');
                $color->color = $req->input('color');
                $color->status = $req->input('status') == true ? '1' : '0';
                $color->update();

                return response()->json([
                    'status' => 200,
                    'message' => "Color Updated Successfully",
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "Color ID Not Found",
                ]);
            }
        }
    }

    public function deleteColor($id)
    {
        $color = Color::find($id);

        if ($color) {
            $color->delete();
            return response()->json([
                'status' => 200,
                'message' => "Color Deleted Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Color ID Not Found",
            ]);
        }
    }
}
