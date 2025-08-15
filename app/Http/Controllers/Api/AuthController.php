<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\FrontForgetPassword;
use App\Mail\WelcomeMail;
use App\Models\Log;
use App\Models\User;
use Auth;
use Password;
use Session;

class AuthController extends Controller
{
    public function login(Request $request){
        try {
            $rules = [
                'email' => 'required',
                'password' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorMessage = $validator->errors()->first();

                return errorResponse($errorMessage, $validator->messages());
            }
            $user = User::where('email', $request->email)->whereIn('role_id',[3,4])->first();
            if($user){
                if ($user->status != 1) { // 1 means active; any other value means inactive
                    return response()->json([
                        'status' => 0,
                        'message' => 'You are not an active. Please contact support.',
                    ], 403); // HTTP status code 403 (Forbidden)
                }
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    // $user = Auth::user();
                    $user = User::where('email', $request->email)->first();
                    auth()->guard('api')->setUser($user);
                    $user = Auth::guard('api')->user();
                    $token = $user->createToken('user')->accessToken;
                    // save session for user to logout on different devices
                    $sessionId = Session::getId();
                    Auth::guard('api')->user()->update([
                        'current_session_id' => $sessionId,
                        'timezone' => $request->timezone,
                    ]);
                    // Session::put('current_session_api_id', $sessionId);
                    return successResponse('Login Successful', ['token' => $token, 'user' => $user]);
                } else{
                    return errorResponse("These credentials do not match our records.");
                }
            } else{
                return errorResponse("Your account does not exist. Please register first");
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'AuthController',
                'module' => 'login',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return errorResponse($th->getMessage());
        }
    }

    public function register(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:50',
                'dob' => 'required|date',
                'time_of_birth' => 'nullable|string|max:10',
                'place_of_birth' => 'nullable|string|max:255',
                'mobile_number_1' => 'required',
                'mobile_number_2' => 'nullable',
                'email' => 'required|email|max:255|unique:users,email',
                'role_id' => 'required|integer',
                'discomfort' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'password' => 'required|string|min:6|same:conpassword',
                'conpassword' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors(),
                ], 400);
            }

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('storage/users'), $imageName);
                $imagePath = $imageName;
            }
            $user = User::create([
                'name' => $request->name,
                'dob' => $request->dob,
                'time_of_birth' => $request->time_of_birth,
                'place_of_birth' => $request->place_of_birth,
                'mobile_number_1' => $request->mobile_number_1,
                'mobile_number_2' => $request->mobile_number_2,
                'email' => $request->email,
                'role_id' => $request->role_id,
                'discomfort' => $request->discomfort,
                'image' => $imagePath,
                'password' => Hash::make($request->password),
                'oauth_id' => $request->oauth_id,
            ]);

            auth()->guard('api')->setUser($user);
            $user = Auth::guard('api')->user();

            $token = $user->createToken('user')->accessToken;

            Mail::to($user->email)->send(new WelcomeMail(['name' => $user->name]));

            // save session for user to logout on different devices
            $sessionId = Session::getId();
            Auth::guard('api')->user()->update([
                'current_session_id' => $sessionId,
                'timezone' => $request->timezone,
            ]);

            return successResponse('User register successfully', [ 'token' => $token, 'user' => $user]);

        } catch (Exception $e) {

            $data = [
                'name' => 'AuthController',
                'module' => 'register',
                'description' => $e->getMessage(),
            ];
            Log::create($data);

            return errorResponse($e->getMessage());
        }
    }
    public function changepassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required',
                'new_password' => 'required',
                'confirm_password' => 'required|same:new_password',
            ]);
            if (Hash::check($request->password, Auth::guard('api')->user()->password)) {
                Auth::guard('api')->user()->update(['password' => Hash::make($request->new_password)]);
                return successResponse('Password changed successfully');
            } else {
                return errorResponse('Current password does not match');
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'AuthController',
                'module' => 'changepassword',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return errorResponse($th->getMessage());

        }
    }

    public function forgot_password(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 400);
            }
            DB::beginTransaction();
            $password = rand(100000, 999999);
            $user = User::where('email', $request->email)->whereIn('role_id',[3,4])->first();
            if($user != null){
                $user->password = Hash::make($password);
                $user->save();
                Mail::to($request->email)->send(new FrontForgetPassword(['name' => $user->name, 'password' => $password]));
                DB::commit();
                return response()->json(['status' => 'success','message' => 'Your new password has been sent to your email successfully.'],200);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'User does not exist',
                ],400);
            }
        }catch (\Throwable $th) {
            DB::rollBack();
            $data = [
                'name' => 'AuthController',
                'module' => 'forgot_password',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
        }
    }

    public function logout(Request $request)
    {
        try {
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user()->token();
                $user->revoke();
                return successResponse('User logout successfully');
            } else {
                return errorResponse('Something went wrong, Please try again later');
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'AuthController',
                'module' => 'logout',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return errorResponse($th->getMessage());
        }
    }
}
