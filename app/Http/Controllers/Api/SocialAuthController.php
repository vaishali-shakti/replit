<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Log;
use Auth;
use DB;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class SocialAuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $rules = [
                'oauth_id' => 'required',
                "email" => "nullable|email|unique:users,email",
            ];
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorMessage = $validator->messages();
                $message = $validator->errors()->first();
                $data = [
                    'name' => 'SocialAuthController',
                    'module' => 'error',
                    'description' => $message,
                ];
                Log::create($data);
                $data = [
                    'name' => 'SocialAuthController',
                    'module' => 'error',
                    'description' => json_encode($request->all()),
                ];
                Log::create($data);
                return errorResponse($message);
            }
            $existing_user = User::where('oauth_id',$request->oauth_id)->first();
           
                if($existing_user == null){
                   
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
                        'role_id' => 3
                    ]);
                    $user->save();
                    $existing_user = User::where('oauth_id',$request->oauth_id)->first();
                    Auth::login($existing_user);
                    auth()->guard('api')->setUser($existing_user);
                    $user = Auth::guard('api')->user();
                    $user->role_id = (string) $user->role_id; // convert role_id to string for application
                    $token = $user->createToken('user')->accessToken;

                    Mail::to($user->email)->send(new WelcomeMail(['name' => $user->name]));

                    // save session for user to logout on different devices
                    $sessionId = Session::getId();
                    Auth::guard('api')->user()->update([
                        'current_session_id' => $sessionId,
                        'timezone' => $request->timezone,
                    ]);

                    return successResponse('Register Successful', ['token' => $token, 'user' => $user]);
                }
                else{
                    $data = [
                        'name' => 'SocialAuthController',
                        'module' => 'error',
                        'description' => 'Email is already registered with us. please login!',
                    ];
                    Log::create($data);
                    return errorResponse('Email is already registered with us. please login!');
                }
            

        } catch (\Throwable $th) {
            $data = [
                'name' => 'SocialAuthController',
                'module' => 'register',
                'description' => $th->getMessage(),
            ];

            Log::create($data);

            return errorResponse($th->getMessage());
        }
    }  

    public function login(Request $request)
    {
        try {

            $rules = [
                'oauth_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorMessage = $validator->errors()->first();
                $data = [
                    'name' => 'SocialAuthController',
                    'module' => 'error',
                    'description' => $errorMessage,
                ];
                Log::create($data);
                return errorResponse($errorMessage);
            }
            $existing_user = User::where('oauth_id',$request->oauth_id)->first();
            if($existing_user != null){
                if ($existing_user->status == 1) {
                    Auth::login($existing_user);
                    auth()->guard('api')->setUser($existing_user);
                    $user = Auth::guard('api')->user();
                    $user->role_id = (string) $user->role_id; // convert role_id to string for application
                    $token = $user->createToken('user')->accessToken;
                    // save session for user to logout on different devices
                    $sessionId = Session::getId();
                    Auth::guard('api')->user()->update([
                        'current_session_id' => $sessionId,
                        'timezone' => $request->timezone,
                    ]);

                    return successResponse('Login Successful', ['token' => $token , 'user' => $user]);
                } else {
                    $data = [
                        'name' => 'SocialAuthController',
                        'module' => 'error',
                        'description' => 'User account is inactive',
                    ];
                    Log::create($data);
    
                    return errorResponse('Your account is inactive. Please contact support.');
                }  
            }else{
                $data = [
                    'name' => 'SocialAuthController',
                    'module' => 'error',
                    'description' => 'User not found please register first',
                ];
                Log::create($data);

                return errorResponse('User not found please register first');
            }
              
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SocialAuthController',
                'module' => 'login',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }
}
