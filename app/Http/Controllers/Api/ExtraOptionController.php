<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\ExtraOption;
use Illuminate\Http\Request;
use Spatie\Permission\Middlewares\PermissionMiddleware;

class ExtraOptionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', PermissionMiddleware::class . ':manage-extra-options'])->except(['index', 'show']);
    }

    public function index()
    {
        $extraOptions = ExtraOption::withTranslations()->get();
        return response()->json(['data' => $extraOptions], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name.en' => 'required|string',
            'name.ar' => 'required|string',
            'slug' => 'required|string|unique:extra_options,slug',
            'image' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|string|in:checkbox,select',
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

        $extraOption = ExtraOption::create([
            'slug' => $validated['slug'],
            'image' => $validated['image'],
            'price' => $validated['price'],
            'type' => $validated['type'],
            'is_active' => $validated['is_active'] ?? true,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        $extraOption->translations()->createMany([
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

        return response()->json(['data' => $extraOption->loadTranslations()], 201);
    }

    public function show(ExtraOption $extraOption)
    {
        return response()->json(['data' => $extraOption->loadTranslations()], 200);
    }

    public function update(Request $request, ExtraOption $extraOption)
    {
        $validated = $request->validate([
            'name.en' => 'string',
            'name.ar' => 'string',
            'slug' => 'string|unique:extra_options,slug,' . $extraOption->id,
            'image' => 'nullable|string',
            'price' => 'numeric|min:0',
            'type' => 'string|in:checkbox,select',
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

        $extraOption->update($validated);
        foreach (['en', 'ar'] as $locale) {
            if (isset($validated['name'][$locale])) {
                $extraOption->translations()->updateOrCreate(
                    ['locale' => $locale],
                    [
                        'name' => $validated['name'][$locale] ?? $extraOption->translate($locale)->name,
                        'description' => $validated['description'][$locale] ?? $extraOption->translate($locale)->description,
                        'meta_title' => $validated['meta_title'][$locale] ?? $extraOption->translate($locale)->meta_title,
                        'meta_description' => $validated['meta_description'][$locale] ?? $extraOption->translate($locale)->meta_description,
                        'image_alt' => $validated['image_alt'][$locale] ?? $extraOption->translate($locale)->image_alt,
                    ]
                );
            }
        }

        return response()->json(['data' => $extraOption->loadTranslations()], 200);
    }

    public function destroy(ExtraOption $extraOption)
    {
        $extraOption->delete();
        return response()->json(['message' => 'Extra option deleted successfully'], 200);
    }
}
