<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;
use Astrotomic\Translatable\Locales;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the provider authentication page.
     */
    public function redirectToProvider($provider, Request $request)
    {
        // التحقق من الدور وإرساله مع التوجيه
        $request->validate([
            'role' => 'required|in:customer,private_renter,rental_office',
            'locale' => 'required|string|in:ar,en', // إضافة التحقق من اللغة
        ]);
        
        // حفظ الدور واللغة في الجلسة مؤقتًا قبل التوجيه
        Session::put('social_register_role', $request->role);
        Session::put('social_register_locale', $request->locale);

        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Handle the provider callback and authenticate the user.
     */
    public function handleProviderCallback($provider)
    {
        try {
            // الحصول على بيانات المستخدم من مزود الخدمة
            $socialUser = Socialite::driver($provider)->stateless()->user();

            // استرجاع الدور واللغة من الجلسة
            $role = Session::get('social_register_role', 'customer');
            $locale = Session::get('social_register_locale', 'en'); // القيمة الافتراضية للغة هي الإنجليزية

            // البحث عن مستخدم موجود باستخدام البريد الإلكتروني
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                // إذا كان المستخدم موجودًا، تحقق مما إذا كان قد سجل بالفعل عبر مزود آخر
                if ($user->provider !== null && $user->provider !== $provider) {
                    return response()->json(['error' => 'Email already registered with a different social provider.'], 400);
                }

                // إذا كان المستخدم موجودًا ولكنه لم يسجل عبر Socialite من قبل، قم بربط حسابه
                if ($user->provider === null) {
                    $user->update([
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                    ]);
                }
            } else {
                // إذا كان المستخدم غير موجود، قم بإنشاء حساب جديد
                $user = User::create([
                    'name' => $socialUser->getName() ?? 'No Name',
                    'email' => $socialUser->getEmail(),
                    'password' => null,
                    'email_verified_at' => now(),
                    'avatar' => $socialUser->getAvatar(),
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'role' => $role,
                    'status' => 'pending',
                    'slug' => Str::slug(($socialUser->getName() ?? 'user') . '-' . Str::random(6)),
                    'image' => null,
                    'is_active' => true,
                    'sort_order' => 0,
                ]);
                
                // تعيين الدور باستخدام Spatie Permissions
                $user->assignRole($role);
            }

            // إزالة البيانات من الجلسة
            Session::forget('social_register_role');
            Session::forget('social_register_locale');

            // إنشاء توكن للمستخدم
            $token = $user->createToken('social-token')->plainTextToken;

            // التحقق مما إذا كان المستخدم يحتاج إلى إكمال بيانات ملفه الشخصي
            $requiresProfileCompletion = in_array($user->role, ['private_renter', 'rental_office']);

            return response()->json([
                'message' => 'Social login successful.',
                'user' => $user->only(['id', 'email', 'role']), // لا نرجع الاسم مباشرة لأنه أصبح مترجماً
                'token' => $token,
                'requires_profile_completion' => $requiresProfileCompletion,
            ]);

        } catch (\Exception $e) {
            // في حالة حدوث خطأ، يتم إزالة البيانات من الجلسة لتجنب أي مشاكل
            Session::forget('social_register_role');
            Session::forget('social_register_locale');
            return response()->json([
                'error' => 'Login failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
