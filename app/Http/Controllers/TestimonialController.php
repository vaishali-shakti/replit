<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use App\Models\Testimonial;
use Yajra\DataTables\DataTables;

class TestimonialController extends Controller
{
   
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            if (! Auth::user()->can('testimonial-list')) {
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }
            if ($request->ajax()) {
                $testimonial = Testimonial::select("*");
                return DataTables::of($testimonial)
                    ->addColumn('action', function ($row) {
                        $btn = '';
                        // if (Auth::user()->can('testimonial-edit')) {
                        //     $btn = '<a href="'.route('testimonial.edit', $row['id']).'" title="edit catestimonialtegory" class="table-action-btn edit btn btn-primary table-icon-btn"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path d="M7.127 22.562l-7.127 1.438 1.438-7.128 5.689 5.69zm1.414-1.414l11.228-11.225-5.69-5.692-11.227 11.227 5.689 5.69zm9.768-21.148l-2.816 2.817 5.691 5.691 2.816-2.819-5.691-5.689z"/></svg></a>';
                        // }
                        if (Auth::user()->can('category-delete')) {
                            $btn .= '<a href="javascript:void(0);" data-href="'.route('testimonial.destroy', $row->id).'" title="delete testimonial" class="table-action-btn btn btn-danger delete_btn table-icon-btn me-2" data-id="'.$row['id'].'"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/> 
                          </svg>
                        </a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('admin.testimonial.index');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'TestimonialController',
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
            if (! Auth::user()->can('testimonial-create')) {
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }
            return view('admin.testimonial.create');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'TestimonialController',
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
            if (! Auth::user()->can('testimonial-create')) {
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }
            Testimonial::create([
                'email' => $request->email,
            ]);
            return redirect()->route('testimonial.index')->with('success', 'Testimonial Added Successfully!');

        } catch (\Throwable $th) {
            $data = [
                'name' => 'TestimonialController',
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
        // try {
        //     if (! Auth::user()->can('testimonial-edit')) {
        //         return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
        //     }
        //     $testimonial = Testimonial::findOrFail($id);
        //     return view('admin.testimonial.edit', compact('testimonial'));
        // } catch (\Throwable $th) {
        //     $data = [
        //         'name' => 'TestimonialController',
        //         'module' => 'edit',
        //         'description' => $th->getMessage(),
        //     ];
        //     Log::create($data);
        //     return redirect()->back()->with('error', $th->getMessage());
        // }
    }

    public function update(Request $request, string $id)
    {
        // try {
        //     if (! Auth::user()->can('testimonial-edit')) {
        //         return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
        //     }
        //     $testimonial = Testimonial::findOrFail($id);
        //     $testimonial->update([
        //         'email' => $request->email,
        //     ]);
        //     return redirect()->route('testimonial.index')->with('success', 'Testimonial Updated Successfully!');
        // } catch (\Throwable $th) {
        //     $data = [
        //         'name' => 'TestimonialController',
        //         'module' => 'update',
        //         'description' => $th->getMessage(),
        //     ];
        //     Log::create($data);
        //     return redirect()->back()->with('error', $th->getMessage());
        // }
    }

    public function destroy(string $id)
    {
        try {
            if (! Auth::user()->can('testimonial-delete')) {
                return redirect()->route('admin.dashboard')->with(['error' => 'Unauthorized Access.']);
            }
            Testimonial::findOrFail($id)->delete();
            return response()->json(['status' => 1, 'message' => 'Testimonial deleted successfully'], 200);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'TestimonialController',
                'module' => 'destroy',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
