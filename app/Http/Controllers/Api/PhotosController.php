<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\Photos;

class PhotosController extends Controller
{
    public function index()
    {
        try {
            $photos = Photos::orderBy('id', 'desc')->get();
            
            return successResponse('Photos retrieved successfully',  $photos);

        } catch (\Throwable $th) {
            $data = [
                'name' => 'PhotosController',
                'module' => 'index',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return errorResponse($th->getMessage());
        }

    }
    
}
