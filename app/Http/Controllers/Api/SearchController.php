<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\Log;
use DB;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    public function search_category(Request $request){
        try {
            $rules = [
                'name' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorMessage = $validator->errors()->first();

                return errorResponse($errorMessage, $validator->messages());
            }
            $category = MainCategory::select('id', 'name', DB::raw("'main_category' as type"))
                ->where('name', 'like', '%' . $request->name . '%')
                ->union(
                    SubCategory::select('id', 'name', DB::raw("'sub_category' as type"))
                        ->where('name', 'like', '%' . $request->name . '%')
                );
            $category = $category->get();
            return successResponse('Search category retrieved successfully.', ['search_category' => $category]);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SuperCategoryController',
                'module' => 'search_category',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }

    public function search_main_category(Request $request){
        try {
            $rules = [
                'super_cat_id' => 'required',
                'name' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorMessage = $validator->errors()->first();

                return errorResponse($errorMessage, $validator->messages());
            }
            $category = MainCategory::select('id', 'name')->where('super_cat_id', $request->super_cat_id)->where('name', 'like', '%' . $request->name . '%')->get();
            return successResponse('Search main category retrieved successfully.', ['search_category' => $category]);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SuperCategoryController',
                'module' => 'search_main_category',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }

    public function search_sub_category(Request $request){
        try {
            $rules = [
                'main_cat_id' => 'required',
                'name' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorMessage = $validator->errors()->first();

                return errorResponse($errorMessage, $validator->messages());
            }
            $category = SubCategory::select('id', 'name')->where('cat_id', $request->main_cat_id)->where('name', 'like', '%' . $request->name . '%')->get()->makeHidden(['average_rating']);
            return successResponse('Search main category retrieved successfully.', ['search_category' => $category]);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SuperCategoryController',
                'module' => 'search_sub_category',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }
}
