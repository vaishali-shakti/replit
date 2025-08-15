<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\Package;
use App\Models\Payment;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            if (! Auth::user()->can('subcategory-list')) {
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }
            if ($request->ajax()) {
                $subcategory = SubCategory::with('main_category');
                return DataTables::of($subcategory)
                    ->filterColumn('category_name', function ($query, $keyword) {
                        $query->whereHas('main_category', function ($q) use ($keyword) { // Corrected here
                            $q->where('name', 'like', "%{$keyword}%");
                        });
                    })
                    ->editColumn('description', function ($row) {
                        $descriptionText = strip_tags($row->description);
                        $descriptionText = str_replace('&nbsp;', ' ', $descriptionText);

                        $shortDescription = strlen($descriptionText) > 50 ? substr($descriptionText, 0, 50) . '...' : $descriptionText;

                        return '<span data-bs-toggle="tooltip" data-bs-placement="top" title="' . htmlspecialchars($descriptionText) . '">' . $shortDescription . '</span>';
                    })
                    ->addColumn('status', function($row) {
                        $btn = '-';
                        if($row->role_id != 1){
                            $btn = '<div class="form-group">
                                    <label class="switch" for="status_'.$row->id.'">
                                        <input type="checkbox" class="form-check-input float-none toggle_status" id="status_'.$row->id.'" name="status['.$row->id.']" value="'.$row->id.'" data-href="'.route('subcategory.updateStatus', $row->id).'" ' . ($row->status == 1 ? 'checked' : '') . '>
                                        <span class="slider fs-16"></span>
                                    </label>
                                </div>';
                        }
                        return $btn;
                    })
                    ->editColumn('order_by', function ($row) {
                        return $row->order_by ? $row->order_by : '-';
                    })
                    ->addcolumn('image', function ($row) {
                        return '<img src="'.$row->image.'" class="rounded" height="50" weight="50"/>';
                    })
                    ->addColumn('category_name', function ($row) {
                        return $row->main_category ? $row->main_category->name : '';  // Access category name through the relationship
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<div class="d-flex align-items-start justify-content-center">';
                        if (Auth::user()->can('subcategory-edit')) {
                            $btn .= '<a href="'.route('subcategory.edit', $row['id']).'" title="edit subcategory" class="table-action-btn edit btn btn-primary table-icon-btn"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path d="M7.127 22.562l-7.127 1.438 1.438-7.128 5.689 5.69zm1.414-1.414l11.228-11.225-5.69-5.692-11.227 11.227 5.689 5.69zm9.768-21.148l-2.816 2.817 5.691 5.691 2.816-2.819-5.691-5.689z"/></svg></a>';
                        }
                        if (Auth::user()->can('subcategory-delete')) {
                            $btn .= '<a href="javascript:void(0);" data-href="'.route('subcategory.destroy', $row->id).'" title="delete category" class="table-action-btn btn btn-danger delete_btn table-icon-btn " data-id="'.$row['id'].'"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                          </svg>
                        </a>';
                        }
                        if (Auth::user()->can('subcategory-view'))
                        $btn .= '
                        <a href="' . route('subcategory.show', $row['id']) . '" title="show subcategory"
                           class="table-action-btn btn btn-success table-icon-btn show-btn">
                           <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                               <circle cx="12" cy="12" r="2" />
                               <path d="M2 12s3-6 10-6s10 6 10 6s-3 6-10 6s-10-6-10-6z" />
                           </svg>
                        </a>';

                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action','image' ,'description','status'])
                    ->make(true);
            }

            return view('admin.subcategory.index');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SubCategoryController',
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
            if (! Auth::user()->can('subcategory-create')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $categories = MainCategory::select("*")->get();
            return view('admin.subcategory.create', compact('categories'));
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SubCategoryController',
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
            // Authorization check
            if (!Auth::user()->can('subcategory-create')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }

            $input = $this->handleImage($request);
            $audioPath = $this->uploadToS3($request->file('audio'), 'audio');
            $videoPath = $this->uploadToS3($request->file('video'), 'video');

            DB::beginTransaction();

            // Create Subcategory
            $subCat = SubCategory::create([
                'cat_id' => $request->cat_id,
                'name' => $request->name,
                'image' => $input['image'],
                'original_image' => $input['original_image'],
                'audio' => $audioPath,
                'video' => $videoPath,
                'description' => $request->description,
                'payment_type' => $request->type,
                'meta_title' => $request->meta_title,
                'keyword' => $request->keyword,
                'meta_description' => $request->meta_description,
                'canonical' => $request->canonical,
                'order_by' => $request->order_by,
                'audio_duration' => $this->validateAudioDuration($request->audio_duration),
            ]);

            // if (!empty($request->package_name)) {
            //     $packages = array_map(function ($key) use ($request, $subCat) {
            //         return [
            //             'sub_cat_id' => $subCat->id,
            //             'name' => $request->package_name[$key],
            //             'days' => $request->days[$key],
            //             'cost' => $request->cost[$key],
            //             'cost_usd' => $request->cost_usd[$key],
            //             'cost_euro' => $request->cost_euro[$key],
            //         ];
            //     }, array_keys($request->package_name));
            //     Package::insert($packages);
            // }

            DB::commit();
            return redirect()->route('subcategory.index')->with('success', 'Subcategory created successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::create([
                'name' => 'SubCategoryController',
                'module' => 'store',
                'description' => $th->getMessage(),
            ]);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    private function handleImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('storage/subcategory/images'), $imageName);

            $imagePath = public_path('storage/subcategory/images') . '/' . $imageName;
            $webpImage = convert_webp($imagePath);
            $webpImage['image']->save(public_path('storage/subcategory/images/' . $webpImage['imagename']));

            return [
                'original_image' => $imageName,
                'image' => $webpImage['imagename'],
            ];
        }else{
            return ['original_image' => null,
                'image' => null,
            ];
        }
    }

    private function uploadToS3($file, $type)
    {
        if ($file) {
            $fileName = time() . '.' . $file->extension();
            Storage::disk('s3')->put("{$type}/" . $fileName, file_get_contents($file), 'private');
            return $fileName;
        }else{
            return null;
        }
    }
    private function validateAudioDuration($audioDuration)
    {
        return isset($audioDuration) && substr_count($audioDuration, ':') === 2 ? $audioDuration : null;
    }

    public function show(string $id)
    {
        try {
            if (! Auth::user()->can('subcategory-view')) {

                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $subcategory = SubCategory::with(['main_category'])->find($id);
            if(!$subcategory){
                return redirect()->route('subcategory.index')->with('error','Sub category not found.');
            }
            // Remove HTML tags from description
            $subcategory->description = strip_tags($subcategory->description);

            // Pass the data to the view
            return view('admin.subcategory.show', compact('subcategory'));
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SubCategoryController',
                'module' => 'show',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());

        }
    }

    public function edit(string $id)
    {
        try {
            if (! Auth::user()->can('subcategory-edit')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $subcategory = SubCategory::find($id);
            if(!$subcategory){
                return redirect()->route('subcategory.index')->with('error','Sub category not found.');
            }
            $categories=MainCategory::select("*")->get();
            return view('admin.subcategory.edit' ,compact('subcategory','categories'));
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SubCategoryController',
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
            // Authorization Check
            if (!Auth::user()->can('subcategory-edit')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }

            $subcategory = SubCategory::find($id);
            if (!$subcategory) {
                return back()->with(['error' => 'Subcategory not found.']);
            }

            // Helper function to delete a file if it exists
            // $deleteFile = function ($path) {
            //     if ($path && file_exists($path)) {
            //         unlink($path);
            //     }
            // };
            $deleteFile = function ($path) {
                if ($path && file_exists($path) && is_file($path)) { // Ensure it is a file
                    unlink($path);
                }
            };

            // Handle Image Upload
            if ($request->hasFile('image')) {
                // Prepare file paths
                $oldImagePath = public_path('storage/subcategory/images/') . basename($subcategory->original_image);
                $imageName = time() . '.' . $request->image->extension();
                $imagePath = public_path('storage/subcategory/images/') . $imageName;

                // Delete existing image if exists
                $deleteFile($oldImagePath);

                // Save new image
                $request->image->move(public_path('storage/subcategory/images'), $imageName);
                $subcategory->original_image = $imageName;

                // Convert to WebP
                $webpImage = convert_webp($imagePath);
                $webpImage['image']->save(public_path('storage/subcategory/images/' . $webpImage['imagename']));
                $subcategory->image = $webpImage['imagename'];
            }

            // Handle Audio Upload
            if ($request->hasFile('audio')) {
                $audioName = time() . '.' . $request->audio->extension();
                $audioPath = 'audio/' . $audioName;

                // Delete existing audio from S3
                if ($subcategory->audio) {
                    Storage::disk('s3')->delete('audio/' . $subcategory->audio);
                }

                // Upload new audio to S3
                Storage::disk('s3')->put($audioPath, file_get_contents($request->audio), 'private');
                $subcategory->audio = $audioName;
            }

            // Handle Video Upload
            if ($request->hasFile('video')) {
                $videoName = time() . '.' . $request->video->extension();
                $videoPath = 'video/' . $videoName;

                // Delete existing video from S3
                if ($subcategory->video) {
                    Storage::disk('s3')->delete('video/' . $subcategory->video);
                }

                // Upload new video to S3
                Storage::disk('s3')->put($videoPath, file_get_contents($request->video), 'private');
                $subcategory->video = $videoName;
            }
            // Update Other Fields Manually
            $subcategory->cat_id = $request->cat_id;
            $subcategory->name = $request->name;
            $subcategory->description = $request->description;
            $subcategory->payment_type = $request->type;
            $subcategory->meta_title = $request->meta_title;
            $subcategory->keyword = $request->keyword;
            $subcategory->meta_description = $request->meta_description;
            $subcategory->canonical = $request->canonical;
            $subcategory->order_by = $request->order_by;
            $subcategory->audio_duration = $request->audio_duration ?? null;
            $subcategory->save();

            // Handle Packages
            // if ($request->has('package_name')) {
            //     foreach ($request->package_name as $key => $name) {
            //         if ($name) {
            //             $packageData = [
            //                 'sub_cat_id' => $subcategory->id,
            //                 'name' => $name,
            //                 'days' => $request->days[$key] ?? null,
            //                 'cost' => $request->cost[$key] ?? null,
            //                 'cost_usd' => $request->dollar_cost[$key] ?? null,
            //                 'cost_euro' => $request->cost_euro[$key] ?? null,
            //             ];

            //             if (!empty($request->package_id[$key])) {
            //                 Package::where('id', $request->package_id[$key])->update($packageData);
            //             } else {
            //                 Package::create($packageData);
            //             }
            //         }
            //     }
            // }

            return redirect()->route('subcategory.index')->with('success', 'Subcategory updated successfully.');
        } catch (\Throwable $th) {
            Log::create([
                'name' => 'SubCategoryController',
                'module' => 'update',
                'description' => $th->getMessage(),
            ]);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function destroy(string $id)
    {
        try {
            if (! Auth::user()->can('subcategory-delete')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $subcategory = SubCategory::find($id);
            if ($subcategory) {
                $plan = Payment::whereHas('package',function($que) use($subcategory){
                    $que->where('sub_cat_id',$subcategory->id)
                    ->orWhere('cat_id',$subcategory->cat_id)
                    ->where('type',2);
                })->whereHas('getUserDetails')
                ->where('active_until','>',date('y-m-d H:i:s'))->exists();

                if($plan == true){
                   return response()->json(['status' => 0,'message' => 'User plan is currently active so you are not able to delete this sub category!']);
                } else{
                    if ($subcategory->image) {
                        if($subcategory->original_image != null){
                            $image_name = str_replace(url('storage/subcategory/images').'/', '', $subcategory->original_image);
                            $image_path = public_path('storage/subcategory/images').'/'.$image_name;
                            if (file_exists($image_path)) {
                                unlink($image_path);
                            }
                        }
                        $image_name = str_replace(url('storage/subcategory/images').'/', '', $subcategory->image);
                        $image_path = public_path('storage/subcategory/images').'/'.$image_name;
                        if (file_exists($image_path)) {
                            unlink($image_path);
                        }
                    }
                    if ($subcategory->audio) {
                        // $oldAudioPath = public_path('storage/subcategory/audio/' . $subcategory->audio);
                        // if (file_exists($oldAudioPath)) {
                        //     unlink($oldAudioPath);
                        // }
                        Storage::disk('s3')->delete('audio/'.$subcategory->audio);
                    }
                    if ($subcategory->video) {
                        // $oldVideoPath = public_path('storage/subcategory/video/' . $subcategory->video);
                        // if (file_exists($oldVideoPath)) {
                        //     unlink($oldVideoPath);
                        // }
                        Storage::disk('s3')->delete('video/'.$subcategory->video);
                    }
                    $subcategory->delete();
                    return response()->json(['status' => 1, 'message' => 'SubCategory deleted successfully'], 200);
                }
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SubCategoryController',
                'module' => 'destroy',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function updateStatus($id, Request $request) {
        try {
            SubCategory::whereId($id)->update(['status' => $request->status]);
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
