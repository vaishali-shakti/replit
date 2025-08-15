<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\password;

class ResetController extends Controller
{
    /**
     *@author      Urmi Parmar
     *
     * @date      feb 28, 2024
     *
     * @ description page user details show here
     */
    public function index()
    {
        try {
            return view('admin.change-password');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'ResetController',
                'module' => 'index',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }

    }

    /**
     *@author      Urmi Parmar
     *
     * @date      feb 28, 2024
     *
     * @ description page user reset password show here
     */
    public function postReset(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required',
                'new_password' => 'required',
                'confirm_password' => 'required|same:new_password',
            ]);
            $user = [
                'password' => Hash::make($request->new_password),
            ];
            Auth::user()->update($user);
            return redirect()->route('reset')->with('success', 'Your Password is Changed Successfully!');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'ResetController',
                'module' => 'postReset',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     *@author      Urmi Parmar
     *
     * @date      feb 28, 2024
     *
     * @ description page user reset password validation here
     */
    public function resetpasswordvalidation(Request $request)
    {
        try {
            $user = Auth::user();
            $credentials = $request->only('password');
            if (Hash::check($credentials['password'], $user->password)) {
                return response()->json(['status' => '1']);
            } else {
                return response()->json(['status' => '0', 'message' => 'Password does not match with current password.']);
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'ResetController',
                'module' => 'resetpasswordvalidation',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

}
