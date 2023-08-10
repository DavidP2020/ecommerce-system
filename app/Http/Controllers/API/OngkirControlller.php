<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ongkir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OngkirControlller extends Controller
{
    public function viewOngkir(Request $req)
    {
        $ongkir = Ongkir::all();
        return response()->json([
            'status' => 200,
            'message' => "Get data Color Successfull",
            'ongkir' => $ongkir
        ]);
    }
    public function getOngkirId(Request $req, $id)
    {
        $ongkir = Ongkir::where('location', '=', $id)->first();
        return response()->json([
            'status' => 200,
            'message' => "Get data ongkir Successfull",
            'ongkir' => $ongkir
        ]);
    }

    public function addOngkir(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'location' => 'required|max:191',
            'fee' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 403,
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $ongkir = new Ongkir();
            $ongkir->location = $req->input('location');
            $ongkir->fee = $req->input('fee');
            $ongkir->save();

            return response()->json([
                'status' => 200,
                'message' => "Ongkir Added Successfully",
            ]);
        }
    }

    public function updateOngkir(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'location' => 'required|max:191',
            'fee' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $ongkir = Ongkir::find($id);

            if ($ongkir) {
                $ongkir->location = $req->input('location');
                $ongkir->fee = $req->input('fee');
                $ongkir->update();

                return response()->json([
                    'status' => 200,
                    'message' => "Ongkir Updated Successfully",
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "Ongkir ID Not Found",
                ]);
            }
        }
    }

    public function deleteOngkir($id)
    {
        $ongkir = Ongkir::find($id);

        if ($ongkir) {
            $ongkir->delete();
            return response()->json([
                'status' => 200,
                'message' => "Ongkir Deleted Successfully",
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Ongkir ID Not Found",
            ]);
        }
    }
}
