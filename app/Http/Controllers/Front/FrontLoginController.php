<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Log;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\FrontForgetPassword;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Session;

class FrontLoginController extends Controller
{
    public function login(){
        if(Auth::guard('auth')->check()){
            return redirect()->route("home");
        }
        return view('front.auth.login');
    }

    public function login_post(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        try{
            $remember_me = $request->has('remember_me') ? true : false;
            $user = User::where('email', $request->email)->whereIn('role_id',[3,4])->first();
            if($user){
                if ($user->status == 2) { // If user status is inactive
                    return $request->ajax()
                        ? response()->json(['status' => 0, 'message' => 'You are not an active user. Please contact support.'])
                        : redirect()->back()->with('error', 'You are not an active. Please contact support.');
                }
                if (Auth::guard('auth')->attempt(['email' => $request->email, 'password' => $request->password], $remember_me)) {
                    $sessionId = Session::getId();

                    Auth::guard('auth')->user()->update([
                        'current_session_id' => $sessionId,
                    ]);
                    Session::put('current_session_id', $sessionId);

                    $checkout_id = session()->has('checkout_category') ? session()->get('checkout_category') : null;
                    $checkout_main = session()->has('checkout_main_cat') ? session()->get('checkout_main_cat') : null;
                    $checkout_pricing = session()->has('checkout_pricing') ? session()->get('checkout_pricing') : null;
                    if($checkout_id != null){
                        return redirect()->route('sub_categories', getSlug($checkout_id))->with('success', 'Signed in');
                    }
                    $timezone = Session::has('timezone') ? Session::get('timezone') : '';
                    if($timezone){
                        User::where('id',auth()->guard('auth')->user()->id)->update(['timezone' => $timezone]);
                        Session::forget('timezone');
                    }
                    if($checkout_main != null){
                        return redirect()->route('main_categories', getMainCatSlug($checkout_main))->with('success', 'Signed in');
                    }
                    if($checkout_pricing != null){
                        return redirect()->route('home', '#'.$checkout_pricing)->with('success', 'Signed in');
                    }
                    return redirect()->route('home')->with('success', 'Signed in');
                } else{
                    return redirect()->back()->with('error', "Invalid Credentials!");
                }
            } else{
                $social_user = User::where('email',$request->email)->whereNotNull('oauth_id')->first();
                if($social_user != null){
                    if($social_user->oauth_id != null){
                        return redirect()->back()->with('error',"Please Login with google.");
                    }
                }else{
                    return redirect()->back()->with('error', "These credentials do not match our records.");
                }
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'LoginController',
                'module' => 'postLogin',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function front_register(){
        if(Auth::guard('auth')->check()){
            return redirect()->route("home");
        }
        return view('front.auth.register');
    }
    public function front_forgot_password(){
        try{
            return view('front.auth.forgot-password');

        } catch (\Throwable $th) {
            $data = array(
                "name" => 'FrontLoginController',
                "module" => 'front_forgot_password',
                "description" => $th->getMessage(),
            );
            Log::create($data);
            return redirect()->back()->with('error',$th->getMessage());
        }
    }
    public function forgotPasswordPost(Request $request)
    {
        try{
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);
            if(User::where('email', $request->email)->whereNotNull('parent_id')->exists()){
                return redirect()->route('front_login')->with('error', 'Please contact your administartor to reset your password.');
            } else{
                $user = User::where('email', $request->email)->first();
                $password = rand(100000, 999999);
                $user->password = Hash::make($password);
                Mail::to($request->email)->send(new FrontForgetPassword(['name' => $user->name, 'password' => $password]));
                $user->save();
            }
            // return redirect()->route('front_login')->with('success', 'Your new password has been sent to your email');
            // Auth::guard('auth')->login($user);

            return redirect()->route('front_login')->with('success', 'Your new password has been sent to your email. You are now logged in.');

        } catch (\Throwable $th) {
            $data = [
                'name' => 'FrontLoginController',
                'module' => 'forgotPasswordPost',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function register_post(Request $request){
        try{
            $user = User::where('email', $request->email)->whereIn('role_id',[3,4])->first();
            if($user){
                return redirect()->back()->with('error', "Email already exists!");
            }

            $password = Hash::make($request->password);
            if ($request->hasFile('image')) {
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('storage/users'), $imageName);
                $input['original_image'] = $imageName;

                $image_path = public_path('storage/users').'/'.$imageName;
                $webpimage = convert_webp($image_path);
                $webpimage['image']->save(public_path('storage/users/'.$webpimage['imagename']));
                $input['image'] = $webpimage['imagename'];
            }else{
                $input['image'] = null;
                $input['original_image'] = null;
            }

            $User_data = [
                'name' => $request->name,
                'time_of_birth' => $request->time_of_birth,
                'place_of_birth' => $request->place_of_birth,
                'email' => $request->email,
                'dob' => \Carbon\Carbon::parse($request->dob)->format('Y-m-d'),  // Format 'dob' to Ymd
                'mobile_number_1' => $request->mobile_number_1,
                'mobile_number_2' => $request->mobile_number_2,
                'discomfort' => $request->discomfort,
                'image' => $input['image'],
                'original_image' => $input['original_image'],
                'password' => $password,
                'role_id' => 3,
            ];

            $User = User::create($User_data);
            Mail::to($User_data['email'])->send(new WelcomeMail(['name' => $User_data['name']]));
            return redirect()->route('front_login')->with('success', 'Account created successfully! Kindly log in here.');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'FrontLoginController',
                'module' => 'register_post',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function front_logout(Request $request)
    {
        try{
            Auth::guard('auth')->logout();
            return redirect()->route('front_login');
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

    public function redirectToGoogle($slug = null){
        return Socialite::driver('google')->stateless()->with(['state' => $slug])->redirect();
    }

    public function handleGoogleCallback(Request $request){
        try{
            $user = Socialite::driver('google')->stateless()->user();
            $existing_user = User::where('email', $user->email)->first();
            if($existing_user){
                if ($existing_user->status == 1) { // If user status is inactive
                    $socialUser = User::where('email',$user->email)->where('oauth_id',$user->getId())->first();
                    if($socialUser){
                        Auth::guard('auth')->login($socialUser,true);

                        $sessionId = Session::getId();

                        Auth::guard('auth')->user()->update([
                            'current_session_id' => $sessionId,
                        ]);
                        Session::put('current_session_id', $sessionId);

                        $checkout_id = session()->has('checkout_category') ? session()->get('checkout_category') : null;

                        if($checkout_id != null){
                            return redirect()->route('sub_categories', getSlug($checkout_id))->with('success', 'Signed in');
                        }
                        return redirect()->route('home')->with('success', 'Signed in');
                        }else{
                            return redirect()->route('front_login')->with('error', 'Please Login using Email and Password.');
                    }
                } else {
                    return redirect()->route('front_login')->with('error', 'Your account is inactive. Please contact support.');
                }
            }else{
                if(isset($request->state) && $request->state == 'register'){
                    $user = array(
                    'name' => $user->name,
                    'email' => $user->email,
                    'oauth_id' => $user->getId(),
                    'role_id' => 3,
                    );
                    $user_data = User::create($user);
                    Auth::guard('auth')->login($user_data,true);
                    Mail::to($user['email'])->send(new WelcomeMail(['name' => $user['name']]));
                    $checkout_id = session()->has('checkout_category') ? session()->get('checkout_category') : null;
                    if($checkout_id != null){
                        return redirect()->route('sub_categories', getSlug($checkout_id))->with('success', 'Signed in');
                    }
                    $timezone = Session::has('timezone') ? Session::get('timezone') : '';
                    if($timezone){
                        User::where('id',$user_data->id)->update(['timezone' => $timezone]);
                        Session::forget('timezone');
                    }
                    return redirect()->route('user_dashboard')->with('success', 'Signed in. please update your profile.');
                } else{
                    return redirect()->route('front_login')->with('error','Your account does not exist. Please register your account first.');
                }
            }
        }catch (\Throwable $th) {
            $data = [
                'name' => 'LoginController',
                'module' => 'handleGoogleCallback',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }

    }

    public function save_checkout_detail(Request $request){
        if(isset($request->id) && $request->id != null){
            session()->forget('checkout_main_cat');
            session()->forget('checkout_pricing');
            session()->put('checkout_category', $request->id);
        }
        if(isset($request->main_cat_id) && $request->main_cat_id != null){
            session()->forget('checkout_category');
            session()->forget('checkout_pricing');
            session()->put('checkout_main_cat', $request->main_cat_id);
        }
        if(isset($request->pricing) && $request->pricing != null){
            session()->forget('checkout_category');
            session()->forget('checkout_main_cat');
            session()->put('checkout_pricing', $request->pricing);
        }
        return response()->json(['status' => 1]);
    }

    public function store_timezone(Request $request){
        Session::put('timezone', $request->timezone);
        return response()->json(['status' => 1]);
    }
}
