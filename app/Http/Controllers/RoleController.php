<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DataTables;
use App\Models\Log;
use App\Models\User;
use DB;
use Auth; 


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // Apply the `role-list` permission check to the `index` method
        $this->middleware('permission:role-list', ['only' => ['index']]);

        // Apply the `role-create` permission check to the `create` and `store` methods
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);

        // Apply the `role-edit` permission check to the `edit` and `update` methods
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);

        // Apply the `role-delete` permission check to the `destroy` method
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        try{
            if ($request->ajax()) {
                $roles = Role::get();
                return Datatables::of($roles)
                        ->addColumn('action', function ($data) {
                            $btn = '';
                                if(Auth::user()->can('role-edit')){
                                   $btn .= ' <a href="'.route('roles.edit', $data->id).'" title="Edit Role" class="table-action-btn btn btn-success table-icon-btn mb-2" data-id="'.$data['id'].'"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#FFFFFF" viewBox="0 0 24 24"><path d="M7.127 22.562l-7.127 1.438 1.438-7.128 5.689 5.69zm1.414-1.414l11.228-11.225-5.69-5.692-11.227 11.227 5.689 5.69zm9.768-21.148l-2.816 2.817 5.691 5.691 2.816-2.819-5.691-5.689z"/></svg></a>';
                                }
                                if(Auth::user()->can('role-delete') && $data->id != 1){
                                   $btn .= ' <a data-href="'.route('roles.destroy', $data->id).'" title="Delete Role" class="table-action-btn btn btn-danger delete_btn table-icon-btn mb-2" data-id="'.$data['id'].'"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"> <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/> <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/> </svg></a>';
                                }
                            return $btn;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
            }
            return view('admin.roles.index');
        }catch (\Exception $th) {
            $data = [
                'name' => 'RoleController',
                'module' => 'index',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view('admin.roles.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
            'permission.*' => 'exists:permissions,id',
        ]);
        try{
            $role = Role::create(['name' => $request->name]);
            $permissions = Permission::whereIn('id', $request->permission)->get();
            $role->syncPermissions($permissions);
            return redirect()->route('roles.index')
                ->with('success', 'Role created successfully');
        }catch (\Throwable $th) {
            $data = [
                'name' => 'RoleController',
                'module' => 'store',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $role = Role::find($id);
            $permission = Permission::get();
            $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
                ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                ->all();
            return view('admin.roles.edit',compact('role','permission','rolePermissions'));
        } catch (\Throwable $th) {
            $data = [
                'name' => 'RoleController',
                'module' => 'edit',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$id,
            'permission' => 'required|array',
        ]);
        try {
            $role = Role::find($id);
            $permissionIds = $request->permission;
            $permissions = Permission::whereIn('id', $permissionIds)->get();
            $role->name = $request->name;
            $role->syncPermissions($permissions);
            $role->save();
            return redirect()->route('roles.index')->with('success', 'Role updated successfully');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'RoleController',
                'module' => 'update',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (User::where('role_id', $id)->exists()) {
                return response()->json(['status' => 0,"message" => "Roles issue has link with user."]);
            } else {
                $Roles = Role::find($id);
                $Roles->delete();
                return response()->json(['status' => 1]);
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'RoleController',
                'module' => 'destroy',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return response()->json(['status' => 0 ,'message' => $th->getMessage()]);
        }
    }
}
