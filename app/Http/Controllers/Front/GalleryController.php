<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Photos;
use App\Models\Log;

class GalleryController extends Controller
{
    public function index(){
        try{
            $gallary = Photos::orderBy('id','desc')->take(12)->get();
            $gallary_count = Photos::orderBy('id','desc')->count();
            return view('front.gallery.index', compact('gallary','gallary_count'));
        } catch (\Throwable $th) {
            $data = array(
                "name" => 'GalleryController',
                "module" => 'index',
                "description" => $th->getMessage(),
            );
            Log::create($data);
            return redirect()->back()->with('error',$th->getMessage());
        }
    }

    public function gallery_load_more(Request $request){
        try{
            $gallary = Photos::orderBy('id','desc')->where('id', '<', $request->id)->take(12)->get();
            $gallary_count = Photos::orderBy('id','desc')->where('id', '<', $request->id)->count();
            $html = view('front.gallery.gallery_data',compact('gallary','gallary_count'))->render();
            return response()->json(['status' => 1,'html' => $html]);
        } catch (\Throwable $th) {
            $data = array(
                "name" => 'GalleryController',
                "module" => 'gallery_load_more',
                "description" => $th->getMessage(),
            );
            Log::create($data);
            return response()->json(['status' => 0,'message' => $th->getMessage()]);
        }
    }
}
