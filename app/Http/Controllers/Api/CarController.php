<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Spatie\Permission\Middlewares\PermissionMiddleware;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', PermissionMiddleware::class . ':manage-cars'])->except(['index', 'show']);
    }

    public function index()
    {
        // $cars = Car::withTranslations()->get();
        $cars = Car::with('translations')->get();

        return response()->json(['data' => $cars], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_type_id' => 'required|exists:car_types,id',
            'model' => 'required|string',
            'color' => 'required|string',
            'main_image' => 'required|string',
            'extra_images' => 'nullable|array',
            'engine_type' => 'required|string',
            'slug' => 'required|string|unique:cars,slug',
            'plate_type' => 'required|string|in:white,green',
            'rental_price' => 'required|numeric|min:0',
            'availability_start' => 'required|date',
            'availability_end' => 'required|date|after:availability_start',
            'long_term_guarantee' => 'boolean',
            'pickup_delivery' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'name.en' => 'required|string',
            'name.ar' => 'required|string',
            'insurance_type.en' => 'required|string',
            'insurance_type.ar' => 'required|string',
            'usage_nature.en' => 'required|string',
            'usage_nature.ar' => 'required|string',
            'description.en' => 'required|string',
            'description.ar' => 'required|string',
            'meta_title.en' => 'nullable|string',
            'meta_title.ar' => 'nullable|string',
            'meta_description.en' => 'nullable|string',
            'meta_description.ar' => 'nullable|string',
            'image_alt.en' => 'nullable|string',
            'image_alt.ar' => 'nullable|string',
        ]);

        $car = Car::create([
            'user_id' => auth()->id(),
            'car_type_id' => $validated['car_type_id'],
            'model' => $validated['model'],
            'color' => $validated['color'],
            'main_image' => $validated['main_image'],
            'extra_images' => $validated['extra_images'],
            'engine_type' => $validated['engine_type'],
            'slug' => $validated['slug'],
            'plate_type' => $validated['plate_type'],
            'rental_price' => $validated['rental_price'],
            'availability_start' => $validated['availability_start'],
            'availability_end' => $validated['availability_end'],
            'long_term_guarantee' => $validated['long_term_guarantee'] ?? false,
            'pickup_delivery' => $validated['pickup_delivery'] ?? false,
            'is_active' => $validated['is_active'] ?? true,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        $car->translations()->createMany([
            [
                'locale' => 'en',
                'name' => $validated['name']['en'],
                'insurance_type' => $validated['insurance_type']['en'],
                'usage_nature' => $validated['usage_nature']['en'],
                'description' => $validated['description']['en'],
                'meta_title' => $validated['meta_title']['en'],
                'meta_description' => $validated['meta_description']['en'],
                'image_alt' => $validated['image_alt']['en'],
            ],
            [
                'locale' => 'ar',
                'name' => $validated['name']['ar'],
                'insurance_type' => $validated['insurance_type']['ar'],
                'usage_nature' => $validated['usage_nature']['ar'],
                'description' => $validated['description']['ar'],
                'meta_title' => $validated['meta_title']['ar'],
                'meta_description' => $validated['meta_description']['ar'],
                'image_alt' => $validated['image_alt']['ar'],
            ],
        ]);

        // return response()->json(['data' => $car->loadTranslations()], 201);
        return response()->json(['data' => $car->load('translations')], 201);
    }

    public function show(Car $car)
    {
        // return response()->json(['data' => $car->loadTranslations()], 200);
        return response()->json(['data' => $car->load('translations')], 200);
    }

    public function update(Request $request, Car $car)
    {
        $this->authorize('update', $car);

        $validated = $request->validate([
            'car_type_id' => 'exists:car_types,id',
            'model' => 'string',
            'color' => 'string',
            'main_image' => 'string',
            'extra_images' => 'nullable|array',
            'engine_type' => 'string',
            'slug' => 'string|unique:cars,slug,' . $car->id,
            'plate_type' => 'string|in:white,green',
            'rental_price' => 'numeric|min:0',
            'availability_start' => 'date',
            'availability_end' => 'date|after:availability_start',
            'long_term_guarantee' => 'boolean',
            'pickup_delivery' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'name.en' => 'string',
            'name.ar' => 'string',
            'insurance_type.en' => 'string',
            'insurance_type.ar' => 'string',
            'usage_nature.en' => 'string',
            'usage_nature.ar' => 'string',
            'description.en' => 'string',
            'description.ar' => 'string',
            'meta_title.en' => 'nullable|string',
            'meta_title.ar' => 'nullable|string',
            'meta_description.en' => 'nullable|string',
            'meta_description.ar' => 'nullable|string',
            'image_alt.en' => 'nullable|string',
            'image_alt.ar' => 'nullable|string',
        ]);

        $car->update($validated);
        foreach (['en', 'ar'] as $locale) {
            if (isset($validated['name'][$locale])) {
                $car->translations()->updateOrCreate(
                    ['locale' => $locale],
                    [
                        'name' => $validated['name'][$locale],
                        'insurance_type' => $validated['insurance_type'][$locale] ?? $car->translate($locale)->insurance_type,
                        'usage_nature' => $validated['usage_nature'][$locale] ?? $car->translate($locale)->usage_nature,
                        'description' => $validated['description'][$locale] ?? $car->translate($locale)->description,
                        'meta_title' => $validated['meta_title'][$locale] ?? $car->translate($locale)->meta_title,
                        'meta_description' => $validated['meta_description'][$locale] ?? $car->translate($locale)->meta_description,
                        'image_alt' => $validated['image_alt'][$locale] ?? $car->translate($locale)->image_alt,
                    ]
                );
            }
        }

        // return response()->json(['data' => $car->loadTranslations()], 200);
        return response()->json(['data' => $car->load('translations')], 200);
    }

    public function destroy(Car $car)
    {
        $this->authorize('delete', $car);
        $car->delete();
        return response()->json(['message' => 'Car deleted successfully'], 200);
    }
}
