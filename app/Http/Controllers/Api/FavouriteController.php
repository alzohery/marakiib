<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Car;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FavouriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('permission:manage-favourites', ['only' => ['index', 'store', 'destroy']]);
        $this->middleware('role:customer', ['only' => ['store', 'destroy']]); // فقط الـ customer يقدر يضيف أو يحذف
    }

    public function index(Request $request)
    {
        $locale = $request->header('Accept-Language', 'en');

        $favourites = Favorite::where('user_id', Auth::id())
            ->where('is_active', true)
            ->with([
                'car.translations' => fn($q) => $q->where('locale', $locale),
                'car.categories.translations' => fn($q) => $q->where('locale', $locale),
                'car.featureValues.translations' => fn($q) => $q->where('locale', $locale),
                'car.featureValues.feature.translations' => fn($q) => $q->where('locale', $locale),
            ])
            ->orderBy('sort_order', 'asc')
            ->get();

        return response()->json([
            'data' => $favourites->filter(fn($favourite) => $favourite->car) // فقط اللي السيارة موجودة
                ->map(function ($favourite) use ($locale) {
                    $car = $favourite->car;

                    return [
                        'id' => $favourite->id,
                        'car_id' => $car->id,
                        'car_name' => $car->translations->first()?->name ?? $car->model,
                        'car_model' => $car->model,
                        'car_color' => $car->color,
                        'car_image' => $car->main_image,
                        'rental_price' => $car->rental_price,
                        'image' => $favourite->image,
                        'is_active' => $favourite->is_active,
                        'sort_order' => $favourite->sort_order,
                        'created_at' => $favourite->created_at,
                        'car' => [
                            'id' => $car->id,
                            'name' => $car->translations->first()?->name ?? $car->model,
                            'model' => $car->model,
                            'color' => $car->color,
                            'main_image' => $car->main_image,
                            'rental_price' => $car->rental_price,
                            'categories' => $car->categories->map(fn($category) => [
                                'id' => $category->id,
                                'name' => $category->translations->where('locale', $locale)->first()?->name ?? $category->slug,
                                'slug' => $category->slug,
                                'image' => $category->image,
                            ])->toArray(),
                            'features' => $car->featureValues->map(fn($featureValue) => [
                                'feature_id' => $featureValue->feature_id,
                                'feature_name' => $featureValue->feature?->translations->where('locale', $locale)->first()?->name ?? $featureValue->feature->slug,
                                'value_id' => $featureValue->id,
                                'value' => $featureValue->translations->where('locale', $locale)->first()?->value ?? '',
                            ])->toArray(),
                        ],
                    ];
                })
        ]);
    }


    // public function store(Request $request, $carId)
    // {
    //     $validated = $request->validate([
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // دعم رفع صورة اختياري
    //         'sort_order' => 'nullable|integer|min:0',
    //     ]);

    //     try {
    //         $car = Car::where('id', $carId)->where('is_active', true)->firstOrFail();

    //         // التحقق إن الـ customer عنده حجز مكتمل للسيارة
    //         $hasCompletedBooking = Booking::where('customer_id', Auth::id())
    //             ->where('car_id', $carId)
    //             ->where('status', 'completed')
    //             ->exists();

    //         if (!$hasCompletedBooking) {
    //             return response()->json(['message' => 'You can only add a car to favourites after completing a booking.'], 403);
    //         }

    //         // التحقق إن السيارة مش موجودة في المفضلة بالفعل
    //         $existingFavourite = Favorite::where('user_id', Auth::id())
    //             ->where('car_id', $carId)
    //             ->where('is_active', true)
    //             ->exists();

    //         if ($existingFavourite) {
    //             return response()->json(['message' => 'Car is already in your favourites.'], 422);
    //         }

    //         return DB::transaction(function () use ($validated, $carId) {
    //             $imagePath = null;
    //             if ($request->hasFile('image')) {
    //                 $imagePath = $request->file('image')->store('favourites', 'public');
    //             }

    //             $favourite = Favorite::create([
    //                 'user_id' => Auth::id(),
    //                 'car_id' => $carId,
    //                 'image' => $imagePath,
    //                 'sort_order' => $validated['sort_order'] ?? 0,
    //                 'is_active' => true,
    //             ]);

    //             \Log::info('Favourite added', [
    //                 'favourite_id' => $favourite->id,
    //                 'user_id' => Auth::id(),
    //                 'car_id' => $carId,
    //                 'sort_order' => $favourite->sort_order,
    //             ]);

    //             return response()->json([
    //                 'message' => 'Car added to favourites successfully',
    //                 'data' => $favourite->load(
    //                     'car.translations',
    //                     'car.categories.translations',
    //                     'car.featureValues.translations',
    //                     'car.featureValues.feature.translations'
    //                 )
    //             ], 201);
    //         });
    //     } catch (\Exception $e) {
    //         \Log::error('Favourite creation failed', [
    //             'user_id' => Auth::id(),
    //             'car_id' => $carId,
    //             'error' => $e->getMessage(),
    //         ]);
    //         return response()->json([
    //             'message' => 'Failed to add car to favourites',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function store(Request $request, $carId)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            // جلب السيارة والتأكد إنها موجودة وفعالة
            $car = Car::where('id', $carId)->where('is_active', true)->first();
            if (!$car) {
                return response()->json([
                    'message' => 'Failed to add car to favourites',
                    'error' => 'Car not found or inactive'
                ], 404);
            }

            // التحقق من عدم وجود السيارة بالفعل في المفضلة
            $existingFavourite = Favorite::where('user_id', Auth::id())
                ->where('car_id', $carId)
                ->where('is_active', true)
                ->exists();

            if ($existingFavourite) {
                return response()->json(['message' => 'Car is already in your favourites.'], 422);
            }

            return DB::transaction(function () use ($validated, $request, $carId) {
                $imagePath = null;
                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('favourites', 'public');
                }

                $favourite = Favorite::create([
                    'user_id' => Auth::id(),
                    'car_id' => $carId,
                    'image' => $imagePath,
                    'sort_order' => $validated['sort_order'] ?? 0,
                    'is_active' => true,
                ]);

                // تحميل البيانات مع الترجمات والعلاقات
                $favourite->load([
                    'car' => fn($q) => $q->with([
                        'translations' => fn($q) => $q->where('locale', $request->header('Accept-Language', 'en')),
                        'categories.translations' => fn($q) => $q->where('locale', $request->header('Accept-Language', 'en')),
                        'featureValues.translations' => fn($q) => $q->where('locale', $request->header('Accept-Language', 'en')),
                        'featureValues.feature.translations' => fn($q) => $q->where('locale', $request->header('Accept-Language', 'en')),
                    ])
                ]);

                \Log::info('Favourite added', [
                    'favourite_id' => $favourite->id,
                    'user_id' => Auth::id(),
                    'car_id' => $carId,
                    'sort_order' => $favourite->sort_order,
                ]);

                return response()->json([
                    'message' => 'Car added to favourites successfully',
                    'data' => $favourite
                ], 201);
            });

        } catch (\Exception $e) {
            \Log::error('Favourite creation failed', [
                'user_id' => Auth::id(),
                'car_id' => $carId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Failed to add car to favourites',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroy($carId)
    {
        try {
            $favourite = Favorite::where('user_id', Auth::id())
                ->where('car_id', $carId)
                ->where('is_active', true)
                ->firstOrFail();

            return DB::transaction(function () use ($favourite) {
                $favourite->update(['is_active' => false]);

                \Log::info('Favourite removed', [
                    'favourite_id' => $favourite->id,
                    'user_id' => Auth::id(),
                    'car_id' => $favourite->car_id,
                ]);

                return response()->json(['message' => 'Car removed from favourites successfully']);
            });
        } catch (\Exception $e) {
            \Log::error('Favourite removal failed', [
                'user_id' => Auth::id(),
                'car_id' => $carId,
                'error' => $e->getMessage(),
            ]);
            return response()->json([
                'message' => 'Failed to remove car from favourites',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
?>