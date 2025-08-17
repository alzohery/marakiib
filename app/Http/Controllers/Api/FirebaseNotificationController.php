<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseNotificationController extends Controller
{
    public function sendTestNotification(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $fcmToken = $request->token;

        $firebase = (new Factory)
            ->withServiceAccount(config('firebase.credentials.file'));

        $messaging = $firebase->createMessaging();

        $message = CloudMessage::withTarget('token', $fcmToken)
            ->withNotification(Notification::create(
                '🚘 إشعار تجريبي',
                'تم إرسال هذا الإشعار من Laravel إلى FCM.'
            ));

        $messaging->send($message);

        return response()->json(['status' => '✅ تم الإرسال']);
    }
}
