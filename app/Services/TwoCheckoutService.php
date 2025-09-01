<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TwoCheckoutService
{
    protected $merchantCode;
    protected $privateKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->merchantCode = config('twocheckout.merchant_code');
        $this->privateKey   = config('twocheckout.private_key');
        $this->baseUrl      = 'https://api.2checkout.com/rest/6.0';
    }

    public function createPaymentLink($orderData)
    {
        $url = $this->baseUrl . '/orders';

        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => 'Basic ' . base64_encode($this->merchantCode . ':' . $this->privateKey),
        ])->post($url, $orderData);

        return $response->json();
    }
}
