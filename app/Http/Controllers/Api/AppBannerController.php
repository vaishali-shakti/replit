<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppBanner;
use App\Models\Banner;
use App\Models\Log;
use App\Models\Plans;

class AppBannerController extends Controller
{
    public function index()
    {
        try {
            $appBanner = AppBanner::orderBy('id', 'desc')->get();
            // $appBanner->each(function ($banner) {
            //     $banner->description = $banner->description;
            // });
            return successResponse('App Banner retrieved successfully',  $appBanner);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'AppBannerController',
                'module' => 'index',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return errorResponse($th->getMessage());
        }
    }

    public function banner()
    {
        try {
            $appBanner = Banner::orderBy('id', 'desc')->get();
            return successResponse('Banner retrieved successfully',  $appBanner);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'AppBannerController',
                'module' => 'banner',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return errorResponse($th->getMessage());
        }
    }

    public function plans(){
        try{
            $plan_purchased = global_plan_active(auth()->guard('api')->user()->id);
            $plans = Plans::orderBy('order_by', 'asc')->get();
            return successResponse('Plans retrieved successfully', ['plan_purchased' => $plan_purchased, 'plans' => $plans]);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'AppBannerController',
                'module' => 'plans',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }
}
