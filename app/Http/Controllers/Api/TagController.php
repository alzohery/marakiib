<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Spatie\Permission\Middlewares\PermissionMiddleware;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', PermissionMiddleware::class . ':manage-tags'])->except(['index', 'show']);
    }

    public function index()
    {
        $tags = Tag::with('translations')->get();

        return response()->json(['data' => $tags], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name.en' => 'required|string',
            'name.ar' => 'required|string',
            'slug' => 'required|string|unique:tags,slug',
            'image' => 'nullable|string',
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

        $tag = Tag::create([
            'slug' => $validated['slug'],
            'image' => $validated['image'],
            'is_active' => $validated['is_active'] ?? true,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        $tag->translations()->createMany([
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

        return response()->json(['data' => $tag->loadTranslations()], 201);
    }

    public function show(Tag $tag)
    {
        return response()->json(['data' => $tag->loadTranslations()], 200);
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name.en' => 'string',
            'name.ar' => 'string',
            'slug' => 'string|unique:tags,slug,' . $tag->id,
            'image' => 'nullable|string',
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

        $tag->update($validated);
        foreach (['en', 'ar'] as $locale) {
            if (isset($validated['name'][$locale])) {
                $tag->translations()->updateOrCreate(
                    ['locale' => $locale],
                    [
                        'name' => $validated['name'][$locale] ?? $tag->translate($locale)->name,
                        'description' => $validated['description'][$locale] ?? $tag->translate($locale)->description,
                        'meta_title' => $validated['meta_title'][$locale] ?? $tag->translate($locale)->meta_title,
                        'meta_description' => $validated['meta_description'][$locale] ?? $tag->translate($locale)->meta_description,
                        'image_alt' => $validated['image_alt'][$locale] ?? $tag->translate($locale)->image_alt,
                    ]
                );
            }
        }

        return response()->json(['data' => $tag->loadTranslations()], 200);
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json(['message' => 'Tag deleted successfully'], 200);
    }
}