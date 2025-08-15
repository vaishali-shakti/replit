<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\SuperCategory;
use App\Models\MainCategory;
use Illuminate\Support\Facades\Validator;

class SuperCategoryController extends Controller
{
    public function index()
    {
        try {
            $category = SuperCategory::with([
                'mainCategories' => function ($query) {
                    $query->orderBy('order_by', 'asc')->limit(8); // Retrieve only 8 main categories
                }])->orderBy('order_by','asc')->get();
            return successResponse('Super category retrieved successfully.',  ['super_category' => $category]);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SuperCategoryController',
                'module' => 'index',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }

    }

    public function main_category(Request $request)
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
            $category = MainCategory::where('super_cat_id', $request->id);
            if(isset($request->search) && $request->search != null){
                $category = $category->where('name', 'like', '%' . $request->search . '%');
            }
            $category = $category->orderBy('order_by','asc')->paginate($per_page);

            return successResponse('Main category retrieved successfully.', ['main_category' => $category]);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SuperCategoryController',
                'module' => 'main_category',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }

    public function special_category(){
        try {
            $category = MainCategory::where('special_music',1)->get();
            return successResponse('Special category retrieved successfully.',  ['special_category' => $category]);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SuperCategoryController',
                'module' => 'special_category',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }

}
