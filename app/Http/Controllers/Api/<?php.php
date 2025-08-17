<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $commonRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'nullable|string|min:8|confirmed',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'role' => 'required|in:customer,private_renter,rental_office',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $roleSpecificRules = [
            'customer' => [
                'driving_license_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            'private_renter' => [
                'car_license_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'car_license_expiry_date' => 'required|date|after:today',
            ],
            'rental_office' => [
                'car_license_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'car_license_expiry_date' => 'required|date|after:today',
                'commercial_registration_number' => 'required|string|max:255',
            ],
        ];

        $rulesToApply = array_merge($commonRules, $roleSpecificRules[$request->role] ?? []);
        $request->validate($rulesToApply);

        $drivingLicensePath = $request->hasFile('driving_license_image')
            ? $request->file('driving_license_image')->store('licenses', 'public')
            : null;

        $carLicensePath = $request->hasFile('car_license_image')
            ? $request->file('car_license_image')->store('licenses', 'public')
            : null;

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('images', 'public')
            : null;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : null,
            'role' => $request->role,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'driving_license_image' => $drivingLicensePath,
            'car_license_image' => $carLicensePath,
            'car_license_expiry_date' => $request->car_license_expiry_date,
            'commercial_registration_number' => $request->commercial_registration_number,
            'status' => 'active',
            'slug' => Str::slug($request->name . '-' . Str::random(6)),
            'image' => $imagePath,
            'is_active' => true,
            'sort_order' => 0,
        ]);

        $user->assignRole($request->role);
        $this->sendOtp($user);

        return response()->json([
            'message' => 'User registered successfully. Please check your email for OTP.',
            'user' => $user->only(['id', 'name', 'email', 'role', 'slug']),
        ], 201);
    }

    // باقي الدوال (مثل login, verifyOtp, إلخ) تبقى زي ما هي في الكود الأصلي
}