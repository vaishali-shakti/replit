<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Log;
use App\Models\Like;

class FavouritesController extends Controller
{
    public function index()
    {
        try{
            $user_id = auth()->guard('auth')->user()->id;
            $favorites = SubCategory::whereHas('likedCategories', function($q) use($user_id){
                $q->where('user_id', $user_id);
            })->get();
            return view('front.favourites.index', compact('favorites'));
        } catch (\Throwable $th) {
            $data = [
                'name' => 'FavouritesController',
                'module' => 'index',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }

    public function like_unlike_category(Request $request){
        try{
            $user_id = auth()->guard('auth')->user()->id;
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
                'name' => 'FavouritesController',
                'module' => 'like_unlike_category',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }
}
