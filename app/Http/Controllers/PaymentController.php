<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\TwoCheckoutHosted;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createCheckout(Request $request)
    {
        $orderId = "ORDER-" . uniqid();
        $amount  = $request->amount ?? 50;

        $link = TwoCheckoutHosted::generateBuyLink($orderId, $amount, "USD");

        return response()->json([
            'checkout_url' => $link,
            'order_id' => $orderId
        ]);
    }

    public function returnUrl(Request $request)
    {
        // ده اللي العميل بيرجع له بعد الدفع
        return response()->json([
            'message' => 'Payment completed, waiting for webhook confirmation',
            'data' => $request->all()
        ]);
    }

    public function webhook(Request $request)
    {
        // هنا هيجيلك إشعار INS من 2Checkout
        $data = $request->all();

        // تحقق من الـ signature باستخدام الـ Secret word
        $receivedHash = $data['HASH'] ?? null;

        unset($data['HASH']);
        $checkString = implode('', $data); 

        $calcHash = strtoupper(md5(strlen($checkString) . $checkString . env('TWOCHECKOUT_SECRET_KEY')));

        if ($receivedHash === $calcHash) {
            // ✅ الدفع صحيح
            // ابحث عن الـ order_id وزود رصيد المحفظة
            // Wallet::credit($user_id, $amount);
        } else {
            // ❌ التوقيع غير صحيح
            return response('Invalid signature', 400);
        }

        return response('OK', 200);
    }
}
