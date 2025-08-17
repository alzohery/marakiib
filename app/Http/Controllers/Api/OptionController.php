<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Http\Request;
use Spatie\Permission\Middlewares\PermissionMiddleware;

class OptionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', PermissionMiddleware::class . ':manage-options'])->except(['index', 'show']);
    }

    public function index()
    {
        $options = Option::withTranslations()->with('values')->get();
        return response()->json(['data' => $options], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name.en' => 'required|string',
            'name.ar' => 'required|string',
            'slug' => 'required|string|unique:options,slug',
            'image' => 'nullable|string',
            'type' => 'required|string|in:select,text',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'description.en' => 'nullable|string',
            'description.ar' => 'nullable|string',
            'meta_title.en' => 'nullable|string',
            'meta_title.ar' => 'nullable|string',
            'meta_description.en' => 'nullable|string',
            'meta_description.ar' => 'nullable|string',
            'image_alt.en' => 'nullable|string',
            'image_alt.ar' => 'nullable|string',
            'values' => 'array',
            'values.*.value.en' => 'required_with:values|string',
            'values.*.value.ar' => 'required_with:values|string',
            'values.*.slug' => 'required_with:values|string|unique:option_values,slug',
            'values.*.image' => 'nullable|string',
        ]);

        $option = Option::create([
            'slug' => $validated['slug'],
            'image' => $validated['image'],
            'type' => $validated['type'],
            'is_active' => $validated['is_active'] ?? true,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        $option->translations()->createMany([
            [
                'locale' => 'en',
                'name' => $validated['name']['en'],
                'description' => $validated['description']['en'],
                'meta_title' => $validated['meta_title']['en'],
                'meta_description' => $validated['meta_description']['en'],
                'image_alt' => $validated['image_alt']['en'],
            ],
            [
                'locale' => 'ar',
                'name' => $validated['name']['ar'],
                'description' => $validated['description']['ar'],
                'meta_title' => $validated['meta_title']['ar'],
                'meta_description' => $validated['meta_description']['ar'],
                'image_alt' => $validated['image_alt']['ar'],
            ],
        ]);

        if (isset($validated['values'])) {
            foreach ($validated['values'] as $value) {
                $optionValue = $option->values()->create([
                    'slug' => $value['slug'],
                    'image' => $value['image'],
                    'is_active' => true,
                    'sort_order' => 0,
                ]);
                $optionValue->translations()->createMany([
                    [
                        'locale' => 'en',
                        'value' => $value['value']['en'],
                        'description' => $value['description']['en'] ?? null,
                        'meta_title' => $value['meta_title']['en'] ?? null,
                        'meta_description' => $value['meta_description']['en'] ?? null,
                        'image_alt' => $value['image_alt']['en'] ?? null,
                    ],
                    [
                        'locale' => 'ar',
                        'value' => $value['value']['ar'],
                        'description' => $value['description']['ar'] ?? null,
                        'meta_title' => $value['meta_title']['ar'] ?? null,
                        'meta_description' => $value['meta_description']['ar'] ?? null,
                        'image_alt' => $value['image_alt']['ar'] ?? null,
                    ],
                ]);
            }
        }

        return response()->json(['data' => $option->load(['translations', 'values'])], 201);
    }

    public function show(Option $option)
    {
        return response()->json(['data' => $option->load(['translations', 'values'])], 200);
    }

    public function update(Request $request, Option $option)
    {
        $validated = $request->validate([
            'name.en' => 'string',
            'name.ar' => 'string',
            'slug' => 'string|unique:options,slug,' . $option->id,
            'image' => 'nullable|string',
            'type' => 'string|in:select,text',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'description.en' => 'nullable|string',
            'description.ar' => 'nullable|string',
            'meta_title.en' => 'nullable|string',
            'meta_title.ar' => 'nullable|string',
            'meta_description.en' => 'nullable|string',
            'meta_description.ar' => 'nullable|string',
            'image_alt.en' => 'nullable|string',
            'image_alt.ar' => 'nullable|string',
        ]);

        $option->update($validated);
        foreach (['en', 'ar'] as $locale) {
            if (isset($validated['name'][$locale])) {
                $option->translations()->updateOrCreate(
                    ['locale' => $locale],
                    [
                        'name' => $validated['name'][$locale] ?? $option->translate($locale)->name,
                        'description' => $validated['description'][$locale] ?? $option->translate($locale)->description,
                        'meta_title' => $validated['meta_title'][$locale] ?? $option->translate($locale)->meta_title,
                        'meta_description' => $validated['meta_description'][$locale] ?? $option->translate($locale)->meta_description,
                        'image_alt' => $validated['image_alt'][$locale] ?? $option->translate($locale)->image_alt,
                    ]
                );
            }
        }

        return response()->json(['data' => $option->load(['translations', 'values'])], 200);
    }

    public function destroy(Option $option)
    {
        $option->delete();
        return response()->json(['message' => 'Option deleted successfully'], 200);
    }
}
