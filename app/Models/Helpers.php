<?php

use Intervention\Image\Facades\Image;
use App\Models\OrderManagement;
use App\Models\DeliveredOrder;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Banner;
use App\Models\SuperCategory;
use App\Models\SubCategory;
use App\Models\Payment;
use App\Models\MainCategory;
use App\Models\Cms;
use App\Models\Setting;
use App\Models\Messages;
use App\Models\Rating;
use Carbon\Carbon;

function errorResponse($errorMessage, $data = null,$status = null)
{
    return response()->json([
        'success' => 0,
        'data' => $data,
        'message' => $errorMessage,
        'status' => $status ?? 400,
    ]);
}

function successResponse($message, $data = null)
{

    if (! empty($data)) {

        return response()->json([
            'success' => 1,
            'data' => $data,
            'message' => $message,
            'status' => 200,
        ]);
    } else {
        return response()->json([
            'success' => 1,
            'message' => $message,
            'status' => 200,
        ]);
    }
}function getUserCount($role_id)
{
    $User = User::where('role_id', $role_id)->count();
    return $User ?? 0;
}

function getBanner()
{
    $banner = Banner::get();
    return $banner;
}

function getCategories()
{
    $category = SuperCategory::get();
    return $category;
}

function getMainCategories($id)
{
    $main_category = MainCategory::where('super_cat_id', $id)->get();
    return $main_category;
}
function getCms()
{
    $Cms = Cms::where('id', '!=', 1)->get();
    return $Cms;
}
function generateRecNo()
{
    do {
        $receipt_no = 'receipt_'. rand(0000, 9999) . time();
    } while (Payment::where('receipt_no', $receipt_no)->exists());
    return $receipt_no;
}

function getSetting($key)
{
    $setting = Setting::where('key', $key)->first();

    return isset($setting) && ! empty($setting) ? $setting->value : '';
}

// is_plan_active (main category id, sub category id, user id)
function is_plan_active($main_cat_id, $sub_cat_id = null, $user_id = null)
{
    $user_id = $user_id ?? auth()->guard('auth')->user()->id;
    $inclusive_plan = Payment::where('user_id', $user_id)->where('active_until', '>', date('Y-m-d H:i:s'))->where('type', 1)->exists();
    if($inclusive_plan == true){
        return true;
    } else{
        $plan = Payment::where('type', 2)->whereHas('package', function($que) use($sub_cat_id, $main_cat_id){
            if($sub_cat_id != null){
                $que->where('sub_cat_id', $sub_cat_id)->orWhere('cat_id', $main_cat_id);
            } else {
                $que->where('cat_id', $main_cat_id);
            }
        })->where('user_id', $user_id)->where('active_until', '>', date('Y-m-d H:i:s'))->first();

        if($plan){
            return true;
        } else{
            return false;
        }
    }
}
function global_plan_active($user_id = null)
{
    $user_id = $user_id ?? auth()->guard('auth')->user()->id;
    $inclusive_plan = Payment::where('user_id', $user_id)->where('active_until', '>', date('Y-m-d H:i:s'))->where('type', 1)->exists();
    if($inclusive_plan == true){
        return true;
    }
    else{
            return false;
    }
}


function active_until_active($id){
    $plan = Payment::where('user_id',auth()->guard('auth')->user()->id)->where('id',$id)->where('active_until','>',date('y-m-d H:i:s'))->first();
    if($plan){
        return true;
    }else{
        return false;
    }
}

if (!function_exists('has_active_plans_for_subcategory')) {
    /**
     * Check if a subcategory has any active plans.
     *
     * @param  \App\Models\SubCategory $subCategory
     * @return bool
     */
    function has_active_plans_for_subcategory($subCategory)
    {
        return $subCategory->packages->contains(function ($package) {
            return $package->status != 0;
        });
    }
}

if (!function_exists('has_active_plans_for_main_category')) {
    /**
     * Check if the main category has any active plans.
     *
     * @param  \App\Models\Category $category
     * @return bool
     */
    function has_active_plans_for_main_category($category)
    {
        return $category->packages->contains(function ($package) {
            return $package->status != 0;
        });
    }
}

if(! function_exists('convert_webp')){
    function convert_webp($file){
        $imagename = rand(0000,9999).time().'.webp';
        $image = Image::make($file);
        $data['imagename'] = $imagename;
        $data['image'] = $image;
        return $data;
    }
}

if(! function_exists('getSlug')){
    function getSlug($id){
        $sub_cat = SubCategory::find($id);
        return [$sub_cat->main_category->super_category->slug_name, $sub_cat->main_category->slug_name, $sub_cat->slug_name];
    }
}
if(! function_exists('getMainCatSlug')){
    function getMainCatSlug($id){
        $main_cat = MainCategory::find($id);
        return [$main_cat->super_category->slug_name, $main_cat->slug_name];
    }
}
if(! function_exists('customise_active_plan')){
    function customise_active_plan(){
        if(auth()->guard('auth')->user()->role_id == 4 && date('Y-m-d') >= auth()->guard('auth')->user()->start_date && date('Y-m-d') <= auth()->guard('auth')->user()->end_date){
            return true;
        } else{
            return false;
        }
    }
}

