<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //Register
    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 403,
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $user = User::create([
                'name' => $req->name,
                'email' => $req->email,
                'password' => Hash::make($req->password),
            ]);

            $token = $user->createToken($user->email . '_Token')->plainTextToken;

            return response()->json([
                'status' => 200,
                'username' => $req->name,
                'token' => $token,
                'message' => "Registered Successfully",
            ]);
        }
    }
    //Login
    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|max:255',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 403,
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $user = User::where('email', $req->email)->first();

            if (!$user || !Hash::check($req->password, $user->password)) {
                return response()->json([
                    'status' => 403,
                    'message' => "Invalid Credentials",
                ]);
            } else {
                $token = $user->createToken($user->email . '_Token')->plainTextToken;

                return response()->json([
                    'status' => 200,
                    'id' => $user->id,
                    'username' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'token' => $token,
                    'message' => "Login Successfully",
                ]);
            }
        }
    }

    public function logout()
    {
        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json([
            'message' => 'Logged out successfully!',
            'status' => 200
        ], 200);
    }

    public function setProfile(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|max:255',
            'gender' => 'required|max:255',
            'phoneNum' => 'required|max:255',
            'date_of_birth' => 'required|max:255',
            'place_of_birth' => 'required|max:255',
            'address' => 'required|max:255',
            'state' => 'required|max:255',
            'city' => 'required|max:255',
            'zip' => 'required|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 403,
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $user = User::find($id);
            $user->name = $req->input('name');
            $user->gender = $req->input('gender');
            $user->phoneNum = $req->input('phoneNum');
            $user->place_of_birth = $req->input('place_of_birth');
            $user->date_of_birth = $req->input('date_of_birth');
            $user->address = $req->input('address');
            $user->state = $req->input('state');
            $user->city = $req->input('city');
            $user->zip = $req->input('zip');
            $user->status = $req->input('status') == true ? '1' : '0';
            $user->update();

            return response()->json([
                'status' => 200,
                'message' => "Profile Successfull Updated",
            ]);
        }
    }
    public function setStatus(Request $req, $id)
    {
        $user = User::find($id);
        if ($user) {

            $user->status = $req->input('status');
            $user->update();

            return response()->json([
                'status' => 200,
                'message' => "Status Successfull Updated",
            ]);
        } else {
            return response()->json([
                'status' => 404,
                "message" => "Product Not Found"
            ]);
        }
    }

    public function getProfile($email)
    {
        $userData = User::where('email', $email)->first();
        if ($userData) {
            return response()->json([
                'status' => 200,
                'user' => $userData,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                "message" => "Profile Data Not Found"
            ]);
        }
    }

    public function viewUser(Request $req)
    {
        $user = User::all();
        return response()->json([
            'status' => 200,
            'message' => "Get data User Successfull",
            'category' => $user
        ]);
    }

    public function reset(Request $req, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->password = Hash::make("12345678");
            $user->update();

            return response()->json([
                'status' => 200,
                'message' => "Reset Account Successfull Updated",
            ]);
        } else {
            return response()->json([
                'status' => 404,
                "message" => "Account Not Found"
            ]);
        }
    }
    public function changePass(Request $req, $id)
    {
        $user = User::find($id);
        if ($user) {
            if (Hash::check($req->oldPass, $user->password)) {
                $user->password = Hash::make($req->password);
                $user->update();

                return response()->json([
                    'status' => 200,
                    'message' => "Change Password Successfull Updated",
                ]);
            } else {
                return response()->json([
                    'status' => 403,
                    'message' => "Password Doesn't Match",
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                "message" => "Account Not Found"
            ]);
        }
    }
}
