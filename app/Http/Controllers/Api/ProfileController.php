<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Complete the user's profile with role-specific data.
     */
    public function completeProfile(Request $request)
    {
        // الحصول على المستخدم الحالي
        $user = Auth::user();

        // تحديد قواعد التحقق بناءً على دور المستخدم
        $rules = [];
        $messages = [];

        switch ($user->role) {
            case 'private_renter':
                $rules = [
                    'car_license_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'car_license_expiry_date' => 'required|date|after:today',
                    'phone_number' => 'required|string|max:20',
                    'address' => 'required|string|max:255',
                    'latitude' => 'required|numeric',
                    'longitude' => 'required|numeric',
                ];
                $messages = [
                    'car_license_image.required' => 'صورة رخصة السيارة مطلوبة.',
                    'car_license_expiry_date.required' => 'تاريخ انتهاء رخصة السيارة مطلوب.',
                    'car_license_expiry_date.after' => 'يجب أن يكون تاريخ انتهاء رخصة السيارة في المستقبل.',
                ];
                break;
            case 'rental_office':
                $rules = [
                    'car_license_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'car_license_expiry_date' => 'required|date|after:today',
                    'commercial_registration_number' => 'required|string|max:255',
                    'phone_number' => 'required|string|max:20',
                    'address' => 'required|string|max:255',
                    'latitude' => 'required|numeric',
                    'longitude' => 'required|numeric',
                ];
                $messages = [
                    'car_license_image.required' => 'صورة رخصة السيارة مطلوبة.',
                    'car_license_expiry_date.required' => 'تاريخ انتهاء رخصة السيارة مطلوب.',
                    'car_license_expiry_date.after' => 'يجب أن يكون تاريخ انتهاء رخصة السيارة في المستقبل.',
                    'commercial_registration_number.required' => 'رقم السجل التجاري مطلوب.',
                ];
                break;
            default:
                // لا توجد بيانات إضافية مطلوبة لأدوار أخرى مثل 'customer'
                return response()->json(['message' => 'No additional data required for this role.'], 200);
        }

        // تطبيق قواعد التحقق
        $request->validate($rules, $messages);
        
        // معالجة رفع الصور
        $carLicensePath = null;
        if ($request->hasFile('car_license_image')) {
            $carLicensePath = $request->file('car_license_image')->store('licenses', 'public');
        }

        // تحديث بيانات المستخدم
        $user->car_license_image = $carLicensePath;
        $user->car_license_expiry_date = $request->car_license_expiry_date;
        $user->commercial_registration_number = $request->commercial_registration_number;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->status = 'active'; // تفعيل الحساب بعد إكمال البيانات
        $user->save();

        return response()->json([
            'message' => 'Profile completed successfully.',
            'user' => $user->only(['id', 'name', 'email', 'role', 'status']),
        ], 200);
    }
}