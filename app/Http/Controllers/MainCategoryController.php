<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use App\Models\MainCategory;
use App\Models\SuperCategory;
use App\Models\Package;
use App\Models\Payment;
use Yajra\DataTables\DataTables;
use DB;

class MainCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            if (! Auth::user()->can('main-category-list')) {
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }
            if ($request->ajax()) {
                $main_category = MainCategory::with('super_category');
                return DataTables::of($main_category)
                    ->filterColumn('category_name', function ($query, $keyword) {
                        $query->whereHas('super_category', function ($q) use ($keyword) {
                            $q->where('name', 'like', "%{$keyword}%");
                        });
                    })
                    ->editColumn('description', function ($row) {
                        $descriptionText = strip_tags($row->description);
                        $descriptionText = str_replace('&nbsp;', ' ', $descriptionText);

                        $shortDescription = strlen($descriptionText) > 50 ? substr($descriptionText, 0, 50) . '...' : $descriptionText;

                        return '<span data-bs-toggle="tooltip" data-bs-placement="top" title="' . htmlspecialchars($descriptionText) . '">' . $shortDescription . '</span>';
                    })
                    ->addColumn('image', function ($row) {
                        return '<img src="'.$row->image.'" class="rounded" height="50" weight="50"/>';
                    })
                    ->editColumn('order_by', function ($row) {
                        return $row->order_by ? $row->order_by : '-';
                    })
                    ->addColumn('category_name', function ($row) {
                        return $row->super_category ? $row->super_category->name : '-';
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '';
                        if (Auth::user()->can('main-category-edit')) {
                            $btn = '<a href="'.route('main_category.edit', $row->id).'" title="edit maincategory" class="table-action-btn edit btn btn-primary table-icon-btn"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path d="M7.127 22.562l-7.127 1.438 1.438-7.128 5.689 5.69zm1.414-1.414l11.228-11.225-5.69-5.692-11.227 11.227 5.689 5.69zm9.768-21.148l-2.816 2.817 5.691 5.691 2.816-2.819-5.691-5.689z"/></svg></a>';
                        }
                        if (Auth::user()->can('main-category-delete')) {
                            $btn .= '<a href="javascript:void(0);" data-href="'.route('main_category.destroy', $row->id).'" title="delete category" class="table-action-btn btn btn-danger delete_btn table-icon-btn me-2" data-id="'.$row['id'].'"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                          </svg>
                        </a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','image','audio' , 'video','description'])
                    ->make(true);
            }

            return view('admin.main_category.index');
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            if (! Auth::user()->can('main-category-create')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $categories=SuperCategory::select("*")->get();
            return view('admin.main_category.create' ,compact('categories'));
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Auth::user()->can('category-create')) {
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('storage/main_category/images'), $imageName);
            $input['original_image'] = $imageName;

            $image_path = public_path('storage/main_category/images').'/'.$imageName;
            $webpimage = convert_webp($image_path);
            $webpimage['image']->save(public_path('storage/main_category/images/'.$webpimage['imagename']));
            $input['image'] = $webpimage['imagename'];
        }
        else{
            $input['image'] = null;
            $input['original_image'] = null;
        }

        $sub_cat = MainCategory::create([
            'super_cat_id' => $request->cat_id,
            'name' => $request->name,
            'description' => $request->description,
            'meta_title' => $request->meta_title,
            'keyword' => $request->keyword,
            'meta_description' => $request->meta_description,
            'canonical' => $request->canonical,
            'special_music' => $request->specialmusic,
            'image' => $input['image'],
            'original_image' => $input['original_image'],
            'order_by' => $request->order_by
        ]);

        foreach($request->package_name as $key => $value){
            Package::create([
                'cat_id' => $sub_cat->id,
                'name' => $value,
                'days' => $request->days[$key],
                'cost' => $request->cost[$key],
                'cost_usd' =>$request->cost_usd[$key],
                'cost_euro' =>$request->cost_euro[$key],
                'packages_order_by' => $request->package_order_by[$key]
            ]);
        }

        return redirect()->route('main_category.index')->with('success', 'Main category created successfully.');
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
        try {
            if (! Auth::user()->can('main-category-edit')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $main_category = MainCategory::find($id);
            if(!$main_category){
                return redirect()->route('main_category.index')->with('error','Main category not found.');
            }
            $categories=SuperCategory::select("*")->get();
            return view('admin.main_category.edit' ,compact('main_category','categories'));
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            if (! Auth::user()->can('main-category-edit')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $main_category = MainCategory::find($id);

            if ($request->hasFile('image')) {
                if($main_category->original_image != null){
                    $image_name = str_replace(url('storage/main_category/images').'/', '', $main_category->original_image);
                    $image_path = public_path('storage/main_category/images').'/'.$image_name;
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                }
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('storage/main_category/images'), $imageName);
                $main_category->original_image = $imageName;

                $image_name = str_replace(url('storage/main_category/images').'/', '', $main_category->image);
                $image_path = public_path('storage/main_category/images').'/'.$image_name;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
                $image_path = public_path('storage/main_category/images').'/'.$imageName;
                  $webpimage = convert_webp($image_path);
                $webpimage['image']->save(public_path('storage/main_category/images/'.$webpimage['imagename']));
                $main_category->image = $webpimage['imagename'];
            }

            $main_category->super_cat_id = $request->cat_id;
            $main_category->name = $request->name;
            $main_category->description = $request->description;
            $main_category->meta_title = $request->meta_title;
            $main_category->keyword = $request->keyword;
            $main_category->meta_description = $request->meta_description;
            $main_category->canonical = $request->canonical;
            $main_category->special_music = $request->specialmusic;
            $main_category->order_by = $request->order_by;
            $main_category->save();
            if(isset($request->package_name)){
                foreach($request->package_name as $key => $value){
                    if(isset($value) && $value != ''){
                        $package = array(
                            'cat_id' => $main_category->id,
                            'name' => $value,
                            'days' => isset($request->days[$key]) ? $request->days[$key] : null,
                            'cost' => isset($request->cost[$key]) ? $request->cost[$key] : null,
                            'cost_usd' => isset($request->dollar_cost[$key]) ? $request->dollar_cost[$key] : null,
                            'cost_euro' => isset($request->cost_euro[$key]) ? $request->cost_euro[$key] : null,
                            'packages_order_by' => isset($request->package_order_by[$key]) ? $request->package_order_by[$key] : null
                        );
                        if(isset($request->package_id[$key]) && $request->package_id[$key] != '') {
                            Package::where('id', $request->package_id[$key])->update($package);
                        }else{
                            Package::create($package);
                        }
                    }
                }
            }
            return redirect()->route('main_category.index')->with('success', 'Main category updated successfully.');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'MainCategoryController',
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
            if (! Auth::user()->can('subcategory-delete')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $main_category = MainCategory::find($id);
            if ($main_category) {
                $hasSubcategories = DB::table('subcategory')->where('cat_id', $id)->whereNull('deleted_at')->exists();
                $payment_plan = Payment::whereHas('package', function($que) use($id){
                    $que->where('cat_id',$id)->where('type',2);
                })->whereHas('getUserDetails')
                ->where('active_until','>',date('Y-m-d H:i:s'))->exists();

                if ($hasSubcategories) {
                    return response()->json(['status' => 0, 'message' => 'Main category has SubCategories. Please delete SubCategories first.'], 200);
                }else if($payment_plan == true){
                    return response()->json(['status' => 2 , 'message' => 'User Main category plan is currently active so you can not delete this main category!']);
                } else {
                    if ($main_category->original_image) {
                        $image_name = str_replace(url('storage/main_category/images') . '/', '', $main_category->original_image);
                        $image_path = public_path('storage/main_category/images') . '/' . $image_name;
                        if (file_exists($image_path)) {
                            unlink($image_path);
                        }
                    }
                    if ($main_category->image) {
                        $image_name = str_replace(url('storage/main_category/images') . '/', '', $main_category->image);
                        $image_path = public_path('storage/main_category/images') . '/' . $image_name;
                        if (file_exists($image_path)) {
                            unlink($image_path);
                        }
                    }
                    $main_category->delete();
                    return response()->json(['status' => 1, 'message' => 'Main category deleted successfully'], 200);
                }
            } else {
                return response()->json(['status' => 0, 'message' => 'Main category not found.'], 404);
            }
        } catch (\Throwable $th) {
            $data = [
                'name' => 'MainCategoryController',
                'module' => 'destroy',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
    
            return redirect()->back()->with('error', 'An error occurred: ' . $th->getMessage());
        }
    }
    
    public function status_change(Request $request,$id)
    {
        try{
            $package = Package::find($id);
            if($package != null){
                $active_package = Package::where(function($query) use($package){
                    $query->where(function($q) use($package): void{
                        $q->where('cat_id', $package->cat_id)
                          ->orWhereNull('cat_id');
                    })
                    ->where(function($q) use($package){
                        $q->where('sub_cat_id',$package->sub_cat_id)
                         ->orWhereNull('sub_cat_id');
                    })
                    ->where('status',1);
                })->count();
                if($request->status == 0 && $active_package <= 1){
                    return response()->json(['status' => 2]);
                }else{
                    $package->status = $request->status;
                    $package->save();
                    return response()->json(['status' => 1]);
                }
            }else{
                return response()->json(['status' => 0]);
            }
        }catch (\Throwable $th) {
            $data = [
                'name' => 'MainCategoryController',
                'module' => 'status_change',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
