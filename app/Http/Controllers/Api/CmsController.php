<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\Cms;
use Validator;

class CmsController extends Controller
{
    public function index(Request $request)
    {
        try {
           $rule = [
               'slug_name' => 'required',
           ];
           $validator = Validator::make($request->all(), $rule);
           if ($validator->fails()) {
               $errorMessage = $validator->errors()->first();
               return errorResponse($errorMessage, $validator->messages());
           }

            $slug_name = $request->slug_name;
            $cms = Cms::where('slug_name', $slug_name)->first();

            return successResponse($slug_name .' retrieved successfully',  $cms);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'CmsController',
                'module' => 'index',    
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return errorResponse($th->getMessage());
        }

    }
}
