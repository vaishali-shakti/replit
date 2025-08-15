<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use App\Models\Setting;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        try {
            if (! Auth::user()->can('setting-list')) {
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }
            if ($request->ajax()) {
                $Setting = Setting::where('key', '!=', 'info-reload-count')->select('*');

                return Datatables::of($Setting)
                    ->addIndexColumn()
                    ->editColumn('value', function ($row) {
                        if ($row->type == 'File') {
                            return '<img src="'.asset('storage/setting/'.$row->value).'" class="rounded setting_logo" width="100" height="100"/>';
                        } else {
                            return $row->value;
                        }
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '';
                        if (Auth::user()->can('setting-edit')) {
                            $btn = '<a href="'.route('setting.edit', $row['id']).'" title="edit setting" class="table-action-btn edit btn btn-primary table-icon-btn"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path d="M7.127 22.562l-7.127 1.438 1.438-7.128 5.689 5.69zm1.414-1.414l11.228-11.225-5.69-5.692-11.227 11.227 5.689 5.69zm9.768-21.148l-2.816 2.817 5.691 5.691 2.816-2.819-5.691-5.689z"/></svg></a>';
                        }
                        //  if(Auth::user()->can('setting-delete')){
                        //      $btn .= ' <a data-href="'.route('setting.destroy',$row->id).'" class="table-action-btn btn btn-danger delete_btn table-icon-btn" data-id="'. $row["id"] .'"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"> <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/> <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/> </svg></a>';
                        //  }

                        return $btn;
                    })
                    ->rawColumns(['action', 'value', 'status'])
                    ->make(true);
            }

            return view('admin.setting.index');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SettingController',
                'module' => 'index',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function create()
    {
        try {
            // if (! Auth::user()->can('setting-create')) {
            //     return back()->with(['error' => 'Unauthorized Access.']);
            // }

            return view('admin.setting.create');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SettingController',
                'module' => 'create',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'value' => 'required',
            ]);
            // if (! Auth::user()->can('setting-create')) {
            //     return back()->with(['error' => 'Unauthorized Access.']);
            // }
            $original_image_name = '';
            if ($request->type == 'File') {
                // dd('sdffd');
                $imageName = rand(0000, 9999).time().'.'.$request->value->extension();
                $request->value->move(public_path('storage/setting'), $imageName);
                $original_image_name = $imageName;

                //convert image in webp and move
                $image_path = public_path('storage/setting').'/'.$imageName;
                $webpimage = convert_webp($image_path);
                $webpimage['image']->save(public_path('storage/setting/'.$webpimage['imagename']));
                $value = $webpimage['imagename'];

            } else {
                $value = $request->value;
            }

            $Setting = [
                'title' => $request->title,
                'type' => $request->type,
                'key' => \Str::slug($request->title),
                'value' => $value,
                "original_image" => $original_image_name,
            ];
            Setting::create($Setting);

            return redirect()->route('setting.index')
                ->with('success', 'Setting created successfully');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SettingController',
                'module' => 'store',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function edit($id)
    {
        try {
            if (! Auth::user()->can('setting-edit')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $setting = Setting::find($id);

            return view('admin.setting.edit', compact('setting'));
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SettingController',
                'module' => 'edit',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required',
                //    'value' => 'required',
            ]);
            if (! Auth::user()->can('setting-edit')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $original_image_name = '';
            if ($request->type == 'File') {
                if ($request->value != '') {
                    $imageName = rand(0000, 9999).time().'.'.$request->value->extension();
                    $request->value->move(public_path('storage/setting'), $imageName);
                    $original_image_name = $imageName;
                
                    //convert image in webp and move
                    $image_path = public_path('storage/setting').'/'.$imageName;
                    $webpimage = convert_webp($image_path);
                    $webpimage['image']->save(public_path('storage/setting/'.$webpimage['imagename']));
                    $value = $webpimage['imagename'];
                } else {
                    $value = $request->old_value;
                    $original_image_name=$request->old_value;
                }
            } else {
                $value = $request->value;
            }
            $Setting = [
                'title' => $request->title,
                'key' => \Str::slug($request->get('title')),
                'value' => $value,
                "original_image" => $original_image_name,
            ];
            Setting::whereId($id)->update($Setting);

            return redirect()->route('setting.index')
                ->with('success', 'Setting updated successfully');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SettingController',
                'module' => 'update',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            // if (! Auth::user()->can('setting-delete')) {
            //     return back()->with(['error' => 'Unauthorized Access.']);
            // }
            $Setting = Setting::whereId($id)->first();
            if ($Setting->type == 'File') {
                if (file_exists(public_path('setting/'.$Setting->value))) {
                    unlink(public_path('setting/'.$Setting->value));
                }
            }

            $Setting = Setting::whereId($id)->delete();
            if ($Setting) {
                return response()->json(['status' => 1]);
            } else {
                return response()->json(['status' => 0]);
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SettingController',
                'module' => 'destroy',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function title_unique_name_setting(Request $request)
    {
        try {
            if (Setting::where('title', $request->title)->exists()) {
                return response()->json(['status' => '1', 'message' => 'Title  Already Exists!']);
            } else {
                return response()->json(['status' => '0']);
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SettingController',
                'module' => 'title_unique_name_setting',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function title_edit_unique_name(Request $request)
    {
        try {
            $rules = [
                'title' => 'required|unique:settings,title,'.$request->id,
            ];
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => '1', 'message' => 'Title Already Exists!']);
            } else {
                return response()->json(['status' => '0']);
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SettingController',
                'module' => 'title_edit_unique_name',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function key_unique(Request $request)
    {
        try {
            if (Setting::where('key', $request->key)->exists()) {
                return response()->json(['status' => '1', 'message' => 'Key  Already Exists!']);
            } else {
                return response()->json(['status' => '0']);
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'key_unique',
                'module' => 'title_unique_name_setting',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function edit_key_unique(Request $request)
    {
        try {
            $rules = [
                'key' => 'required|unique:settings,key,'.$request->id,
            ];
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => '1', 'message' => 'Key Already Exists!']);
            } else {
                return response()->json(['status' => '0']);
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SettingController',
                'module' => 'edit_key_unique',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
  
}
