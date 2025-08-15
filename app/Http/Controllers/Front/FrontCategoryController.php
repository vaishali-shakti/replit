<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuperCategory;
use App\Models\SubCategory;
use App\Models\MainCategory;
use App\Models\Rating;
use App\Models\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class FrontCategoryController extends Controller
{
    public function index($id){
        $category = SuperCategory::with('mainCategories')->find($id);
        return view('front.category.index', compact('category'));
    }

    public function pro_music_list(){
        $pro_music = MainCategory::where('special_music',1)->orderBy('id','desc')->get();
        return view('front.category.pro_music', compact('pro_music'));
    }

    public function music_details($id){
        $sub_cat = SubCategory::find($id);
        return view('front.category.category_detail' , compact('sub_cat'));
    }

    public function categories($slug = null){
        $slug = isset($slug)?$slug:'';
        $category = SuperCategory::with('mainCategories')->where('slug_name', $slug)->first();
        if(!$category){
            return redirect()->route('home')->with('error','Oops! This category does not exist.');
        }
        return view('front.category.index', compact('category'));
    }

    public function main_categories($slug,$slug1 = null){
        $slug = isset($slug)?$slug:'';
        $category = MainCategory::whereHas('super_category',function($q) use($slug){
            $q->where('slug_name',$slug);
        })->with('subCategories')->where('slug_name', $slug1)->first();
        if(!$category){
            return redirect()->route('home')->with('error','Oops! This category does not exist.');
        }
        return view('front.main_category.index', compact('category'));
    }

    public function sub_categories($slug,$slug1,$slug2 = null){
        $slug = isset($slug)?$slug:'';
        $sub_cat = SubCategory::whereHas('main_category',function($que) use($slug,$slug1){
            $que->where('slug_name',$slug1)->whereHas('super_category',function($q) use($slug){
                $q->where('slug_name',$slug);
            });
        })->where('slug_name', $slug2)->first();
        if(!$sub_cat){
            return redirect()->route('home')->with('error','Oops! This category does not exist.');
        }
        return view('front.category.category_detail', compact('sub_cat'));
    }

    public function audio_detail(Request $request){
        $sub_cat = SubCategory::find($request->id);
        if ($sub_cat->audio != null && Storage::disk('s3')->exists('audio/'.$sub_cat->audio)) {
            $url = Storage::disk('s3')->temporaryUrl('audio/'.$sub_cat->audio,\Carbon\Carbon::now()->addMinutes(2));
            return response()->json(['status' => 1, 'url' => base64_encode(file_get_contents($url))]);
        }
        return response()->json(['status' => 0, 'message' => 'Audio not available.']);
    }

    public function video_detail(Request $request){
        $sub_cat = SubCategory::find($request->id);
        if ($sub_cat->video != null && Storage::disk('s3')->exists('video/'.$sub_cat->video)) {
            $url = Storage::disk('s3')->temporaryUrl('video/'.$sub_cat->video,\Carbon\Carbon::now()->addMinutes(2));
            return response()->json(['status' => 1, 'url' => base64_encode(file_get_contents($url))]);
        }
        return response()->json(['status' => 0, 'message' => 'Video not available.']);
    }

    public function review_store(Request $request){
        try{
            $request->validate([
                'sub_cat_id' => 'required|exists:subcategory,id',
                'rating' => 'required|integer|min:1|max:5',
            ]);

            $rating = Rating::updateOrCreate(
                ['user_id' => auth()->guard('auth')->user()->id, 'sub_cat_id' => $request->sub_cat_id],
                ['rating' => $request->rating, 'description' => $request->description],
            );
            return response()->json(['status' => 0,'message' => 'Rating submitted successfully']);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'FrontCategoryController',
                'module' => 'review_store',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return response()->json(["status" => 1]);
        }
    }
}
