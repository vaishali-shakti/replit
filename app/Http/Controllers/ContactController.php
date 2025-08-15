<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use App\Models\Contact;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            if (! Auth::user()->can('contact-list')) {
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }
            if ($request->ajax()) {
                $contact = Contact::select("*");
                return DataTables::of($contact)
                ->editColumn('message', function ($row) {
                    $messageText = strip_tags($row->message);
                    $messageText = str_replace('&nbsp;', ' ', $messageText);
                    
                    $shortMessage = strlen($messageText) > 50 ? substr($messageText, 0, 50) . '...' : $messageText;
        
                    return '<span data-bs-toggle="tooltip" data-bs-placement="top" title="' . htmlspecialchars($messageText) . '">' . $shortMessage . '</span>';
                })
                    ->editColumn('user_id', function($row) {
                        return $row->user_id ? $row->user_id : '-';
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '';
                        if (Auth::user()->can('contact-delete')) {
                            $btn .= '<a href="javascript:void(0);" data-href="'.route('contact.destroy', $row->id).'" title="delete contact" class="table-action-btn btn btn-danger delete_btn table-icon-btn me-2" data-id="'.$row['id'].'"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/> 
                          </svg></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action','message'])
                    ->make(true);
            }

            return view('admin.contact.index');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'ContactController',
                'module' => 'index',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $contact = Contact::find($id);
            if($contact != null){
                $contact->delete();
                return response()->json(['status' => 1, 'message' => 'Contact deleted successfully.'], 200);
            }else{
                return response()->json(['status' => 0 ,'message' => 'Contact is not found.']);
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'ContactController',
                'module' => 'destroy',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
