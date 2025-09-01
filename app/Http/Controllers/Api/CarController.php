<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Middlewares\PermissionMiddleware;

class CarController extends Controller
{
    // public function __construct()
    // {
    //     // التأكد من استخدام الـ guard 'api' في middleware
    //     $this->middleware(['auth:sanctum', 'permission:manage-cars,api']);

    // }


public function store(Request $request)
{
    $validated = $request->validate([
        'name.en' => 'required|string|max:255',
        'name.ar' => 'required|string|max:255',
        'model' => 'required|string|max:255',
        'color' => 'required|string|max:255',
        'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // ≤5MB
        'extra_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        'engine_type' => 'required|string',
        'slug' => 'required|string|unique:cars,slug|max:255',
        'plate_type' => 'required|string',
        'rental_price' => 'required|numeric|min:0',
        'availability_start' => 'required|date',
        'availability_end' => 'required|date|after:availability_start',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'long_term_guarantee' => 'boolean',
        'pickup_delivery' => 'boolean',
        'is_active' => 'boolean',
        'insurance_type.en' => 'required|string',
        'insurance_type.ar' => 'required|string',
        'usage_nature.en' => 'required|string',
        'usage_nature.ar' => 'required|string',
        'description.en' => 'nullable|string',
        'description.ar' => 'nullable|string',
        'meta_title.en' => 'nullable|string|max:255',
        'meta_title.ar' => 'nullable|string|max:255',
        'meta_description.en' => 'nullable|string',
        'meta_description.ar' => 'nullable|string',
        'image_alt.en' => 'nullable|string|max:255',
        'image_alt.ar' => 'nullable|string|max:255',
        'car_type_id' => 'required|exists:car_types,id',
        'category_ids' => 'array',
        'category_ids.*' => 'exists:categories,id',
        'feature_value_ids' => 'array',
        'feature_value_ids.*' => 'exists:feature_values,id',
    ]);

    try {
        // رفع main_image
        if ($request->hasFile('main_image')) {
            $mainImagePath = $request->file('main_image')->store('cars/main', 'public');
            $validated['main_image'] = '/storage/' . $mainImagePath;
        }

        // رفع extra_images
        $extraImages = [];
        if ($request->hasFile('extra_images')) {
            foreach ($request->file('extra_images') as $image) {
                $path = $image->store('cars/extra', 'public');
                $extraImages[] = '/storage/' . $path;
            }
        }
        $validated['extra_images'] = $extraImages;

        // إنشاء السيارة
        $car = Car::create([
            'user_id' => Auth::id(),
            'car_type_id' => $validated['car_type_id'],
            'model' => $validated['model'],
            'color' => $validated['color'],
            'main_image' => $validated['main_image'],
            'extra_images' => $validated['extra_images'] ?? [],
            'engine_type' => $validated['engine_type'],
            'slug' => $validated['slug'],
            'plate_type' => $validated['plate_type'],
            'rental_price' => $validated['rental_price'],
            'availability_start' => $validated['availability_start'],
            'availability_end' => $validated['availability_end'],
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'long_term_guarantee' => $validated['long_term_guarantee'] ?? false,
            'pickup_delivery' => $validated['pickup_delivery'] ?? false,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // إضافة الترجمات
        foreach (['en', 'ar'] as $locale) {
            $car->translateOrNew($locale)->name = $validated['name'][$locale];
            $car->translateOrNew($locale)->insurance_type = $validated['insurance_type'][$locale];
            $car->translateOrNew($locale)->usage_nature = $validated['usage_nature'][$locale];
            $car->translateOrNew($locale)->description = $validated['description'][$locale] ?? null;
            $car->translateOrNew($locale)->meta_title = $validated['meta_title'][$locale] ?? null;
            $car->translateOrNew($locale)->meta_description = $validated['meta_description'][$locale] ?? null;
            $car->translateOrNew($locale)->image_alt = $validated['image_alt'][$locale] ?? null;
        }
        $car->save();

        // ربط التصنيفات
        if (!empty($validated['category_ids'])) {
            $car->categories()->sync($validated['category_ids']);
        }

        // ربط خصائص السيارة
        if (!empty($validated['feature_value_ids'])) {
            $car->featureValues()->sync($validated['feature_value_ids']);
        }

        // إعادة السيارة مع العلاقات
        return response()->json([
            'data' => $car->load(
                'translations',
                'categories.translations',
                'featureValues.translations',
                'featureValues.feature.translations',
                'options.translations'
            )
        ], 201);

    } catch (\Exception $e) {
        \Log::error('Car creation failed', [
            'user_id' => Auth::id(),
            'input' => $request->all(),
            'error' => $e->getMessage(),
        ]);

        return response()->json([
            'message' => 'Failed to create car',
            'error' => $e->getMessage(),
        ], 500);
    }
}


// app/Http/Controllers/Api/CarController.php
// public function store(Request $request)
// {
//     $validated = $request->validate([
//         'name.en' => 'required|string|max:255',
//         'name.ar' => 'required|string|max:255',
//         'model' => 'required|string|max:255',
//         'color' => 'required|string|max:255',
//         'main_image' => 'required|string',
//         'extra_images' => 'array',
//         'engine_type' => 'required|string',
//         'slug' => 'required|string|unique:cars,slug|max:255',
//         'plate_type' => 'required|string',
//         'rental_price' => 'required|numeric|min:0',
//         'availability_start' => 'required|date',
//         'availability_end' => 'required|date|after:availability_start',
//         'latitude' => 'nullable|numeric',
//         'longitude' => 'nullable|numeric',
//         'long_term_guarantee' => 'boolean',
//         'pickup_delivery' => 'boolean',
//         'is_active' => 'boolean',
//         'insurance_type.en' => 'required|string',
//         'insurance_type.ar' => 'required|string',
//         'usage_nature.en' => 'required|string',
//         'usage_nature.ar' => 'required|string',
//         'description.en' => 'nullable|string',
//         'description.ar' => 'nullable|string',
//         'meta_title.en' => 'nullable|string|max:255',
//         'meta_title.ar' => 'nullable|string|max:255',
//         'meta_description.en' => 'nullable|string',
//         'meta_description.ar' => 'nullable|string',
//         'image_alt.en' => 'nullable|string|max:255',
//         'image_alt.ar' => 'nullable|string|max:255',
//         'car_type_id' => 'required|exists:car_types,id',
//         'category_ids' => 'array',
//         'category_ids.*' => 'exists:categories,id',
//         'feature_value_ids' => 'array',
//         'feature_value_ids.*' => 'exists:feature_values,id',
//         'option_ids' => 'array', // إضافة validation للـ options
//         'option_ids.*' => 'exists:extra_options,id',
//     ]);

//     try {
//         // إنشاء السيارة
//         $car = Car::create([
//             'user_id' => Auth::id(),
//             'car_type_id' => $validated['car_type_id'],
//             'model' => $validated['model'],
//             'color' => $validated['color'],
//             'main_image' => $validated['main_image'],
//             'extra_images' => $validated['extra_images'] ?? [],
//             'engine_type' => $validated['engine_type'],
//             'slug' => $validated['slug'],
//             'plate_type' => $validated['plate_type'],
//             'rental_price' => $validated['rental_price'],
//             'availability_start' => $validated['availability_start'],
//             'availability_end' => $validated['availability_end'],
//             'latitude' => $validated['latitude'],
//             'longitude' => $validated['longitude'],
//             'long_term_guarantee' => $validated['long_term_guarantee'] ?? false,
//             'pickup_delivery' => $validated['pickup_delivery'] ?? false,
//             'is_active' => $validated['is_active'] ?? true,
//         ]);

//         // إضافة الترجمات باستخدام translateOrNew
//         foreach (['en', 'ar'] as $locale) {
//             if (isset($validated['name'][$locale])) {
//                 $car->translateOrNew($locale)->name = $validated['name'][$locale];
//                 $car->translateOrNew($locale)->insurance_type = $validated['insurance_type'][$locale];
//                 $car->translateOrNew($locale)->usage_nature = $validated['usage_nature'][$locale];
//                 $car->translateOrNew($locale)->description = $validated['description'][$locale] ?? null;
//                 $car->translateOrNew($locale)->meta_title = $validated['meta_title'][$locale] ?? null;
//                 $car->translateOrNew($locale)->meta_description = $validated['meta_description'][$locale] ?? null;
//                 $car->translateOrNew($locale)->image_alt = $validated['image_alt'][$locale] ?? null;
//             }
//         }
//         $car->save();

//         // ربط التصنيفات
//         if (!empty($validated['category_ids'])) {
//             $car->categories()->sync($validated['category_ids']);
//         }

//         // ربط خصائص السيارة
//         if (!empty($validated['feature_value_ids'])) {
//             $car->featureValues()->sync($validated['feature_value_ids']);
//         }

//         // ربط الخيارات الإضافية
//         if (!empty($validated['option_ids'])) {
//             $car->options()->sync($validated['option_ids']);
//         }

//         // إعادة السيارة مع العلاقات
//         return response()->json([
//             'data' => $car->load(
//                 'translations',
//                 'categories.translations',
//                 'featureValues.translations',
//                 'featureValues.feature.translations',
//                 'options.translations'
//             )
//         ], 201);

//     } catch (\Exception $e) {
//         \Log::error('Car creation failed', [
//             'user_id' => Auth::id(),
//             'input' => $request->all(),
//             'error' => $e->getMessage(),
//         ]);

//         return response()->json([
//             'message' => 'Failed to create car',
//             'error' => $e->getMessage(),
//         ], 500);
//     }
// }



    // public function update(Request $request, Car $car)
    // {
    //     $this->middleware(PermissionMiddleware::class . ':edit-car');
    //     $validated = $request->validate([
    //         'name.en' => 'string|max:255',
    //         'name.ar' => 'string|max:255',
    //         'model' => 'string|max:255',
    //         'color' => 'string|max:255',
    //         'main_image' => 'string',
    //         'extra_images' => 'array',
    //         'engine_type' => 'string',
    //         'slug' => 'string|unique:cars,slug,' . $car->id . '|max:255',
    //         'plate_type' => 'string',
    //         'rental_price' => 'numeric|min:0',
    //         'availability_start' => 'date',
    //         'availability_end' => 'date|after:availability_start',
    //         'latitude' => 'nullable|numeric',
    //         'longitude' => 'nullable|numeric',
    //         'long_term_guarantee' => 'boolean',
    //         'pickup_delivery' => 'boolean',
    //         'is_active' => 'boolean',
    //         'insurance_type.en' => 'string',
    //         'insurance_type.ar' => 'string',
    //         'usage_nature.en' => 'string',
    //         'usage_nature.ar' => 'string',
    //         'description.en' => 'nullable|string',
    //         'description.ar' => 'nullable|string',
    //         'category_ids' => 'array',
    //         'category_ids.*' => 'exists:categories,id',
    //         'feature_value_ids' => 'array',
    //         'feature_value_ids.*' => 'exists:feature_values,id',
    //     ]);

    //     $car->update([
    //         'model' => $validated['model'] ?? $car->model,
    //         'color' => $validated['color'] ?? $car->color,
    //         'main_image' => $validated['main_image'] ?? $car->main_image,
    //         'extra_images' => $validated['extra_images'] ?? $car->extra_images,
    //         'engine_type' => $validated['engine_type'] ?? $car->engine_type,
    //         'slug' => $validated['slug'] ?? $car->slug,
    //         'plate_type' => $validated['plate_type'] ?? $car->plate_type,
    //         'rental_price' => $validated['rental_price'] ?? $car->rental_price,
    //         'availability_start' => $validated['availability_start'] ?? $car->availability_start,
    //         'availability_end' => $validated['availability_end'] ?? $car->availability_end,
    //         'latitude' => $validated['latitude'] ?? $car->latitude,
    //         'longitude' => $validated['longitude'] ?? $car->longitude,
    //         'long_term_guarantee' => $validated['long_term_guarantee'] ?? $car->long_term_guarantee,
    //         'pickup_delivery' => $validated['pickup_delivery'] ?? $car->pickup_delivery,
    //         'is_active' => $validated['is_active'] ?? $car->is_active,
    //     ]);

    //     if (isset($validated['name']['en'])) {
    //         $car->translations()->updateOrCreate(
    //             ['locale' => 'en'],
    //             ['name' => $validated['name']['en'], 'insurance_type' => $validated['insurance_type']['en'] ?? $car->insurance_type, 'usage_nature' => $validated['usage_nature']['en'] ?? $car->usage_nature, 'description' => $validated['description']['en'] ?? null]
    //         );
    //     }
    //     if (isset($validated['name']['ar'])) {
    //         $car->translations()->updateOrCreate(
    //             ['locale' => 'ar'],
    //             ['name' => $validated['name']['ar'], 'insurance_type' => $validated['insurance_type']['ar'] ?? $car->insurance_type, 'usage_nature' => $validated['usage_nature']['ar'] ?? $car->usage_nature, 'description' => $validated['description']['ar'] ?? null]
    //         );
    //     }

    //     if (isset($validated['category_ids'])) {
    //         $car->categories()->sync($validated['category_ids']);
    //     }

    //     if (isset($validated['feature_value_ids'])) {
    //         $car->featureValues()->sync($validated['feature_value_ids']);
    //     }

    //     return response()->json(['data' => $car->load('translations', 'categories.translations', 'featureValues.translations', 'featureValues.feature.translations', 'options.translations')], 200);
    // }

//     public function myCars(Request $request)
// {
//     $user = Auth::user();

//     // جلب كل السيارات للمستخدم مع العلاقات المطلوبة
//     $cars = Car::where('user_id', $user->id)
//         ->with([
//             'translations',
//             'categories.translations',
//             'featureValues.translations',
//             'featureValues.feature.translations',
//             'options.translations'
//         ])
//         ->get();

//     return response()->json([
//         'data' => $cars
//     ], 200);
// }
public function myCars(Request $request)
{
    $user = Auth::user();

    // جلب السيارات التي أضافها هذا المستخدم فقط
    $cars = Car::where('user_id', $user->id)
        ->with([
            'translations',
            'categories.translations',
            'featureValues.translations',
            'featureValues.feature.translations',
            'options.translations'
        ])
        ->get();

    return response()->json([
        'data' => $cars
    ], 200);
}



public function destroy(Car $car)
{
    try {
        // تأكد أن اللي بيحذف هو صاحب العربية أو عنده صلاحية
        if ($car->user_id !== Auth::id() && !Auth::user()->can('manage-cars')) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $car->delete();

        return response()->json([
            'message' => 'Car deleted successfully'
        ], 200);

    } catch (\Exception $e) {
        \Log::error('Car deletion failed', [
            'user_id' => Auth::id(),
            'car_id' => $car->id,
            'error' => $e->getMessage(),
        ]);

        return response()->json([
            'message' => 'Failed to delete car',
            'error' => $e->getMessage(),
        ], 500);
    }
}


public function update(Request $request, Car $car)
{
    $validated = $request->validate([
        'name.en' => 'string|max:255',
        'name.ar' => 'string|max:255',
        'model' => 'string|max:255',
        'color' => 'string|max:255',
        'main_image' => 'string',
        'extra_images' => 'array',
        'engine_type' => 'string',
        'slug' => 'string|unique:cars,slug,' . $car->id . '|max:255',
        'plate_type' => 'string',
        'rental_price' => 'numeric|min:0',
        'availability_start' => 'date',
        'availability_end' => 'date|after:availability_start',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'long_term_guarantee' => 'boolean',
        'pickup_delivery' => 'boolean',
        'is_active' => 'boolean',
        'insurance_type.en' => 'string',
        'insurance_type.ar' => 'string',
        'usage_nature.en' => 'string',
        'usage_nature.ar' => 'string',
        'description.en' => 'nullable|string',
        'description.ar' => 'nullable|string',
        'category_ids' => 'array',
        'category_ids.*' => 'exists:categories,id',
        'feature_value_ids' => 'array',
        'feature_value_ids.*' => 'exists:feature_values,id',
    ]);

    // تحديث بيانات السيارة الأساسية
    $car->update($validated);

    // تحديث الترجمات
    foreach (['en', 'ar'] as $locale) {
        if (isset($validated['name'][$locale])) {
            $car->translateOrNew($locale)->name = $validated['name'][$locale];
            $car->translateOrNew($locale)->insurance_type = $validated['insurance_type'][$locale] ?? $car->translateOrNew($locale)->insurance_type;
            $car->translateOrNew($locale)->usage_nature = $validated['usage_nature'][$locale] ?? $car->translateOrNew($locale)->usage_nature;
            $car->translateOrNew($locale)->description = $validated['description'][$locale] ?? $car->translateOrNew($locale)->description;
        }
    }
    $car->save();

    // تحديث التصنيفات
    if (isset($validated['category_ids'])) {
        $car->categories()->sync($validated['category_ids']);
    }

    // تحديث الخصائص
    if (isset($validated['feature_value_ids'])) {
        $car->featureValues()->sync($validated['feature_value_ids']);
    }

    return response()->json([
        'data' => $car->load(
            'translations',
            'categories.translations',
            'featureValues.translations',
            'featureValues.feature.translations',
            'options.translations'
        )
    ], 200);
}


}
