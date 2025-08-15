<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'number' => 'required|numeric', 
                'message' => 'required|string', 
                'user_id' => 'nullable|integer', 
            ]);
            $contact = new Contact();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->number = $request->number;
            $contact->message = $request->message;
            $contact->user_id = $request->user_id;
            $contact->save();
          
            return successResponse('Contact created successfully',  $contact);

        } catch (\Exception $e) {
            $data = [
                'name' => 'ContactController',
                'module' => 'index',
                'description' => $e->getMessage(),
            ];
            Log::create($data);

            return errorResponse($e->getMessage());
        }
    }
    
}
