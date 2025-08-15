<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Log;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    public function rate_category(Request $request)
    {
        try{
            $rules = [
                'sub_cat_id' => 'required|exists:subcategory,id',
                'rating' => 'required|integer|min:1|max:5',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorMessage = $validator->errors()->first();

                return errorResponse($errorMessage, $validator->messages());
            }

            $rating = Rating::updateOrCreate(
                ['user_id' => auth()->guard('api')->user()->id, 'sub_cat_id' => $request->sub_cat_id],
                ['rating' => $request->rating, 'description' => $request->description],
            );
            return successResponse('Rating submitted successfully');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'UserController',
                'module' => 'user_delete',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }

    public function getItemRatings($itemId)
    {
        $ratings = Rating::where('sub_cat_id', $itemId)->get();

        return response()->json([
            'average_rating' => $ratings->avg('rating'),
            'ratings_count' => $ratings->count(),
            'ratings' => $ratings,
        ], 200);
    }
}
