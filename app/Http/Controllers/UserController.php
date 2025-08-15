<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Log;
use App\Models\SubCategory;
use App\Models\SuperCategory;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use DataTables;
use Auth;
use DB;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            if (! Auth::user()->can('user-list')) {
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }
            if ($request->ajax()) {
                $user = User::select("*");
                if(auth()->guard('web')->user()->role_id == 5){
                    $user = $user->where('parent_id', auth()->guard('web')->user()->id);
                }
                return DataTables::of($user)
                    ->addIndexColumn()
                    ->editColumn('dob', function ($row) {
                        return $row->dob ? \Carbon\Carbon::parse($row->dob)->format('d-m-Y') : '';
                    })
                    ->addColumn('role_id', function ($row) {
                        return $row->role ? $row->role->name : 'No role assigned'; // Access the role name
                    })
                    ->addColumn('parent_id', function ($row) {
                        return $row->parentUser ? $row->parentUser->name : '-'; // Access the parentUser name
                    })
                    ->addcolumn('image', function ($row) {
                        return '<img src="'.$row->image.'" class="rounded" height="50" weight="50"/>';
                    })
                    ->editColumn('place_of_birth', function ($row){
                        return $row->place_of_birth ? $row->place_of_birth : '-';
                    })
                    ->editColumn('dob', function ($row){
                        return $row->dob ? $row->dob : '-';
                    })
                    ->editColumn('time_of_birth',function($row){
                        return $row->time_of_birth ? $row->time_of_birth : '-';
                    })
                    ->editColumn('mobile_number_1', function ($row){
                        return $row->mobile_number_1 ? $row->mobile_number_1 : '-';
                    })
                    ->editColumn('mobile_number_2', function ($row){
                        return $row->mobile_number_2 ? $row->mobile_number_2 : '-';
                    })
                    ->editColumn('discomfort', function ($row) {
                        $messageText = strip_tags($row->discomfort);
                        $messageText = Str::remove('&nbsp;', $messageText);

                        $shortMessage = strlen($messageText) > 50 ? substr($messageText, 0, 50) . '...' : $messageText;

                        return '<span data-bs-toggle="tooltip" data-bs-placement="top" title="' . htmlspecialchars($messageText) . '">' . ($shortMessage != "" ? $shortMessage : '-') . '</span>';
                    })
                    ->addColumn('status', function($row) {
                        $btn = '-';
                        if($row->role_id != 1){
                            $btn = '<div class="form-group">
                                    <label class="switch" for="status_'.$row->id.'">
                                        <input type="checkbox" class="form-check-input float-none toggle_status" id="status_'.$row->id.'" name="status['.$row->id.']" value="'.$row->id.'" data-href="'.route('users.updateStatus', $row->id).'" ' . ($row->status == 1 ? 'checked' : '') . '>
                                        <span class="slider fs-16"></span>
                                    </label>
                                </div>';
                        }
                        return $btn;
                    })

                    ->addColumn('action', function ($row) {
                        if($row->role_id != 1 || auth()->user()->role_id == 1){
                            $btn = '<div class="d-flex align-items-start">';
                            if (Auth::user()->can('user-edit')) {
                                $btn .= ' <a href="'.route('users.edit', $row->id).'" title="Edit User" class="table-action-btn btn btn-primary table-icon-btn mb-2" data-id="'.$row->id.'"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#00000" viewBox="0 0 24 24"><path d="M7.127 22.562l-7.127 1.438 1.438-7.128 5.689 5.69zm1.414-1.414l11.228-11.225-5.69-5.692-11.227 11.227 5.689 5.69zm9.768-21.148l-2.816 2.817 5.691 5.691 2.816-2.819-5.691-5.689z"/></svg></a>';
                            }
                            if($row->role_id != 1){
                                if (Auth::user()->can('user-delete')) {
                                    $btn .= ' <a data-href="'.route('users.destroy', $row->id).'" title="Delete User" class="table-action-btn btn btn-danger delete_btn table-icon-btn mb-2" data-id="'.$row['id'].'"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"> <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/> <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/> </svg></a>';
                                }
                            }
                            if (Auth::user()->can('user-view')){
                                $btn .= '
                                <a href="' . route('users.show', $row['id']) . '" title="show user"
                                   class="table-action-btn btn btn-success table-icon-btn  show-btn mb-2">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                       <circle cx="12" cy="12" r="2" />
                                       <path d="M2 12s3-6 10-6s10 6 10 6s-3 6-10 6s-10-6-10-6z" />
                                   </svg>
                                </a>';
                            }
                            $btn .= '</div>';
                        } else{
                            $btn = '-';
                        }
                        return $btn;
                    })
                    ->filterColumn('role_id', function ($query, $keyword) {
                        $query->whereHas('role', function ($query) use ($keyword) {
                            $query->where('name', 'like', '%'.$keyword.'%');
                        });
                    })
                    ->filterColumn('parent_id', function ($query, $keyword) {
                        $query->whereHas('parentUser', function ($query) use ($keyword) {
                            $query->where('name', 'like', '%'.$keyword.'%');
                        });
                    })
                    ->rawColumns(['action','image','status','discomfort'])
                    ->make(true);
            }

            return view('admin.users.index');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'UserController',
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
            if (! Auth::user()->can('user-create')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            if(auth()->guard('web')->user()->role_id == 5 && (org_user_count() >= auth()->guard('web')->user()->user_limit)){
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $roles = Role::all();
            $sub_category = SubCategory::all();
            $super_category = SuperCategory::all();
            return view('admin.users.create', compact('roles','sub_category','super_category'));
        } catch (\Throwable $th) {
            $data = [
                'name' => 'UserController',
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
            if (! Auth::user()->can('user-create')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $role = Role::find($request->role_id);
            $input = $request->all();
            $password = Hash::make($request->password);


            if ($request->hasFile('image')) {
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('storage/users'), $imageName);
                $input['original_image'] = $imageName;

                $image_path = public_path('storage/users').'/'.$imageName;
                $webpimage = convert_webp($image_path);
                $webpimage['image']->save(public_path('storage/users/'.$webpimage['imagename']));
                $input['image'] = $webpimage['imagename'];
            }else{
                $input['image'] = null;
                $input['original_image'] = null;
            }

            $User_data = [
                'name' => $request->name,
                'role_id' => auth()->guard('web')->user()->role_id == 5 ? 3 : $request->role_id,
                'time_of_birth' => $request->time_of_birth,
                'place_of_birth' => $request->place_of_birth,
                'email' => $request->email,
                'dob' => \Carbon\Carbon::parse($request->dob)->format('Y-m-d'),  // Format 'dob' to Ymd
                'mobile_number_1' => $request->mobile_number_1,
                'mobile_number_2' => $request->mobile_number_2,
                'discomfort' => $request->discomfort,
                'image' => $webpimage['imagename'],
                'original_image' => $input['original_image'],
                'password' => $password,
            ];
            if(auth()->guard('web')->user()->role_id == 5){
                $User_data['parent_id'] = auth()->guard('web')->user()->id;
            }
            if($request->role_id == 4 || $request->role_id == 5){
                $User_data['frequency'] = json_encode($request->frequency);
                $User_data['start_date'] = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d');
                $User_data['end_date'] = \Carbon\Carbon::parse($request->end_date)->format('Y-m-d');
            }
            if($request->role_id == 5){
                $User_data['user_limit'] = $request->user_limit;
            }

            $User = User::create($User_data);
            $User->assignRole($role);
            $User->save();

            return redirect()->route('users.index')->with('success', 'User Added Successfully!');

        } catch (\Throwable $th) {
            $data = [
                'name' => 'UserController',
                'module' => 'store',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            if (! Auth::user()->can('user-view')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $user = User::find($id);
            if(!$user){
                return redirect()->route('users.index')->with('error','User not found.');
            }
            $pur_payment = Payment::where('user_id',$user->id)->orderBy('id','desc')->get();
            $customized = "";
            if($user->role_id == 4){
                $customized = SubCategory::whereIn('id',json_decode($user->frequency))->get();
            }
            return view('admin.users.show', compact('user','pur_payment','customized'));
        } catch (\Throwable $th) {
            $data = [
                'name' => 'UserController',
                'module' => 'show',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            if(auth()->guard('web')->user()->role_id == 5){ // check if organization admins user
                $user = User::where('parent_id',auth()->guard('web')->user()->id)->where('id',$id)->exists();
                if(!$user){
                    return back()->with(['error' => 'Unauthorized Access.']);
                }
            }
            $user = User::find($id);
            if(!$user){
                return redirect()->route('users.index')->with('error','User not found.');
            }
            if (! Auth::user()->can('user-edit') || ($user->role_id == 1 && auth()->user()->role_id != 1)) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $roles = Role::all();
            $sub_category = SubCategory::all();
            $super_category = SuperCategory::all();
            return view('admin.users.edit', compact('user', 'roles', 'sub_category', 'super_category'));

        } catch (\Throwable $th) {
            $data = [
                'name' => 'UserController',
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
            if (! Auth::user()->can('user-edit')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $user = User::findOrFail($id);
            $password = !empty($request->password) ? Hash::make($request->password) : $user->password;

            if ($request->hasFile('image')) {
                if($user->original_image != null){
                    $image_name = str_replace(url('storage/users').'/', '', $user->original_image);
                    $image_path = public_path('storage/users').'/'.$image_name;
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                }
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('storage/users'), $imageName);
                $user->original_image = $imageName;

                $image_name = str_replace(url('storage/users').'/', '', $user->image);
                $image_path = public_path('storage/users').'/'.$image_name;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
                $image_path = public_path('storage/users').'/'.$imageName;
                $webpimage = convert_webp($image_path);
                $webpimage['image']->save(public_path('storage/users/'.$webpimage['imagename']));
                $user->image = $webpimage['imagename'];
            }
            $role = Role::find($request->role_id);

            $user->name = $request->name;
            $user->role_id = auth()->guard('web')->user()->role_id == 5 ? 3 : $request->role_id;
            $user->time_of_birth = $request->time_of_birth;
            $user->place_of_birth = $request->place_of_birth;
            $user->email = $request->email;
            $user->dob = \Carbon\Carbon::parse($request->dob)->format('Y-m-d'); // Format 'dob' to Ymd
            $user->mobile_number_1 = $request->mobile_number_1;
            $user->mobile_number_2 = $request->mobile_number_2;
            $user->discomfort = $request->discomfort;
            $user->password = $password;
            $user->frequency = $request->role_id == 4 || $request->role_id == 5 ? json_encode($request->frequency) : null;
            $user->start_date = $request->role_id == 4 || $request->role_id == 5 ? \Carbon\Carbon::parse($request->start_date)->format('Y-m-d') : null;
            $user->end_date = $request->role_id == 4 || $request->role_id == 5 ? \Carbon\Carbon::parse($request->end_date)->format('Y-m-d') : null;
            $user->user_limit = $request->role_id == 5 ? $request->user_limit : null;
            $user->update();

            DB::table('model_has_roles')->where('model_id',$id)->delete();
            $user->assignRole($role);

            return redirect()->route('users.index')->with('success', 'User updated successfully');

        } catch (\Throwable $th) {
            $data = [
                'name' => 'UserController',
                'module' => 'update',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return redirect()->back()->with('error', 'Error updating user: ' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            if (! Auth::user()->can('user-delete')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $user = User::find($id);

            if ($user != null) {
                if($user->original_image != null){
                    $image_name = str_replace(url('storage/users').'/', '', $user->original_image);
                    $image_path = public_path('storage/users').'/'.$image_name;
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                }

                $image_name = str_replace(url('storage/users').'/', '', $user->image);
                $image_path = public_path('storage/users').'/'.$image_name;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }

                $user->delete();
                return response()->json(['status' => 1, 'message' => 'User deleted successfully'], 200);
            }else{
                return response()->json(['status' => 0, 'message' => 'User not found.']);
            }

        } catch (\Throwable $th) {
            $data = [
                'name' => 'UserController',
                'module' => 'destroy',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return response()->json(['status' => 0, 'message' => $th->getMessage()]);
        }
    }

    public function checkEmail(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|unique:users,email',
                // 'email' => 'required|unique:users,email,NULL,id,deleted_at,NULL',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => '1', 'message' => 'Email Already Exists!']);
            }

            return response()->json(['status' => '0']);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'Controller',
                'module' => 'checkEmail',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return response()->json(['error' => $th->getMessage()], 500);
        }

    }
    public function checkEmailEdit(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|unique:users,email,'.$request->id,
                // 'email' => 'required|unique:users,email,'.$request->id.',id,deleted_at,NULL',
            ];
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => '1', 'message' => 'Email Already Exists!']);
            } else {
                return response()->json(['status' => '0']);
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'UserController',
                'module' => 'checkEmailEdit',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function updateStatus($id, Request $request) {
        try {
            User::whereId($id)->update(['status' => $request->status]);
            return response()->json(['status' => 1]);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'UserController',
                'module' => 'updateStatus',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return response()->json(['status' => 0, 'message' => $th->getMessage()]);
        }
    }


}
