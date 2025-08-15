<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use App\Mail\sendOtp;
use Session;
use Hash;
use App\Mail\ForgetPassword;



class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('web')->except('logout');
    }

    /**
     *@author     Urmi Parmar
     *
     * @date      feb 27, 2024
     *
     * @ description page login page show here
     */
    public function index()
    {
        try{
            if(auth()->guard('web')->check()){
                return redirect()->route('admin.dashboard');
            }
            return view('admin.login');
        }   catch (\Throwable $th) {
            $data = [
                'name' => 'LoginController',
                'module' => 'index',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }

    }

    /**
     *@author     Urmi Parmar
     *
     * @date      feb 27, 2024
     *
     * @ description page login here
     */
    public function postLogin(Request $request)
    {
            $this->validate($request, [
                'email' => 'required',
                'password' => 'required',
            ]);
            try{
            $credentials = $request->only('email', 'password');
            $user = User::where('email', $request->email)->whereIn('role_id',[1,2,5])->first();
            if($user){
                if ($user->status == 2) { // If user status is inactive
                    return $request->ajax()
                        ? response()->json(['status' => 0, 'message' => 'You are not an active user. Please contact support.'])
                        : redirect()->back()->with('error', 'You are not an active user. Please contact support.');
                }
                if (Auth::guard('web')->attempt($credentials)) {
                        $timezone = Session::has('timezone') ? Session::get('timezone') : '';
                        if($timezone){
                            User::where('id',auth()->guard('web')->user()->id)->update(['timezone' => $timezone]);
                            Session::forget('timezone');
                        }
                        if($request->isSendOtp == 1){
                            // $otp = rand(100000, 999999);
                            // $details = [
                            //     'name' => auth()->user()->name,
                            //     'otp' => $otp
                            // ];
                            // $email = User::find(2)->email ?? 'bandhanfilament@gmail.com';
                            // Mail::to($email)->send(new sendOtp($details));
                            Auth::logout();
                            // Session::put('otp',$otp);
                            if ($request->ajax()) {
                                return response()->json(['status' => 1,'message' => 'You Have Logged in Successfully']);
                            }
                            else{
                                return redirect()->route('admin.dashboard')->withSuccess('You Have Login Successfully');
                            }
                        }
                        else{
                            if ($request->ajax()) {
                                return response()->json(['status' => 1,'message' => 'You Have Logged in Successfully']);
                            }
                            else{
                                return redirect()->route('admin.dashboard')->withSuccess('You Have Login Successfully');
                            }
                        }

                    }
                else{
                    if ($request->ajax()) {
                    return response()->json(['status' => 0, 'message' => 'These credentials do not match our records.']);
                    }
                    else{
                        return redirect()->back()->with('error','These credentials do not match our records.');
                    }
                }
            } else{
                if ($request->ajax()) {
                    return response()->json(['status' => 0, 'message' => "User doesn't exist"]);
                }
                else{
                    return redirect()->back()->with('error',"User doesn't exist");
                }
            }
        }catch (\Throwable $th) {
        $data = [
            'name' => 'LoginController',
            'module' => 'postLogin',
            'description' => $th->getMessage(),
        ];
        Log::create($data);
        if ($request->ajax()) {
          return response()->json(['success' => 0, 'message' => $th->getMessage()]);
        }
        else{
          return redirect()->back()->with('error', $th->getMessage());
        }

    }
    }

    /**
     *@author      Urmi Parmar
     *
     * @date      feb 27, 2024
     *
     * @ description page logout here
     */
    public function logout(Request $request)
    {
        try{
            Auth::logout();
            return redirect()->route('login');
        }   catch (\Throwable $th) {
            $data = [
                'name' => 'AuthController',
                'module' => 'logout',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function verifyPost(Request $request){
        if($request->otp == Session::get('otp')){
            return response()->json(['status' => 1,"otp" => $request->otp]);
        }
        else{
            return response()->json(['status' => 0, 'message' => 'Invalid OTP!']);
        }

    }
    public function forgotpassword()
    {
        try{
            return view('admin.forgot-password');
        } catch (\Throwable $th) {
            $data = array(
                "name" => 'LoginController',
                "module" => 'forgotpassword',
                "description" => $th->getMessage(),
            );
            Log::create($data);
            return redirect()->back()->with('error',$th->getMessage());
        }
    }


    public function forgotPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
        $user = User::where('email', $request->email)->first();
        $password = rand(100000, 999999);
        $user->password = Hash::make($password);
        Mail::to($request->email)->send(new ForgetPassword(['name' => $user->name, 'password' => $password]));
        $user->save();
        return redirect()->route('login')->with('success', 'Your new password has been sent to your email');
    }
}