if(! function_exists('customise_user_plan')){
    function customise_user_plan($id, $user_id = null){
        $role_id = $user_id ? auth()->guard('api')->user()->role_id : auth()->guard('auth')->user()->role_id;
        $start_date = $user_id ? auth()->guard('api')->user()->start_date : auth()->guard('auth')->user()->start_date;
        $end_date = $user_id ? auth()->guard('api')->user()->end_date : auth()->guard('auth')->user()->end_date;
        $user_id = $user_id ?? auth()->guard('auth')->user()->id;
        if($role_id == 4 && date('Y-m-d') >= $start_date && date('Y-m-d') <= $end_date){
            $sub_cat = User::where('id', $user_id)->where(function($q) use($id){
                $q->whereJsonContains('frequency',(string)$id)->orWhereJsonContains('frequency','all');
            })->exists();
            if($sub_cat){
                return true;
            }
        }
        return false;
    }
}

if(! function_exists('customise_all_assign')){
    function customise_all_assign($user_id = null){
        $role_id = $user_id ? auth()->guard('api')->user()->role_id : auth()->guard('auth')->user()->role_id;
        $start_date = $user_id ? auth()->guard('api')->user()->start_date : auth()->guard('auth')->user()->start_date;
        $end_date = $user_id ? auth()->guard('api')->user()->end_date : auth()->guard('auth')->user()->end_date;
        if($role_id == 4 && date('Y-m-d') >= $start_date && date('Y-m-d') <= $end_date){
            $user_id = $user_id ?? auth()->guard('auth')->user()->id;
            $sub_cat = User::where('id', $user_id)->whereJsonContains('frequency','all')->exists();
            if($sub_cat){
                return true;
            }
        }
        return false;
    }
}

if(! function_exists('organization_user_plan')){
    function organization_user_plan($id, $user_id = null){
        $role_id = $user_id ? auth()->guard('api')->user()->role_id : auth()->guard('auth')->user()->role_id;
        $parent_id = $user_id ? auth()->guard('api')->user()->parent_id : auth()->guard('auth')->user()->parent_id;
        $user_id = $user_id ?? auth()->guard('auth')->user()->id;
        if($role_id == 3 && $parent_id != null){
            $sub_cat = User::where('id', $user_id)->whereHas('parentUser', function($que) use($id){
                $que->where(function($q) use($id){
                    $q->whereJsonContains('frequency',(string)$id)->orWhereJsonContains('frequency','all');
                })->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'));
            })->exists();
            if($sub_cat){
                return true;
            }
        }
        return false;
    }
}

if(! function_exists('organization_all_assign')){
    function organization_all_assign($user_id = null){
        $role_id = $user_id ? auth()->guard('api')->user()->role_id : auth()->guard('auth')->user()->role_id;
        $parent_id = $user_id ? auth()->guard('api')->user()->parent_id : auth()->guard('auth')->user()->parent_id;
        $user_id = $user_id ?? auth()->guard('auth')->user()->id;
        if($role_id == 3 && $parent_id != null){
            $sub_cat = User::where('id', $user_id)->whereHas('parentUser', function($que) use($id){
                $que->whereJsonContains('frequency','all')->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'));
            })->exists();
            if($sub_cat){
                return true;
            }
        }
        return false;
    }
}

if(! function_exists('convert_time')){
    function convert_time($id){
       $messages = Messages::find($id);
       $user_detail = $messages->getUser;
       $timezone  = $user_detail->timezone ?? 'UTC';
       if($messages != null){
           $convert_time = Carbon::parse($messages->created_at)->setTimezone($timezone)->format('d M Y \a\t h:i A');
           return $convert_time;
       }
    }
}

// check if user puchased sub category once
if(! function_exists('is_user_purchased')){
    function is_user_purchased($sub_cat_id, $main_cat_id, $user_id = null){
        $user_id = $user_id ?? auth()->guard('auth')->user()->id;
        $inclusive_plan = Payment::where('user_id', $user_id)->where('active_until', '>', date('Y-m-d H:i:s'))->where('type', 1)->exists();
        if($inclusive_plan == true){
            return true;
        } else{
            $plan = Payment::where('type', 2)->whereHas('package', function($que) use($sub_cat_id, $main_cat_id){
                if($sub_cat_id != null){
                    $que->where('sub_cat_id', $sub_cat_id)->orWhere('cat_id', $main_cat_id);
                } else {
                    $que->where('cat_id', $main_cat_id);
                }
            })->where('user_id', $user_id)->first();

            if($plan){
                return true;
            } else{
                return false;
            }
        }
    }
}

// get user review
if(! function_exists('get_user_review')){
    function get_user_review($sub_cat_id){
        $user_id = $user_id ?? auth()->guard('auth')->user()->id;
        $review = Rating::select('rating','description')->where('user_id', $user_id)->where('sub_cat_id', $sub_cat_id)->first();
        if($review){
            return $review;
        }
        return null;
    }
}
// convert date tz to users tz
if(! function_exists('convert_timezone')){
    function convert_timezone($date, $usr_timezone = null){
        $timezone = $usr_timezone ?? (auth()->guard('auth')->user()->timezone ?? 'UTC');
        $convert_time = Carbon::parse($date)->setTimezone($timezone)->format('d-m-Y h:i A');
        return $convert_time;
    }
}
// get users count in organization
if(! function_exists('org_user_count')){
    function org_user_count(){
        $users = User::where('parent_id', auth()->guard('web')->user()->id)->count();
        return $users;
    }
}
if(! function_exists('org_active_plan')){
    function org_active_plan(){
        if(auth()->guard('auth')->user()->parent_id != "" && date('Y-m-d') >= auth()->guard('auth')->user()->parentUser?->start_date && date('Y-m-d') <= auth()->guard('auth')->user()->parentUser?->end_date){
            return true;
        } else{
            return false;
        }
    }
}
if(! function_exists('subCategoryList')){
    function subCategoryList(){
        $sub_category = SubCategory::where('status', 1)->get();
        return $sub_category;
    }
}
