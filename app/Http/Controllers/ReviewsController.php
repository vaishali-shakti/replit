<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use DataTables;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            if(!Auth::user()->can('reviews-list')){
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }
            if($request->ajax()){
                $rating = Rating::get();
                return DataTables::of($rating)
                ->editColumn('user_id',function($row){
                    return isset($row->user->name) && $row->user->name != null ? $row->user->name : '-';
                })
                ->editColumn('sub_cat_id',function($row){
                    return isset($row->subcat->name) && $row->subcat->name != null ? $row->subcat->name : '-';
                })
                ->editColumn('description',function($row){
                    $descriptionText = strip_tags($row->description);
                    $descriptionText = str_replace('&nbsp;', ' ', $descriptionText);

                    $shortDescription = strlen($descriptionText) > 50 ? substr($descriptionText, 0, 50) . '...' : $descriptionText;

                    return '<span data-bs-toggle="tooltip" data-bs-placement="top" title="' . htmlspecialchars($descriptionText) . '">' . ($shortDescription != "" ? $shortDescription : '-') . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '-';
                    if(Auth::user()->can('reviews-delete')){
                        $btn = '<a href="javascript:void(0);" data-href="'.route('reviews.destroy', $row->id).'" title="delete Rating" class="table-action-btn btn btn-danger delete_btn table-icon-btn me-2" data-id="'.$row['id'].'"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'description'])
                ->make(true);
            }
            return view('admin.reviews.index');
        }catch(\Throwable $th){
            $data = array(
                'name' => 'ReviewsController',
                'module' => 'index',
                'description' => $th->getMessage(),
            );
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
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
            $rating = Rating::find($id);
            if($rating != null){
                $rating->delete();
                return response()->json(['status' => 1, 'message' => 'Review deleted successfully'], 200);
            }else{
                return response()->json(['status' => 0 ,'message' => 'Review is not found.']);
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'ReviewsController',
                'module' => 'destroy',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
