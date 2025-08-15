<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function updateprofile(Request $request)
{
        try {
            // Validate incoming data
                  $user = Auth::guard('api')->user();
            $request->validate([
                'name' => 'required|string|max:255',
                'dob' => 'required|date',
                'role_id' => 'required|integer',
                'email' => 'required|email|max:255',
                'mobile_number_1' => 'required|string',
            ]);
            // $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => 0,
                    'message' => 'User not found.',
                ], 404);
            }
            $imageName = $user->image;

            if ($request->hasFile('image')) {
                if ($user->image) {
                    $image_name = str_replace(url('storage/users').'/', '', $user->image);
                    $image_path = public_path('storage/users').'/'.$image_name;
                        if (file_exists($image_path)) {
                            unlink($image_path);
                        }
                }
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('storage/users'), $imageName);
            }

            $user->name = $request->input('name', $user->name);
            $user->dob = $request->input('dob', $user->dob);
            $user->time_of_birth = $request->input('time_of_birth', $user->time_of_birth);
            $user->place_of_birth = $request->input('place_of_birth', $user->place_of_birth);
            $user->role_id = $request->input('role_id', $user->role_id);
            $user->email = $request->input('email', $user->email);
            $user->image = $imageName;
            $user->discomfort = $request->input('discomfort', $user->discomfort);
            $user->mobile_number_1 = $request->input('mobile_number_1', $user->mobile_number_1);
            $user->mobile_number_2 = $request->input('mobile_number_2', $user->mobile_number_2);


            $user->save();

            return successResponse('User updated successfully',  $user);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'UserController',
                'module' => 'update',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return errorResponse($th->getMessage());
        }
    }
    public function user_data(Request $request)
    {
        try {
            $user_data = Auth::guard('api')->user();

            return successResponse('Users retrieved successfully', ['user' => $user_data]);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'UserController',
                'module' => 'user_data',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return errorResponse($th->getMessage());
        }
    }

    public function user_delete()
    {
        try{
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
                $user->token()->revoke();
                $user->delete();
                return successResponse('User Deleted successfully');
            } else {
                return errorResponse('Something went wrong, Please try again later');
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'UserController',
                'module' => 'user_delete',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function delete_user($id)
    {
        try{
            if (User::whereIn('role_id',[3,4])->find($id)->delete()) {
                return successResponse('User Deleted successfully');
            } else {
                return errorResponse('Something went wrong, User not exist.');
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'UserController',
                'module' => 'user_delete',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function remove_profile_img(Request $request){
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            if (isset($user->image) && $user->image != null) {
                $image_name = str_replace(url('storage/users').'/', '', $user->image);
                $image_path = public_path('storage/users').'/'.$image_name;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
                $user->image = null;
                $user->save();
            }
            return successResponse('Profile image removed successfully');
        } else {
            return errorResponse('Something went wrong, Please try again later');
        }
    }
}
