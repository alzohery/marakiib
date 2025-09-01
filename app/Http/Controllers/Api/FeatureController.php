<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\FeatureValue;
use Illuminate\Http\Request;
use Spatie\Permission\Middlewares\PermissionMiddleware;

class FeatureController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'permission:manage-features']);

    }

    public function index()
    {
        $lang = request()->header('Accept-Language', 'en');
        $features = Feature::with([
            'translations' => function ($query) use ($lang) {
                $query->where('locale', $lang);
            },
            'values.translations' => function ($query) use ($lang) {
                $query->where('locale', $lang);
            }
        ])->get();

        $features->transform(function ($feature) use ($lang) {
            $translation = $feature->translations->first();
            return [
                'id' => $feature->id,
                'name' => $translation->name ?? $feature->name,
                'slug' => $feature->slug,
                'type' => $feature->type,
                'image' => $feature->image,
                'is_required' => $feature->is_required,
                'is_active' => $feature->is_active,
                'sort_order' => $feature->sort_order,
                'description' => $translation->description ?? null,
                'values' => $feature->values->map(function ($value) use ($lang) {
                    $valueTranslation = $value->translations->where('locale', $lang)->first();
                    return [
                        'id' => $value->id,
                        'value' => $valueTranslation->value ?? $value->value,
                        'slug' => $value->slug,
                        'image' => $value->image,
                        'is_active' => $value->is_active,
                        'sort_order' => $value->sort_order,
                    ];
                }),
            ];
        });

        return response()->json(['data' => $features], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name.en' => 'required|string|max:255',
            'name.ar' => 'required|string|max:255',
            // 'slug' => 'required|string|unique:features,slug|max:255',
            // 'slug' => 'nullable|string|unique:features,slug|max:255',
            

            'type' => 'required|string|in:select,checkbox,number,text',
            'image' => 'nullable|string',
            'is_required' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'description.en' => 'nullable|string',
            'description.ar' => 'nullable|string',
            'values' => 'array',
            'values.*.value.en' => 'required_with:values|string|max:255',
            'values.*.value.ar' => 'required_with:values|string|max:255',
            // 'values.*.slug' => 'required_with:values|string|unique:feature_values,slug|max:255',
            // 'values.*.slug' => 'nullable|string|unique:feature_values,slug|max:255',
            'values.*.image' => 'nullable|string',
        ]);

        // $feature = Feature::create([
        //     'slug' => $validated['slug'],
        //     'type' => $validated['type'],
        //     'image' => $validated['image'],
        //     'is_required' => $validated['is_required'] ?? true,
        //     'is_active' => $validated['is_active'] ?? true,
        //     'sort_order' => $validated['sort_order'] ?? 0,
        // ]);
        $feature = Feature::create([
        'type' => $validated['type'],
        'image' => $validated['image'],
        'is_required' => $validated['is_required'] ?? true,
        'is_active' => $validated['is_active'] ?? true,
        'sort_order' => $validated['sort_order'] ?? 0,
    ]);



        $feature->translations()->createMany([
            ['locale' => 'en', 'name' => $validated['name']['en'], 'description' => $validated['description']['en'] ?? null],
            ['locale' => 'ar', 'name' => $validated['name']['ar'], 'description' => $validated['description']['ar'] ?? null],
        ]);

        if (isset($validated['values'])) {
            foreach ($validated['values'] as $value) {
                $featureValue = $feature->values()->create([
                    // 'slug' => $value['slug'],
                    'image' => $value['image'] ?? null,
                    'is_active' => true,
                    'sort_order' => 0,
                ]);
                $featureValue->translations()->createMany([
                    ['locale' => 'en', 'value' => $value['value']['en']],
                    ['locale' => 'ar', 'value' => $value['value']['ar']],
                ]);
            }
        }

        return response()->json(['data' => $feature->load('translations', 'values.translations')], 201);
    }

    public function update(Request $request, Feature $feature)
    {
        $validated = $request->validate([
            'name.en' => 'string|max:255',
            'name.ar' => 'string|max:255',
            'slug' => 'string|unique:features,slug,' . $feature->id . '|max:255',
            'type' => 'string|in:select,checkbox,number,text',
            'image' => 'nullable|string',
            'is_required' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'description.en' => 'nullable|string',
            'description.ar' => 'nullable|string',
        ]);

        $feature->update([
            'slug' => $validated['slug'] ?? $feature->slug,
            'type' => $validated['type'] ?? $feature->type,
            'image' => $validated['image'] ?? $feature->image,
            'is_required' => $validated['is_required'] ?? $feature->is_required,
            'is_active' => $validated['is_active'] ?? $feature->is_active,
            'sort_order' => $validated['sort_order'] ?? $feature->sort_order,
        ]);

        if (isset($validated['name']['en'])) {
            $feature->translations()->updateOrCreate(
                ['locale' => 'en'],
                ['name' => $validated['name']['en'], 'description' => $validated['description']['en'] ?? null]
            );
        }
        if (isset($validated['name']['ar'])) {
            $feature->translations()->updateOrCreate(
                ['locale' => 'ar'],
                ['name' => $validated['name']['ar'], 'description' => $validated['description']['ar'] ?? null]
            );
        }

        return response()->json(['data' => $feature->load('translations', 'values.translations')], 200);
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();
        return response()->json(['message' => 'Feature deleted successfully'], 200);
    }
}