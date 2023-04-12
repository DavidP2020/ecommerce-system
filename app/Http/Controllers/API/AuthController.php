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
                    'username' => $user->name,
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
}
