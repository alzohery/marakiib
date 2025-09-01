<?php

namespace App\Services;

class TwoCheckoutBuyLink
{
    protected $merchantCode;
    protected $buyLinkSecret;

    public function __construct()
    {
        $this->merchantCode   = config('twocheckout.merchant_code');
        $this->buyLinkSecret  = config('twocheckout.buy_link_secret');
    }

    public function generateLink(array $params)
    {
        $params['merchant'] = $this->merchantCode;

        // build signature string
        $signatureString = '';
        foreach ($params as $val) {
            $signatureString .= strlen($val) . $val;
        }

        // sign it
        $signature = hash_hmac('sha256', $signatureString, $this->buyLinkSecret);

        $params['signature'] = $signature;

        $query = http_build_query($params);

        return "https://secure.2checkout.com/checkout/buy?$query";
    }
}
