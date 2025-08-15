<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Plans;
use App\Models\Log;
use Session;

class PaymentController extends Controller
{
    public function fetch_payment_details(Request $request){
        try{
            if($request->type == 1){
                $package = Plans::find($request->package_id);
            } else if($request->type == 2){
                $package = Package::find($request->package_id);
            }
            if(!$package){
                Session::flash('error', 'Oops! Plans are not available.');
                return response()->json(['status' => 0]);
            }
            $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

            $receipt_no = generateRecNo();
            $amount = (session()->get('user_country') == "India" ? $package->cost : (session()->get('user_currency') == "euro" ? $package->cost_euro : $package->cost_usd));
            $currency = (session()->get('user_country') == "India" ? "INR" : (session()->get('user_currency') == "euro" ? 'EUR' : "USD"));

            // Create an order on Razorpay
            $order = $api->order->create([
                'amount' => $amount*100,
                'currency' => $currency,
                'receipt' => $receipt_no,
                'payment_capture' => 1
            ]);

            return response()->json([
                'status' => 1,
                'key' => env('RAZORPAY_KEY_ID'),
                'amount' => $order['amount'],
                'currency' => $order['currency'],
                'name' => 'Healing Hospital',
                'description' => 'headache segment',
                'order_id' => $order['id'],
                'receipt_no' => $receipt_no,
            ]);
        } catch (\Throwable $th) {
            $data = [
                'name' => 'PaymentController',
                'module' => 'fetch_payment_details',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            return response()->json([]);
        }
    }

    public function payment_callback(Request $request){
        try {
            $payment_response = $request->payment_response;

            if($request->type == 1){
                $package = Plans::find($request->package_id);
            } else if($request->type == 2){
                $package = Package::find($request->package_id);
            }

            $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

            // Verify the signature
            $attributes = [
                'razorpay_order_id' => $payment_response['razorpay_order_id'],
                'razorpay_payment_id' => $payment_response['razorpay_payment_id'],
                'razorpay_signature' => $payment_response['razorpay_signature'],
            ];
            $api->utility->verifyPaymentSignature($attributes);

            // $amount =  $request->currency == 'INR' ? $package->cost : $package->cost_usd;
            $amount =  $request->amount/100;
            $payment = [
                'user_id' => auth()->guard('auth')->user()->id,
                'package_id' => $package->id,
                'type' => $request->type,
                'receipt_no' => $request->receipt_no,
                'amount' => $amount,
                'payment_status' => 1,
                'order_id' => $payment_response['razorpay_order_id'],
                'payment_id' => $payment_response['razorpay_payment_id'],
                'payment_date' => date('Y-m-d'),
                'active_until' => date('Y-m-d H:i:s', strtotime('+'.$package->days.' days')),
                'currency' => $request->currency,
            ];
            Payment::create($payment);

            // Payment verified successfully
            return response()->json(['status' => 'success', 'message' => 'Thank you! Your payment has been processed. Enjoy your wellness journey!']);
        } catch (\Exception $e) {
            $data = [
                'name' => 'PaymentController',
                'module' => 'payment_callback Payment verification failed',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            // Payment verification failed
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function payment_failure(Request $request){
        try{
            return response()->json(['status' => 'error', 'message' => 'Payment could not be completed. Please try again.']);
        } catch (\Exception $e) {
            $data = [
                'name' => 'PaymentController',
                'module' => 'payment_failure Payment failed',
                'description' => $th->getMessage(),
            ];
            Log::create($data);
            // Payment verification failed
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }
}
