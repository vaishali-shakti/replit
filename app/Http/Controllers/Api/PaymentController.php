<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Log;
use App\Models\Plans;
use App\Models\SubCategory;
use App\Models\SuperCategory;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function generate_recpt_no(Request $request){
        try{
            $receipt_no = generateRecNo();
            return successResponse('Receipt No retrieved successfully',  $receipt_no);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'PaymentController',
                'module' => 'generate_recpt_no',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }
    public function store_payment(Request $request){
        try{
            $rules = [
                'package_id' => 'required',
                'amount' => 'required',
                'order_id' => 'required',
                'payment_id' => 'required',
                'receipt_no' => 'required',
                'currency' => 'required',
                'type' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorMessage = $validator->errors()->first();

                return errorResponse($errorMessage, $validator->messages());
            }
            if($request->type == 1){
                $package = Plans::find($request->package_id);
            } else{
                $package = Package::find($request->package_id);
            }
            $payment = [
                'user_id' => auth()->guard('api')->user()->id,
                'package_id' => $request->package_id,
                'receipt_no' => $request->receipt_no,
                'amount' => $request->amount,
                'payment_status' => 1,
                'order_id' => $request->order_id,
                'payment_id' => $request->payment_id,
                'payment_date' => date('Y-m-d'),
                'active_until' => date('Y-m-d H:i:s', strtotime('+'.$package->days.' days')),
                'currency' => $request->currency,
                'type' => $request->type,
            ];
            Payment::create($payment);
            return successResponse('Thank you! Your payment has been processed. Enjoy your wellness journey!');
        } catch (\Throwable $th) {
            $data = [
                'name' => 'PaymentController',
                'module' => 'store_payment',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }

    public function user_subscriptions(){
        try{
            $pur_payment = Payment::where('user_id', auth()->guard('api')->user()->id)
                ->orderBy('id', 'desc')
                ->get()
                ->map(function ($payment) {
                    if ($payment->type == 1) {
                        $payment->plan_details = $payment->plan;
                        $payment->plan_details->title = "All-Inclusive Deal";
                    } elseif ($payment->type == 2) {
                        $payment->plan_details = $payment->package;
                        if($payment->plan_details->cat_id != null){
                            $payment->plan_details->main_category;
                        } else if($payment->plan_details->sub_cat_id != null){
                            $payment->plan_details->sub_category;
                        }
                    }
                    // Remove the original attributes to avoid duplicates
                    unset($payment->plan, $payment->package);
                    return $payment;
                });
                $customized = [];
                if(auth()->guard('api')->user()->role_id == 4){
                    $frequency = json_decode(auth()->guard('api')->user()->frequency);
                    $customized = new SubCategory;
                    if(!in_array('all', $frequency)){
                        $customized = $customized->whereIn('id',$frequency);
                    }
                    $customized = $customized->get()->map(function ($custom) {
                        $custom->start_date = auth()->guard('api')->user()->start_date;
                        $custom->end_date = auth()->guard('api')->user()->end_date;
                        return $custom;
                    });
                }
                $organization = [];
                if(auth()->guard('api')->user()->parent_id != ""){
                    $organization = new SuperCategory;
                    $frequency = json_decode(auth()->guard('api')->user()->parentUser->frequency);
                    if(!in_array('all', $frequency)){
                        $organization = $organization->whereIn('id',$frequency);
                    }
                    $organization = $organization->get()->map(function ($custom) {
                        $custom->start_date = auth()->guard('api')->user()->start_date;
                        $custom->end_date = auth()->guard('api')->user()->end_date;
                        return $custom;
                    });
                }
            return successResponse('Subscriptions retrieved successfully',  ['customized' => $customized, 'pur_payment' => $pur_payment, 'organization' => $organization]);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'PaymentController',
                'module' => 'store_payment',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return errorResponse($th->getMessage());
        }
    }
}
