<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use App\Models\Photos;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            if (! Auth::user()->can('gallary-list')) {
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }
            if ($request->ajax()) {
                $photos = Photos::select("*");
                return DataTables::of($photos)
                    ->addcolumn('image', function ($row) {
                        return '<img src="'.$row->image.'"  class="rounded" height="150px" width="150px"/>';
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '';
                        if (Auth::user()->can('gallary-edit')) {
                            $btn = '<a href="'.route('photos.edit', $row['id']).'" title="edit photos" class="table-action-btn edit btn btn-primary table-icon-btn"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path d="M7.127 22.562l-7.127 1.438 1.438-7.128 5.689 5.69zm1.414-1.414l11.228-11.225-5.69-5.692-11.227 11.227 5.689 5.69zm9.768-21.148l-2.816 2.817 5.691 5.691 2.816-2.819-5.691-5.689z"/></svg></a>';
                        }
                        if (Auth::user()->can('gallary-delete')) {
                            $btn .= '<a href="javascript:void(0);" data-href="'.route('photos.destroy', $row->id).'" title="delete photos" class="table-action-btn btn btn-danger delete_btn table-icon-btn me-2" data-id="'.$row['id'].'"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                          </svg>
                        </a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action', 'image'])
                    ->make(true);
            }

            return view('admin.photos.index');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'PhotosController',
                'module' => 'index',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            if (! Auth::user()->can('gallary-create')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            return view('admin.photos.create');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'PhotosController',
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
            if (! Auth::user()->can('gallary-create')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            if ($request->hasFile('image')) {
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('storage/photos'), $imageName);
                $input['original_image'] = $imageName;

                $image_path = public_path('storage/photos').'/'.$imageName;
                $webpimage = convert_webp($image_path);
                $webpimage['image']->save(public_path('storage/photos/'.$webpimage['imagename']));
                $input['image'] = $webpimage['imagename'];
            }

            Photos::create([
                'image' => $input['image'],
                'original_image' => $input['original_image']
            ]);
            return redirect()->route('photos.index')->with('success', 'Photos Added Successfully!');

        } catch (\Throwable $th) {
            $data = [
                'name' => 'PhotosController',
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
            if (! Auth::user()->can('gallary-edit')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $photos = Photos::find($id);
            if(!$photos){
                return redirect()->route('photos.index')->with('error','Photos not found.');
            }
            return view('admin.photos.edit', compact('photos'));
        } catch (\Throwable $th) {
            $data = [
                'name' => 'PhotosController',
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
            if (! Auth::user()->can('gallary-edit')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $photos = Photos::find($id);

            if ($request->hasFile('image')) {
                if($photos->original_image != null){
                    $image_name = str_replace(url('storage/photos').'/', '', $photos->original_image);
                    $image_path = public_path('storage/photos').'/'.$image_name;
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                }
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('storage/photos'), $imageName);
                $photos->original_image = $imageName;

                $image_name = str_replace(url('storage/photos').'/', '', $photos->image);
                $image_path = public_path('storage/photos').'/'.$image_name;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
                $image_path = public_path('storage/photos').'/'.$imageName;
                $webpimage = convert_webp($image_path);
                $webpimage['image']->save(public_path('storage/photos/'.$webpimage['imagename']));
                $photos->image = $webpimage['imagename'];
            }

            $photos->save();
            return redirect()->route('photos.index')->with('success', 'Photos Updated Successfully!');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'PhotosController',
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
            if (! Auth::user()->can('gallary-delete')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $photos = Photos::find($id);
            if ($photos) {
                if($photos->original_image != null){
                    $image_name = str_replace(url('storage/photos').'/', '', $photos->original_image);
                    $image_path = public_path('storage/photos').'/'.$image_name;
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                }
    
                $image_name = str_replace(url('storage/photos').'/', '', $photos->image);
                $image_path = public_path('storage/photos').'/'.$image_name;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }

                $photos->delete(); 
                return response()->json(['status' => 1, 'message' => 'Photo deleted successfully'], 200);
            }
            return redirect()->route('about.index')->with('error', 'Photo not found.');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'PhotosController',
                'module' => 'destroy',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
