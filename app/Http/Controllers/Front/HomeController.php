<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cms;
use App\Models\SubCategory;
use App\Models\SuperCategory;
use App\Models\MainCategory;
use App\Models\Contact;
use App\Models\EmailSignups;
use App\Models\Log;
use App\Models\Payment;
use App\Models\Messages;
use App\Models\Supporter;
use DB;
use App\Models\Plans;
use Stevebauman\Location\Facades\Location;
use Session;
use Carbon\Carbon;
use DOMDocument;

class HomeController extends Controller
{
    public function index(){
        // $about = Cms::first();
        $about = Cms::where('slug_name', 'about-us')->first();
        $pro_music = MainCategory::where('special_music',1)->get();
        $plans = Plans::get();
        $category = SuperCategory::with('mainCategories')->orderBy('order_by','asc')->get();
        return view('front.index',compact('about','pro_music','category','plans'));
    }

    public function contact_post(Request $request){
        if ($request->filled('hidden_field')) {
            return response()->json(['status' => 403,'message' => 'Your submission was detected as spam. Please try again.'], 403);
        }
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'number' => 'required',
            'message' => 'required',
        ]);
        try{
            $User_data = [
                'name' => $request->name,
                'email' => $request->email,
                'number' => $request->number,
                'message' => $request->message,
                'user_id' => $request->user_id,
            ];
            $User = Contact::create($User_data);
            return response()->json(["status" => 0]);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'HomeController',
                'module' => 'contact_post',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return response()->json(["status" => 1]);
        }
    }

    public function email_signups(Request $request){
        $request->validate([
            'email' => 'required',
        ]);
        try{
            $data = array(
                "email" => $request->email,
            );

            $data1 = EmailSignups::where('email',$request->email)->first();
            if($data1 == null){
                EmailSignups::create($data);
                return response()->json(["status" => 0]);
            } else{
                return response()->json(["status" => 1]);
            }
        } catch (\Throwable $th) {
            $data = array(
                "name" => 'HomeController',
                "module" => 'send_recipient_post',
                "description" => $th->getMessage(),
            );
            Log::create($data);
            return response()->json(["status" => 2]);
        }
    }

    public function user_dashboard(){
        $user = auth()->guard('auth')->user();
        $pur_payment = Payment::where('user_id',$user->id)->orderBy('id','desc')->get();
        $customized = "";
        $organization = "";
        if($user->role_id == 4){
            $frequency = json_decode($user->frequency);
            $customized = new SubCategory;
            if(!in_array('all', $frequency)){
                $customized = $customized->whereIn('id',$frequency);
            }
            $customized = $customized->paginate(10);
            $customized->setPath(route('user_dashboard', ['slug' => 'pur-frequency']));
        }
        if($user->parent_id != ""){
            $frequency = json_decode($user->parentUser->frequency);
            $organization = new SuperCategory;
            if(!in_array('all', $frequency)){
                $organization = $organization->whereIn('id',$frequency);
            }
            $organization = $organization->get();
        }
        $support = Supporter::where('user_id',$user->id)->orderByRaw("FIELD(msg_status, 2, 1)")->orderBy('created_at','desc')->get();
        return view('front.user_dashboard',compact('user','pur_payment','customized','support','organization'));
    }
    public function get_main_categories($id=null){
        try{
            $mainCategories = MainCategory::with('super_category')
                ->select('id', 'name', 'slug_name', 'super_cat_id', DB::raw("'main_category' as type"));
            if($id != null){
                $mainCategories = $mainCategories->where('super_cat_id',$id);
            }
            $mainCategories = $mainCategories->get();

            $subCategories = SubCategory::with('main_category.super_category')
                ->select('id', 'name', 'slug_name', 'cat_id', DB::raw("'sub_category' as type"));
            if($id != null){
                $subCategories = $subCategories->whereHas('main_category.super_category', function($q) use($id){
                    $q->where('id',$id);
                });
            }
            $subCategories = $subCategories->get();
            $category = $mainCategories->toBase()->merge($subCategories);

            return response()->json($category);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'HomeController',
                'module' => 'get_main_categories',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return response()->json([]);
        }
    }

    public function save_user_country(){
        $ip = request()->ip();
        $location = Location::get($ip);
        // $country = "USA";
        $country = $location->countryName ?? "India";
        session()->put('user_country', $country);
    }

    public function save_user_currency(Request $request){
        session()->put('user_currency', $request->value);
    }
    public function cms($slug_name)
    {
        $cms = Cms::where('slug_name', $slug_name)->first();
        if(!$cms){
            return redirect()->route('home')->with('error','Ooops! This page does not exist.');
        }
        if ($cms != null) {
            return view('front.cms.index', compact('cms'));
        } else {
            abort('503');
        }
    }


    public function dynamicSitemap(){
        $data = [
            'name' => 'HomeController',
            'module' => 'dynamicSitemap',
            'description' => date('Y-m-d H:i:s'),
        ];
        Log::create($data);
        $sitepath = public_path('/sitemap.xml');
        $super_categories = SuperCategory::select('id', 'slug_name', 'updated_at')->where('is_added_in_sitemap', 0)->get();
        if(count($super_categories) > 0) {
            $xmlContent = file_get_contents($sitepath);
            $xml = new \SimpleXMLElement($xmlContent);
            $ids = [];
            foreach ($super_categories as $super_category) {
                if (!empty($super_category->slug_name)) {
                    $url = config('services.main_url') . '/' . $super_category->slug_name;
                    $lastmod = date('Y-m-d\TH:i:sP', strtotime($super_category->updated_at));

                    // Check if URL exists in the sitemap
                    $existingUrl = null;
                    foreach ($xml->url as $urlElement) {
                        if ((string) $urlElement->loc === $url) {
                            $existingUrl = $urlElement;
                            break;
                        }
                    }
                    if ($existingUrl) {
                        // Update existing entry
                        $existingUrl->lastmod = $lastmod;
                        $existingUrl->priority = '0.80';
                    } else {
                        // Add new entry
                        $newUrl = $xml->addChild('url');
                        $newUrl->addChild('loc', $url);
                        $newUrl->addChild('lastmod', $lastmod);
                        $newUrl->addChild('priority', '0.80');
                    }
                    $ids[] = $super_category->id;
                }
            }
            // Save the updated sitemap
            $dom = new DOMDocument("1.0", "UTF-8");
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($xml->asXML());
            $result = $dom->save($sitepath);
            // $result = $xml->asXML(base_path('sitemap.xml'));
            if ($result !== false) {
                $super_categories = SuperCategory::whereIn('id', $ids)->update(['is_added_in_sitemap' => 1]);
                echo "Success";
            } else {
                echo "Error writing data to the file. please check file permission";
            }
        }

        $main_categories = MainCategory::select('id', 'slug_name', 'updated_at','super_cat_id')->with('super_category')->where('is_added_in_sitemap', 0)->get();
        if(count($main_categories) > 0) {
            $xmlContent = file_get_contents($sitepath);
            $xml = new \SimpleXMLElement($xmlContent);
            $ids = [];
            foreach ($main_categories as $main_category) {
                if (!empty($main_category->slug_name)) {
                    if(isset($main_category->super_category) && $main_category->super_category != []){
                        $url = config('services.main_url') .'/'.$main_category->super_category->slug_name. '/' . $main_category->slug_name;
                        $lastmod = date('Y-m-d\TH:i:sP', strtotime($main_category->updated_at));

                        // Check if URL exists in the sitemap
                        $existingUrl = null;
                        foreach ($xml->url as $urlElement) {
                            if ((string) $urlElement->loc === $url) {
                                $existingUrl = $urlElement;
                                break;
                            }
                        }
                        if ($existingUrl) {
                            // Update existing entry
                            $existingUrl->lastmod = $lastmod;
                            $existingUrl->priority = '0.80';
                        } else {
                            // Add new entry
                            $newUrl = $xml->addChild('url');
                            $newUrl->addChild('loc', $url);
                            $newUrl->addChild('lastmod', $lastmod);
                            $newUrl->addChild('priority', '0.80');
                        }
                        $ids[] = $main_category->id;
                    }
                }
            }
            // Save the updated sitemap
            $dom = new DOMDocument("1.0", "UTF-8");
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($xml->asXML());
            $result = $dom->save($sitepath);
            if ($result !== false) {
                $main_category = MainCategory::whereIn('id', $ids)->update(['is_added_in_sitemap' => 1]);
                echo "Success";
            } else {
                echo "Error writing data to the file. please check file permission";
            }
        }

        $sub_categories = SubCategory::select('id', 'slug_name', 'updated_at','cat_id')->with('main_category')->where('is_added_in_sitemap', 0)->get();
        if(count($sub_categories) > 0) {
            $xmlContent = file_get_contents($sitepath);
            $xml = new \SimpleXMLElement($xmlContent);
            $ids = [];
            foreach ($sub_categories as $sub_category) {
                if (!empty($sub_category->slug_name)) {
                    if(isset($sub_category->main_category) && $sub_category->main_category != []){
                        $url = config('services.main_url') .'/'.$sub_category->main_category->super_category->slug_name.'/'.$sub_category->main_category->slug_name. '/' . $sub_category->slug_name;
                        $lastmod = date('Y-m-d\TH:i:sP', strtotime($sub_category->updated_at));
                        // Check if URL exists in the sitemap
                        $existingUrl = null;
                        foreach ($xml->url as $urlElement) {
                            if ((string) $urlElement->loc === $url) {
                                $existingUrl = $urlElement;
                                break;
                            }
                        }
                        if ($existingUrl) {
                            // Update existing entry
                            $existingUrl->lastmod = $lastmod;
                            $existingUrl->priority = '0.80';
                        } else {
                            // Add new entry
                            $newUrl = $xml->addChild('url');
                            $newUrl->addChild('loc', $url);
                            $newUrl->addChild('lastmod', $lastmod);
                            $newUrl->addChild('priority', '0.80');
                        }
                        $ids[] = $sub_category->id;
                    }
                }
            }
            // Save the updated sitemap
            $dom = new DOMDocument("1.0", "UTF-8");
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($xml->asXML());
            $result = $dom->save($sitepath);
            if ($result !== false) {
                $sub_categories = SubCategory::whereIn('id', $ids)->update(['is_added_in_sitemap' => 1]);
                echo "Success";
            } else {
                echo "Error writing data to the file. please check file permission";
            }
        }

        // echo "No records";
        die;
    }
}
