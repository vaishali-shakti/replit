<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\SubCategory;
use App\Models\MainCategory;
use App\Models\Rating;
use App\Models\Package;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SubCategoryController extends Controller
{
    public function sub_categories(Request $request)
    {
        try {
            $rules = [
                'id' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorMessage = $validator->errors()->first();
                return errorResponse($errorMessage, $validator->messages());
            }
            $per_page = $request->per_page ?? 8;

            $SubCategories = SubCategory::where('cat_id', $request->id)->where('status', 1);
            if(isset($request->search) && $request->search != null){
                $SubCategories = $SubCategories->where('name', 'like', '%' . $request->search . '%');
            }

            $SubCategories = $SubCategories->orderBy('order_by','asc')->paginate($per_page);

            $main_cat = MainCategory::find($request->id);
            $user_purchased = is_plan_active($request->id, null, auth()->guard('api')->user()->id) || organization_user_plan($main_cat->super_cat_id, auth()->guard('api')->user()->id) || customise_all_assign(auth()->guard('api')->user()->id) || organization_all_assign(auth()->guard('api')->user()->id);

            $packages = Package::where('cat_id', $request->id)->where('status', 1)->orderBy('packages_order_by','asc')->get();

            return successResponse('Sub Categories retrieved successfully', ['sub_category' => $SubCategories, 'packages' => $packages, 'user_purchased' => $user_purchased]);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SubCategoryController',
                'module' => 'sub_categories',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return errorResponse($th->getMessage());
        }
    }

    public function sub_category(Request $request)
    {
        try {
            $rules = [
                'id' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorMessage = $validator->errors()->first();
                return errorResponse($errorMessage, $validator->messages());
            }

            $userId = auth()->guard('api')->id();
            $subCategory = SubCategory::select(
                'subcategory.*',
                'ratings.rating as user_rating',
                'ratings.description as rating_description'
            )
            ->leftJoin('ratings', function ($join) use ($userId) {
                $join->on('ratings.sub_cat_id', '=', 'subcategory.id')
                    ->where('ratings.user_id', '=', $userId);
            })
            ->where('subcategory.status', 1)
            ->with([
                // 'packages' => function($query) {
                //     $query->where('status', 1);
                // },
                'main_category.packages' => function($query) {
                    $query->where('status', 1)
                    ->orderBy('packages_order_by', 'asc');;
                },
            ])
            ->withCount([
                'likedCategories as liked' => fn($query) => $query->where('user_id', $userId)
            ])
            ->where('subcategory.id', '=', $request->id)
            ->first();

            if (!$subCategory) {
                return errorResponse('No Sub Category Found');
            }

            $user_purchased = (is_plan_active($subCategory->cat_id, $subCategory->id, $userId) || customise_user_plan($subCategory->id, $userId));
            if ($subCategory->status == 1 || $user_purchased) {

            $subCategory->audio = ($subCategory->payment_type == "free" || $user_purchased == true) && $subCategory->audio != null && Storage::disk('s3')->exists('audio/'.$subCategory->audio) ? Storage::disk('s3')->temporaryUrl('audio/'.$subCategory->audio,\Carbon\Carbon::now()->addhour(1)) : null;
            $subCategory->video = ($subCategory->payment_type == "free" || $user_purchased == true) && $subCategory->video != null && Storage::disk('s3')->exists('video/'.$subCategory->video) ? Storage::disk('s3')->temporaryUrl('video/'.$subCategory->video,\Carbon\Carbon::now()->addhour(1)) : null;

            $write_review = ($subCategory->payment_type == "free" || is_user_purchased($subCategory->id, $subCategory->cat_id, $userId) || customise_user_plan($subCategory->id, $userId));

            return successResponse('Sub Categories retrieved successfully', ['SubCategories' => $subCategory, 'user_purchased' => $user_purchased, 'write_review' => $write_review]);
            } else {
                return errorResponse('Sub Category not found');
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SubCategoryController',
                'module' => 'sub_category',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return errorResponse($th->getMessage());
        }
    }
}
