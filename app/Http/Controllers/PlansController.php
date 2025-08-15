<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\Plans;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;

class PlansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            if(!Auth::user()->can('plans-list')){
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }
            if($request->ajax()){
                $plans = Plans::select('*');
                return DataTables::of($plans)
                ->editColumn('cost_usd',function($row){
                    return isset($row->cost_usd) && $row->cost_usd != null ? $row->cost_usd : '-';
                })
                ->editColumn('cost_euro',function($row){
                    return isset($row->cost_euro) && $row->cost_euro != null ? $row->cost_euro : '-';
                })
                ->editColumn('order_by',function($row){
                    return isset($row->order_by) && $row->order_by != null ? $row->order_by : '-';
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (Auth::user()->can('plans-edit')) {
                        $btn = '<a href="'.route('plans.edit', $row['id']).'" title="edit plans" class="table-action-btn edit btn btn-primary table-icon-btn"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path d="M7.127 22.562l-7.127 1.438 1.438-7.128 5.689 5.69zm1.414-1.414l11.228-11.225-5.69-5.692-11.227 11.227 5.689 5.69zm9.768-21.148l-2.816 2.817 5.691 5.691 2.816-2.819-5.691-5.689z"/></svg></a>';
                    }
                    if(Auth::user()->can('plans-delete')){
                        $btn .= '<a href="javascript:void(0);" data-href="'.route('plans.destroy', $row->id).'" title="delete plans" class="table-action-btn btn btn-danger delete_btn table-icon-btn me-2" data-id="'.$row['id'].'"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
            return view('admin.plans.index');
        }catch(\Throwable $th){
            $data = array(
                'name' => 'PlansController',
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
        try{
            if(!Auth::user()->can('plans-create')){
                return redirect()->route('admin.dashboard')->with('error','Unauthorized Access.');
            }
            return view('admin.plans.create');
        }catch(\Throwable $th){
            $data = array(
                'name' => 'PlansController',
                'module' => 'create',
                'description' => $th->getMessage(),
            );
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'days' => 'required|numeric|min:1',
                'cost' => 'required|numeric|min:1',
                'cost_usd' => 'required|numeric|min:1',
                'cost_euro' => 'required|numeric|min:1',
            ]);
            if($validator->fails()){
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $plans = array(
                'name' => $request->name,
                'days' => $request->days,
                'cost' => $request->cost,
                'cost_usd' => $request->cost_usd,
                'cost_euro' => $request->cost_euro,
                'order_by' => $request->order_by
            );
            Plans::create($plans);
            return redirect()->route('plans.index')->with('success','Plans Created Successfully.');
        }catch(\Throwable $th){
            $data = array(
                'name' => 'PlansController',
                'module' => 'store',
                'description' => $th->getMessage(),
            );
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
        
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
        try{
            if(!Auth::user()->can('plans-edit')){
                return redirect()->route('admin.dashboard')->with('error','Unauthorized Access.');
            }
            $plans = Plans::find($id);
            if(!$plans){
                return redirect()->route('plans.index')->with('error','Plans not found.');
            }
            return view('admin.plans.edit',compact('plans'));
        }catch(\Throwable $th){
            $data = array(
                'name' => 'PlansController',
                'module' => 'edit',
                'description' => $th->getMessage(),
            );
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'days' => 'required|numeric|min:1',
                'cost' => 'required|numeric|min:1',
                'cost_usd' => 'required|numeric|min:1',
                'cost_euro' => 'required|numeric|min:1',
            ]);
            if($validator->fails()){
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $plans = array(
                'name' => $request->name,
                'days' => $request->days,
                'cost' => $request->cost,
                'cost_usd' => $request->cost_usd,
                'cost_euro' => $request->cost_euro,
                'order_by' => $request->order_by
            );
            Plans::where('id',$id)->update($plans);
            return redirect()->route('plans.index')->with('success','Plans Updated Successfully.');
        }catch(\Throwable $th){
            $data = array(
                'name' => 'PlansController',
                'module' => 'update',
                'description' => $th->getMessage(),
            );
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            if(!Auth::user()->can('plans-delete')){
                return redirect()->route('admin.dashboard')->with('error','Unauthorized Access.');
            }
            $plans = Plans::find($id);
            $plan = Payment::where('type', 1)->where('package_id', $id)
                    ->whereHas('getUserDetails')->exists();
            if($plan == true){
               return response()->json(['status' => 0,'message' => 'User plan is currently active so you are not able to delete this plan!']);
            } else{
                $plans->delete();
                return response()->json(['status' => 1,'message' => 'Plans deleted successfully.']);
            }
        }catch(\Throwable $th){
            $data = array(
                'name' => 'PlansController',
                'module' => 'destroy',
                'description' => $th->getMessage(),
            );
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
