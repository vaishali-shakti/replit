<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use App\Models\SuperCategory;
use App\Models\Package;
use Yajra\DataTables\DataTables;
use DB;

class SuperCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            if (! Auth::user()->can('category-list')) {
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }
            if ($request->ajax()) {
                $category = SuperCategory::select("*");
                return DataTables::of($category)
                    ->editColumn('order_by', function ($row) {
                        return $row->order_by ? $row->order_by : '-';
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '';
                        if (Auth::user()->can('category-edit')) {
                            $btn = '<a href="'.route('category.edit', $row['id']).'" title="edit category" class="table-action-btn edit btn btn-primary table-icon-btn"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path d="M7.127 22.562l-7.127 1.438 1.438-7.128 5.689 5.69zm1.414-1.414l11.228-11.225-5.69-5.692-11.227 11.227 5.689 5.69zm9.768-21.148l-2.816 2.817 5.691 5.691 2.816-2.819-5.691-5.689z"/></svg></a>';
                        }
                        if (Auth::user()->can('category-delete')) {
                            $btn .= '<a href="javascript:void(0);" data-href="'.route('category.destroy', $row->id).'" title="delete category" class="table-action-btn btn btn-danger delete_btn table-icon-btn me-2" data-id="'.$row['id'].'"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                          </svg>
                        </a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('admin.category.index');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SuperCategoryController',
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
            if (! Auth::user()->can('category-create')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            return view('admin.category.create');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SuperCategoryController',
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
        try {
            if (! Auth::user()->can('category-create')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $cat_id = SuperCategory::create([
                'name' => $request->name,
                'meta_title' => $request->meta_title,
                'keyword' => $request->keyword,
                'description' => $request->description,
                'canonical' => $request->canonical,
                'order_by' => $request->order_by
            ]);

            // Package::create([
            //     'cat_id' => $cat_id->id,
            //     'name' => $request->package_name,
            //     'times_day' => $request->times_day,
            //     'days' => $request->days,
            //     'cost' => $request->cost
            // ]);
            return redirect()->route('category.index')->with('success', 'Category Added Successfully!');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SuperCategoryController',
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
            $user = Auth::user();
            if (!$user->can('category-edit') || !SuperCategory::where('id', $id)->exists() || !SuperCategory::where('id', $id)->exists())
            {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $category = SuperCategory::find($id);

            return view('admin.category.edit', compact('category'));
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SuperCategoryController',
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
            if (!Auth::user()->can('category-edit')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }

            $category = SuperCategory::find($id);
            $category->name = $request->name;
            $category->meta_title = $request->meta_title;
            $category->keyword = $request->keyword;
            $category->description = $request->description;
            $category->canonical = $request->canonical;
            $category->order_by = $request->order_by;
            $category->save();
            // Package::updateOrCreate(
            //     ['cat_id' => $category->id],
            //     [
            //         'name' => $request->package_name,
            //         'times_day' => $request->times_day,
            //         'days' => $request->days,
            //         'cost' => $request->cost,
            //     ]
            // );
            return redirect()->route('category.index')->with('success', 'Category Updated Successfully.');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SuperCategoryController',
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
            if (! Auth::user()->can('category-delete')) {
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $category = SuperCategory::find($id);
            if (!$category) {
                return response()->json(['status' => 0, 'message' => 'Category not found.'], 404);
            }
            $hasMainCategories = DB::table('main_category')->where('super_cat_id', $id)->whereNull('deleted_at')->exists();
            if ($hasMainCategories) {
                return response()->json(['status' => 0, 'message' => 'Category has MainCategories. Please delete MAinCategories first.'], 200);
            }
            $category->delete();
    
            return response()->json(['status' => 1, 'message' => 'Category deleted successfully'], 200);
    
        } catch (\Throwable $th) {
            $data = [
                'name' => 'SuperCategoryController',
                'module' => 'destroy',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
    
            return redirect()->back()->with('error', 'An error occurred: ' . $th->getMessage());
        }
    }
}
