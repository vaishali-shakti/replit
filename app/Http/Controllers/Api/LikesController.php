<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Log;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Validator;

class LikesController extends Controller
{
    public function like_unlike_category(Request $request){
        try{
            $rules = [
                'id' => 'required|exists:subcategory,id',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorMessage = $validator->errors()->first();

                return errorResponse($errorMessage, $validator->messages());
            }

            $user_id = auth()->guard('api')->user()->id;
            $like = Like::where('user_id', $user_id)->where('sub_cat_id', $request->id)->first();

            if($like){
                $like->delete();
                return successResponse('Unliked successfully');
            } else {
                // Create a new like
                Like::create([
                    'user_id' => $user_id,
                    'sub_cat_id' => $request->id
                ]);
                return successResponse('Liked successfully');
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'LikesController',
                'module' => 'like_unlike_category',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }

    public function favorites_list(){
        try {
            $user_id = auth()->guard('api')->user()->id;
            $favorites = SubCategory::whereHas('likedCategories', function($q) use($user_id){
                $q->where('user_id', $user_id);
            })->get();
            return successResponse('Favorites list retrieved successfully', ['favorites' => $favorites]);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'LikesController',
                'module' => 'favorites_list',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }
}
