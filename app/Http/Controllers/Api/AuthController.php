<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\OtpMail;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new user and send OTP.
     */
    
    public function register(Request $request)
    {
        // التحقق الأساسي للجميع
        $commonRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'role' => 'required|in:customer,private_renter,rental_office',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        // قواعد التحقق الخاصة بكل دور
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

        // تطبيق قواعد التحقق بناءً على الدور
        $rulesToApply = $commonRules;
        if (isset($roleSpecificRules[$request->role])) {
            $rulesToApply = array_merge($commonRules, $roleSpecificRules[$request->role]);
        }
        $request->validate($rulesToApply);
        
        // معالجة رفع الصور
        $drivingLicensePath = null;
        if ($request->hasFile('driving_license_image')) {
            $drivingLicensePath = $request->file('driving_license_image')->store('licenses', 'public');
        }

        $carLicensePath = null;
        if ($request->hasFile('car_license_image')) {
            $carLicensePath = $request->file('car_license_image')->store('licenses', 'public');
        }
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

        // تعيين الدور باستخدام Spatie Permissions
        $user->assignRole($request->role);

        // إرسال OTP لتأكيد البريد الإلكتروني
        $this->sendOtp($user);

        return response()->json([
            'message' => 'User registered successfully. Please check your email for OTP to verify your account.',
            'user' => $user->only(['id', 'name', 'email', 'role', 'slug']),
        ], 201);
    }

   

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // التحقق من بيانات تسجيل الدخول يدويًا
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials.'
            ], 401);
        }

        // التحقق من البريد الإلكتروني
        if (!$user->hasVerifiedEmail()) {
            $this->sendOtp($user);
            return response()->json([
                'message' => 'Your email is not verified. An OTP has been sent to your email. Please verify your account.',
                'user' => $user->only(['id', 'name', 'email']),
                'requires_otp_verification' => true,
            ], 403);
        }

        // إنشاء رمز Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Verify OTP for email verification.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'otp_code' => 'required|string|min:6|max:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $otp = Otp::where('user_id', $user->id)
                    ->where('otp_code', $request->otp_code)
                    ->where('expires_at', '>', Carbon::now())
                    ->first();

        if (!$otp) {
            return response()->json(['message' => 'Invalid or expired OTP.'], 400);
        }

        // Mark email as verified
        $user->markEmailAsVerified();
        $user->save();

        // Delete used OTP
        $otp->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Email verified successfully.',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Resend OTP.
     */
    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 400);
        }

        // Delete any existing active OTPs for the user
        $user->otps()->where('expires_at', '>', Carbon::now())->delete();

        $this->sendOtp($user);

        return response()->json(['message' => 'New OTP has been sent to your email.'], 200);
    }

    /**
     * Forgot password - send OTP for password reset.
     */
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'We cannot find a user with that email address.'], 404);
        }

        // Delete any existing active OTPs for the user
        $user->otps()->where('expires_at', '>', Carbon::now())->delete();

        $this->sendOtp($user); // Re-use sendOtp for password reset

        return response()->json(['message' => 'An OTP for password reset has been sent to your email.'], 200);
    }

    /**
     * Reset password using OTP.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|string|min:6|max:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $otp = Otp::where('user_id', $user->id)
                    ->where('otp_code', $request->otp_code)
                    ->where('expires_at', '>', Carbon::now())
                    ->first();

        if (!$otp) {
            return response()->json(['message' => 'Invalid or expired OTP.'], 400);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Delete used OTP
        $otp->delete();

        return response()->json(['message' => 'Password has been reset successfully.'], 200);
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }

    /**
     * Get authenticated user details.
     */
    // public function user(Request $request)
    // {
    //     return response()->json($request->user());
    // }
    
    public function user(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        return response()->json($request->user());
        
    }



    /**
     * Helper function to send OTP.
     */
    protected function sendOtp(User $user)
    {
        // Generate a 6-digit OTP
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = Carbon::now()->addMinutes(5); // OTP valid for 5 minutes

        // Invalidate any previous OTPs for this user
        $user->otps()->delete();

        // Store the new OTP
        $user->otps()->create([
            'otp_code' => $otpCode,
            'expires_at' => $expiresAt,
        ]);

        // Send OTP via email
        Mail::to($user->email)->send(new OtpMail($otpCode, $user->name));
    }
}
