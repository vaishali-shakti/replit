<?php

namespace App\Services;

use Razorpay\Api\Api;

class RazorpayService
{
    protected $api;

    public function __construct()
    {
        $this->api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
    }

    public function createOrder($amount, $currency = 'INR', $receipt = 'order_rcptid_11')
    {
        return $this->api->order->create([
            'amount' => $amount * 100, // Amount in paise (multiply by 100)
            'currency' => $currency,
            'receipt' => $receipt,
        ]);
    }
}
