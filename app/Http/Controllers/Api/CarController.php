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
        'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:9120', // ≤5MB
        'extra_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:9120',
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
    \Log::info('Update request received for car ID: ' . $car->id, [
        'input'   => $request->all(),
        'json'    => $request->json()->all(),
        'headers' => $request->headers->all(),
        'method'  => $request->method(),
        'url'     => $request->fullUrl()
    ]);

    // 1) Normalize عشان لو form-data جاي بـ name[en] يحوله => name => [en => value]
    $normalizedInput = $this->normalizeFormData($request->all());
    $request->merge($normalizedInput);

    // 2) Validation rules
    $validated = $request->validate([
        'name.en'              => 'sometimes|required|string|max:255',
        'name.ar'              => 'sometimes|required|string|max:255',
        'model'                => 'sometimes|required|string|max:255',
        'color'                => 'sometimes|required|string|max:255',
        'main_image'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        'extra_images.*'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        'engine_type'          => 'sometimes|required|string',
        'slug'                 => 'sometimes|required|string|unique:cars,slug,' . $car->id . '|max:255',
        'plate_type'           => 'sometimes|required|string',
        'rental_price'         => 'sometimes|required|numeric|min:0',
        'availability_start'   => 'sometimes|required|date',
        'availability_end'     => 'sometimes|required|date|after:availability_start',
        'latitude'             => 'nullable|numeric',
        'longitude'            => 'nullable|numeric',
        'long_term_guarantee'  => 'sometimes|boolean',
        'pickup_delivery'      => 'sometimes|boolean',
        'is_active'            => 'sometimes|boolean',
        'insurance_type.en'    => 'sometimes|required|string',
        'insurance_type.ar'    => 'sometimes|required|string',
        'usage_nature.en'      => 'sometimes|required|string',
        'usage_nature.ar'      => 'sometimes|required|string',
        'description.en'       => 'nullable|string',
        'description.ar'       => 'nullable|string',
        'meta_title.en'        => 'nullable|string|max:255',
        'meta_title.ar'        => 'nullable|string|max:255',
        'meta_description.en'  => 'nullable|string',
        'meta_description.ar'  => 'nullable|string',
        'image_alt.en'         => 'nullable|string|max:255',
        'image_alt.ar'         => 'nullable|string|max:255',
        'car_type_id'          => 'sometimes|required|exists:car_types,id',
        'category_ids'         => 'sometimes|array',
        'category_ids.*'       => 'exists:categories,id',
        'feature_value_ids'    => 'sometimes|array',
        'feature_value_ids.*'  => 'exists:feature_values,id',
        'option_ids'           => 'sometimes|array',
        'option_ids.*'         => 'exists:extra_options,id',
    ]);

    \Log::info('Validated data for car ID: ' . $car->id, $validated);

    try {
        // 3) Check user
        if (Auth::id() !== $car->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        \DB::beginTransaction();

        // 4) Handle main_image
        if ($request->hasFile('main_image')) {
            if ($car->main_image && Storage::disk('public')->exists(str_replace('/storage/', '', $car->main_image))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $car->main_image));
            }
            $mainImagePath = $request->file('main_image')->store('cars/main', 'public');
            $validated['main_image'] = '/storage/' . $mainImagePath;
        }

        // 5) Handle extra_images
        if ($request->hasFile('extra_images')) {
            if ($car->extra_images) {
                foreach ($car->extra_images as $oldImage) {
                    if (Storage::disk('public')->exists(str_replace('/storage/', '', $oldImage))) {
                        Storage::disk('public')->delete(str_replace('/storage/', '', $oldImage));
                    }
                }
            }
            $extraImages = [];
            foreach ($request->file('extra_images') as $image) {
                $path = $image->store('cars/extra', 'public');
                $extraImages[] = '/storage/' . $path;
            }
            $validated['extra_images'] = $extraImages;
        }

        // 6) Update normal fields
        $fields = [
            'car_type_id', 'model', 'color', 'main_image', 'extra_images',
            'engine_type', 'slug', 'plate_type', 'rental_price',
            'availability_start', 'availability_end', 'latitude', 'longitude',
            'long_term_guarantee', 'pickup_delivery', 'is_active'
        ];
        $updateData = array_intersect_key($validated, array_flip($fields));

        if (!empty($updateData)) {
            $car->fill($updateData)->save();
        }

        // 7) Update translations
        foreach (['en', 'ar'] as $locale) {
            $translationData = [];
            foreach (['name','insurance_type','usage_nature','description','meta_title','meta_description','image_alt'] as $field) {
                if (isset($validated[$field][$locale])) {
                    $translationData[$field] = $validated[$field][$locale];
                }
            }
            if (!empty($translationData)) {
                $car->translations()->updateOrCreate(
                    ['locale' => $locale],
                    $translationData
                );
            }
        }

        // 8) Update relations
        if (!empty($validated['category_ids'])) {
            $car->categories()->sync($validated['category_ids']);
        }
        if (!empty($validated['feature_value_ids'])) {
            $car->featureValues()->sync($validated['feature_value_ids']);
        }
        if (!empty($validated['option_ids'])) {
            $car->options()->sync($validated['option_ids']);
        }

        $car->touch();
        \DB::commit();

        return response()->json([
            'message' => 'Car updated successfully',
            'data'    => $car->load(
                'translations',
                'categories.translations',
                'featureValues.translations',
                'featureValues.feature.translations',
                'options.translations'
            )
        ], 200);

    } catch (\Exception $e) {
        \DB::rollBack();
        \Log::error('Update failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        return response()->json([
            'message' => 'Failed to update car',
            'error'   => $e->getMessage(),
        ], 500);
    }
}

/**
 * Helper: Normalize form-data keys like name[en] => name => [en => value]
 */
private function normalizeFormData(array $input): array
{
    $normalized = [];
    foreach ($input as $key => $value) {
        if (preg_match('/^(.+)\[(.+)\]$/', $key, $matches)) {
            $normalized[$matches[1]][$matches[2]] = $value;
        } else {
            $normalized[$key] = $value;
        }
    }
    return $normalized;
}




}
