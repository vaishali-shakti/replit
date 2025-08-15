<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class FrontDashboardController extends Controller
{
    public function front_update_profile(Request $request,$id){
       try{
        $user = User::find($id);

        if ($request->hasFile('image')) {
            if($user->original_image != null){
                $image_name = str_replace(url('storage/users').'/', '', $user->original_image);
                $image_path = public_path('storage/users').'/'.$image_name;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('storage/users'), $imageName);
            $user->original_image = $imageName;

            $image_name = str_replace(url('storage/users').'/', '', $user->image);
            $image_path = public_path('storage/users').'/'.$image_name;
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            $image_path = public_path('storage/users').'/'.$imageName;
            $webpimage = convert_webp($image_path);
            $webpimage['image']->save(public_path('storage/users/'.$webpimage['imagename']));
            $user->image = $webpimage['imagename'];
        }
         $user->name = $request->name;
         $user->time_of_birth = $request->time_of_birth;
         $user->place_of_birth = $request->place_of_birth;
         $user->dob = \Carbon\Carbon::parse($request->dob)->format('Y-m-d'); // Format 'dob' to Ymd
         $user->email = $request->email;
         $user->mobile_number_1 = $request->mobile_number_1;
         $user->mobile_number_2 = $request->mobile_number_2;
         $user->discomfort = $request->discomfort;
         $user->update();

         return redirect()->route('user_dashboard')->with('success','User profile updated successfully.');
       }catch (\Throwable $th) {
        $data = [
            'name' => 'FrontDashboardController',
            'module' => 'front_update_profile',
            'description' => $th->getMessage(),
        ];
        Log::create($data);
        return redirect()->back()->with('error', $th->getMessage());
    }

    }

    public function front_change_password(Request $request)
    {
        try{
            $user = auth()->guard('auth')->user();
            if ($user != null) {
                // Verify old password matches the current password
                if (Hash::check($request->password, $user->password)) {
                    // Update the password
                    $user->update([
                        'password' => Hash::make($request->new_password),
                    ]);
                    return redirect()->route('user_dashboard',['change-pass'])->with('success','Password has been changed successfully.');
                } else {
                    return redirect()->route('user_dashboard',['change-pass'])->with('error','Current password does not match.');
                }
            }else{
                return redirect()->back()->with('error','Unauthorized Access.');
            }
        }catch (\Throwable $th) {
            $data = [
                'name' => 'FrontDashboardController',
                'module' => 'front_change_password',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function checkEmailEdit(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|unique:users,email,'.$request->id,
                // 'email' => 'required|unique:users,email,'.$request->id.',id,deleted_at,NULL',
            ];
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => '1', 'message' => 'Email Already Exists!']);
            } else {
                return response()->json(['status' => '0']);
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'FrontDashboardController',
                'module' => 'checkEmailEdit',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
