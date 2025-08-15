<?php

namespace App\Http\Controllers;
use App\Models\Log;
use App\Models\Role;
use App\Models\Cms;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            if (! Auth::user()->can('cms-list')) {
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }
            if ($request->ajax()) {
                $cms = Cms::select("*");
                return DataTables::of($cms)
                    ->editColumn('description', function ($row) {
                        $descriptionText = strip_tags($row->description);
                        $descriptionText = str_replace('&nbsp;', ' ', $descriptionText);
                        
                        $shortDescription = strlen($descriptionText) > 50 ? substr($descriptionText, 0, 50) . '...' : $descriptionText;
        
                        return '<span data-bs-toggle="tooltip" data-bs-placement="top" title="' . htmlspecialchars($descriptionText) . '">' . $shortDescription . '</span>';
                    })
                    ->addcolumn('image', function ($row) {
                        return '<img src="'.$row->image.'"  class="rounded" height="150px" width="150px"/>';
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '';
                        if (Auth::user()->can('cms-edit')) {
                            $btn = '<a href="'.route('cms.edit', $row['id']).'" title="edit cms" class="table-action-btn edit btn btn-primary table-icon-btn"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path d="M7.127 22.562l-7.127 1.438 1.438-7.128 5.689 5.69zm1.414-1.414l11.228-11.225-5.69-5.692-11.227 11.227 5.689 5.69zm9.768-21.148l-2.816 2.817 5.691 5.691 2.816-2.819-5.691-5.689z"/></svg></a>';
                        }
                        if (Auth::user()->can('cms-delete') && $row->id !== 1) {
                            // if (Auth::user()->can('cms-delete')) {
                                $btn .= '<a href="javascript:void(0);" data-href="'.route('cms.destroy', $row->id).'" title="delete cms" class="table-action-btn btn btn-danger delete_btn table-icon-btn me-2" data-id="'.$row['id'].'"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/> 
                            </svg>
                            </a>';
                            // }
                        }
                            return $btn;
                    })
                    ->rawColumns(['action', 'image', 'description'])
                    ->make(true);
            }

            return view('admin.cms.index');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'CmsController',
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
            if (! Auth::user()->can('cms-create')) {
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }
            return view('admin.cms.create');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'CmsController',
                'module' => 'create',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            if (! Auth::user()->can('cms-create')) {
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }

            if ($request->hasFile('image')) {
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('storage/cms'), $imageName);
                $input['original_image'] = $imageName;

                $image_path = public_path('storage/cms').'/'.$imageName;
                $webpimage = convert_webp($image_path);
                $webpimage['image']->save(public_path('storage/cms/'.$webpimage['imagename']));
                $input['image'] = $webpimage['imagename'];
            }

            Cms::create([
                'title' => $request->title,
                'original_image' => $input['original_image'],
                'image' => $input['image'],
                'description' => $request->description
            ]);
            return redirect()->route('cms.index')->with('success', 'Cms Added Successfully!');

        } catch (\Throwable $th) {
            $data = [
                'name' => 'CmsController',
                'module' => 'store',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        try {
            if (! Auth::user()->can('cms-edit')) {
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }
            $cms = Cms::find($id);
            if(!$cms){
                return redirect()->route('cms.index')->with('error', 'CMS not found.');
            }
            return view('admin.cms.edit', compact('cms'));
        } catch (\Throwable $th) {
            $data = [
                'name' => 'CmsController',
                'module' => 'edit',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            if (! Auth::user()->can('cms-edit')) {
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }
            $cms = Cms::find($id);

            if ($request->hasFile('image')) {
                if($cms->original_image != null){
                    $image_name = str_replace(url('storage/cms').'/', '', $cms->original_image);
                    $image_path = public_path('storage/cms').'/'.$image_name;
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                }
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('storage/cms'), $imageName);
                $cms->original_image = $imageName;

                $image_name = str_replace(url('storage/cms').'/', '', $cms->image);
                $image_path = public_path('storage/cms').'/'.$image_name;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
                $image_path = public_path('storage/cms').'/'.$imageName;
                  $webpimage = convert_webp($image_path);
                $webpimage['image']->save(public_path('storage/cms/'.$webpimage['imagename']));
                $cms->image = $webpimage['imagename'];
            }
            $cms->title = $request->title;
            $cms->description = $request->description;
    
            $cms->save();
           
            return redirect()->route('cms.index')->with('success', 'Cms Updated Successfully!');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'CmsController',
                'module' => 'update',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            if (! Auth::user()->can('cms-delete')) {
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }
            $cms = Cms::find($id);
            if ($cms) {
                if($cms->original_image != null){
                    $image_name = str_replace(url('storage/cms').'/', '', $cms->original_image);
                    $image_path = public_path('storage/cms').'/'.$image_name;
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                }
    
                $image_name = str_replace(url('storage/cms').'/', '', $cms->image);
                $image_path = public_path('storage/cms').'/'.$image_name;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }

                $cms->delete(); 
                return response()->json(['status' => 1, 'message' => 'Cms deleted successfully'], 200);
            }
            return redirect()->route('cms.index')->with('error', 'Cms not found.');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'CmsController',
                'module' => 'destroy',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function title_unique_name(Request $request)
    {
        try {
            if (Cms::where('title', $request->title)->exists()) {
                return response()->json(['status' => '1', 'message' => 'Title  Already Exists!']);
            } else {
                return response()->json(['status' => '0']);
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'CmsController',
                'module' => 'title_unique_name',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function edit_title_unique_name(Request $request)
    {
        try {
            $rules = [
                'title' => 'required|unique:cms,title,'.$request->id,
            ];
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => '1', 'message' => 'Title Already Exists!']);
            } else {
                return response()->json(['status' => '0']);
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'CmsController',
                'module' => 'edit_title_unique_name',
                'description' => $th->getMessage(),
            ];
            Log::create($data);

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
