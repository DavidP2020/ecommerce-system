<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\verifMail;
use App\Models\Order;
use App\Models\PasswordReset;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login']]);
    // }
    //Register
    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|string|confirmed',
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
            return response()->json([
                'status' => 200,
                'username' => $req->name,
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
        }

        $user = User::where('email', $req->email)->first();
        if (!$user) {
            return response()->json([
                'status' => 403,
                'message' => "Invalid Credentials",
            ]);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json([
                'status' => 402,
                'message' => "Username & Password is Incorrect",
            ]);
        }

        return $this->respondWithToken($token);
        // else {

        //     $user = User::where('email', $req->email)->first();

        //     if (!$user || !Hash::check($req->password, $user->password)) {
        //         return response()->json([
        //             'status' => 403,
        //             'message' => "Invalid Credentials",
        //         ]);
        //     } else {
        //         $token = $user->createToken($user->email . '_Token')->plainTextToken;

        //         return response()->json([
        //             'status' => 200,
        //             'id' => $user->id,
        //             'username' => $user->name,
        //             'email' => $user->email,
        //             'role' => $user->role,
        //             'token' => $token,
        //             'message' => "Login Successfully",
        //         ]);
        //     }
        // }
    }
    protected function respondWithToken($token)
    {

        return response()->json([
            'status' => 200,
            'token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60,
            'message' => "Login Successfully",
            'id' => auth()->user()->id,
            'username' => auth()->user()->name,
            'email' => auth()->user()->email,
            'role' => auth()->user()->role,
        ]);
    }
    public function refresh()
    {
        if (auth()->user()) {
            return $this->respondWithToken(auth('api')->refresh());
        } else {
            return response()->json([
                'status' => 401,
                "message" => "User is not Authenticated."
            ]);
        }
    }
    public function me()
    {
        return response()->json(auth()->user());
    }
    public function logout()
    {
        try {
            auth()->logout();
            return response()->json([
                'message' => 'Logged out successfully!',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 403
            ], 403);
        }
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

            if ($user) {
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
            } else {
                return response()->json([
                    'status' => 404,
                    "message" => "User Not Found"
                ]);
            }
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
                "message" => "User Not Found"
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
        $validator = Validator::make($req->all(), [
            'oldPassword' => 'required|min:8|string',
            'password' => 'required|min:8|string|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 403,
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $user = User::find($id);
            if ($user) {
                if (Hash::check($req->oldPassword, $user->password)) {
                    $user->password = Hash::make($req->password);
                    $user->update();

                    return response()->json([
                        'status' => 200,
                        'message' => "Change Password Successfull Updated",
                    ]);
                } else {
                    return response()->json([
                        'status' => 402,
                        'message' => [
                            'errors' => "Old Password Doesn't Match"
                        ],
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

    public function sendVerifyMail($email)
    {
        if (auth()->user()) {
            $user = User::where('email', $email)->get();

            if (count($user) > 0) {
                $random = Str::random(40);
                $domain = URL::to('/');
                $url = $domain . '/verify-mail/' . $random;

                $data['url'] = $url;
                $data['username'] = $user[0]->name;
                $data['ecommerce'] = "Ecommerce";
                $data['email'] = $email;
                $data['title'] = 'Email Verification';
                $data['body'] = "Verify your account.";

                // Mail::to("dasdsa@gmail.com0")->send(new verifMail());

                Mail::send('verifyEmail', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });

                $user = User::find($user[0]['id']);
                $user->remember_token = $random;
                $user->save();

                return response()->json([
                    'status' => 200,
                    "message" => "Mail Send Successfully"
                ]);
            } else {
                return response()->json([
                    'status' => 401,
                    "message" => "User is Not Found"
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                "message" => "User is Not Authentication"
            ]);
        }
    }

    public function forgotPassword(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'email' => 'required|email|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 403,
                    'validation_errors' => $validator->messages(),
                ]);
            } else {
                $user = User::where('email', $req->email)->get();

                if (count($user) > 0) {
                    $token = Str::random(40);
                    $domain = URL::to('/');
                    $url = $domain . '/reset-password?token=' . $token;

                    $data['url'] = $url;
                    $data['username'] = $user[0]->name;
                    $data['ecommerce'] = "Ecommerce";
                    $data['email'] = $req->email;
                    $data['title'] = 'Password Reset';
                    $data['body'] = "Reset your Password.";

                    Mail::send('forgetPasswordMail', ['data' => $data], function ($message) use ($data) {
                        $message->to($data['email'])->subject($data['title']);
                    });

                    $dateTime = Carbon::now()->format('Y-m-d H:i:s');
                    PasswordReset::updateOrCreate(
                        ['email' => $req->email],
                        [
                            'email' => $req->email,
                            'token' => $token,
                            'created_at' => $dateTime,
                        ]
                    );
                    return response()->json([
                        'status' => 200,
                        "message" => "Please Check Your Mail To Reset Your Password"
                    ]);
                } else {
                    return response()->json([
                        'status' => 401,
                        "message" => "User is Not Found"
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 403
            ], 403);
        }
    }

    public function verifyMailToken($token)
    {
        try {
            $user = User::where('remember_token', $token)->get();

            if (count($user) > 0) {
                $dateTime = Carbon::now()->format('Y-m-d H:i:s');
                $user = User::find($user[0]['id']);
                $user->is_verified = 1;
                $user->remember_token = '';
                $user->email_verified_at = $dateTime;
                $user->save();
                return view('successVerify');
            } else {
                return response()->json([
                    'status' => 401,
                    "message" => "User is Not Found"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 403
            ], 403);
        }
    }

    public function resetPasswordLoad(Request $req)
    {
        $resetData = PasswordReset::where('token', $req->token)->get();
        if (isset($req->token) && count($resetData) > 0) {
            $user = User::where('email', $resetData[0]['email'])->get();
            return view('resetPassword', compact('user'));
        } else {
            return view('404');
        }
    }

    public function resetPassword(Request $req)
    {
        $req->validate([
            'password' => 'required|min:8|string|confirmed',
        ]);

        $user = User::find($req->id);
        $user->password = Hash::make($req->password);
        $user->save();

        PasswordReset::where('email', $user->email)->delete();

        return view('successReset');
    }

    // public function exportPDF()
    // {
    //     // retreive all records from db
    //     $data = Order::all();
    //     // share data to view
    //     // view()->share('employee', $data);
    //     $pdf = PDF::loadview('PDF.laporan_penjualan', ['data' => $data]);
    //     return $pdf->download('laporan_penjualan-pdf');
    // }


}
