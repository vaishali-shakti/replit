<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Sensor;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SensorExport;
use DB;

class DashboardController extends Controller
{
    /**
     *@author     Urmi Parmar
     *
     * @date      feb 28, 2024
     *
     * @ description page user details show here
     */
    public function index()
    {
        try {
            return view('admin.dashboard.index');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'DashboardController',
                'module' => 'index',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return redirect()->back()->with('error', $th->getMessage());
        }

    }


    // public function generate_report($user_id){
    //     try{
    //         $user = User::find($user_id);
    //         if($user == null){
    //             return redirect()->back()->with('error', 'unauthorized access');
    //         }
    //         $allowedDates = Sensor::select(DB::raw('DATE(created_at) as created_at'))->groupBy(DB::raw('DATE(created_at)'))
    //         ->when($user->role_id != getHospitalRoleid(),function($q) use($user){
    //             $q->where('user_id',$user->id);
    //         })
    //         ->when($user->role_id == getHospitalRoleid(),function($q) use($user){
    //             $q->whereHas('getPatientHospital',function($q) use($user){
    //                 $q->where('hospital_id',$user->id);
    //             });
    //         })
    //         ->get()->toArray();
    //         $allowedDates = array_column($allowedDates, 'created_at');
    //         return view ('admin.report.generate_report',compact('allowedDates','user'));
    //     }catch (\Throwable $th) {
    //         $data = [
    //             'name' => 'DashboardController',
    //             'module' => 'generate_report',
    //             'description' => $th->getMessage(),
    //         ];
    //         Log::create($data);
    //         return redirect()->back()->with('error', $th->getMessage());
    //     }

    // }

    public function editProfile()
    {
        $user = Auth::user();
        return view('admin.profile',compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
        ]);
        try{
            $input = $request->all();
            Auth::user()->update($input);
            return redirect()->route('admin.dashboard')->with('success','Profile updated successfully');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'UserController',
                'module' => 'destroy',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->route('edit-profile')->with('error',$th->getMessage());
        }
    }


    // public function generate_report_post(Request $request){
    //     if(auth()->user()->role_id != getHospitalRoleid()){
    //         $sensors = Sensor::where('action','>=',date('Y-m-d H:i:s',strtotime($request->start_date)))->where('action','<=',date('Y-m-d H:i:s',strtotime($request->end_date)))->where('user_id',Auth::user()->id)->orderBy('action','asc')->get();
    //     }
    //     else{
    //         $sensors = Sensor::where('action','>=',date('Y-m-d H:i:s',strtotime($request->start_date)))->where('action','<=',date('Y-m-d H:i:s',strtotime($request->end_date)))
    //         ->whereHas('getPatientHospital',function($q){
    //             $q->where('hospital_id',auth()->user()->id);
    //         })->orderBy('action','asc')->get();
    //     }
    //     try {
    //         return Excel::download(new SensorExport($sensors), 'report.xlsx');
    //     }
    //     catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
    //         $failures = $e->failures();
    //         return response()->json(['status' => 1,'message' => $failures]);
    //     }
    // }

    // public function report_start_date(Request $request)
    // {
    //     $user = $request->user;
    //     $sensors = Sensor::when($user['role_id'] != getHospitalRoleid(),function($q) use($user){
    //         $q->where('user_id',$user['id']);
    //     })
    //     ->when($user['role_id'] == getHospitalRoleid(),function($q) use($user){
    //         $q->whereHas('getPatientHospital',function($q) use($user){
    //             $q->where('hospital_id',$user['id']);
    //         });
    //     })->whereDate('created_at','=',date('Y-m-d',strtotime($request->date)))->get();

    //     return response()->json(['status' => 1,'sensors' => $sensors]);
    // }
}
