<?php

namespace App\Services;
class TwoCheckoutHosted
{
    public static function generateBuyLink($orderId, $amount, $currency = "USD")
    {
        $merchantCode = env('TWOCHECKOUT_MERCHANT_CODE');
        $secretWord   = env('TWOCHECKOUT_SECRET_KEY');
        $returnUrl    = route('payment.2checkout.return');

        $params = [
            'merchant'       => $merchantCode,
            'currency'       => $currency,
            'return-url'     => $returnUrl,
            'test'           => '1',
            'li_0_type'      => 'product',
            'li_0_name'      => "Car Booking #$orderId",
            'li_0_price'     => $amount,
            'li_0_quantity'  => 1,
            'merchantOrderId'=> $orderId,
        ];

        // ✅ التوقيع مش مطلوب في الـ Hosted Buy Link البسيط
        return "https://secure.2checkout.com/checkout/purchase?" . http_build_query($params);
    }
}
