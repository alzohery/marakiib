<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Contact;
use App\Models\Privacy;
use App\Models\Terms;
// use App\Models\FAQ;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * عرض صفحة حسب الـ slug
     */
    public function show(Request $request, string $slug)
    {
        $locale = $request->get('locale', app()->getLocale());

        $model = $this->getModelBySlug($slug);

        if (!$model) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        $page = $model::where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        $translation = $page->translations()->where('locale', $locale)->first();

        return response()->json([
            'id'               => $page->id,
            'slug'             => $page->slug,
            'is_active'        => $page->is_active,
            'sort_order'       => $page->sort_order,
            'locale'           => $locale,
            'title'            => $translation?->title,
            'content'          => $translation?->content,
            'meta_title'       => $translation?->meta_title,
            'meta_description' => $translation?->meta_description,
            'meta_keywords'    => $translation?->meta_keywords,
            'image'            => $translation?->image ? asset('storage/' . $translation->image) : null,
            'image_alt'        => $translation?->image_alt,
        ]);
    }

    /**
     * عرض كل الصفحات المتاحة
     */
    public function index(Request $request)
    {
        $locale = $request->get('locale', app()->getLocale());
        $pages = collect();

        foreach (['about', 'contact', 'terms', 'privacy'] as $slug) {
            $model = $this->getModelBySlug($slug);
            if (!$model) continue;

            $modelPages = $model::where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(function ($page) use ($locale) {
                    $translation = $page->translations()->where('locale', $locale)->first();

                    return [
                        'id'               => $page->id,
                        'slug'             => $page->slug,
                        'is_active'        => $page->is_active,
                        'sort_order'       => $page->sort_order,
                        'locale'           => $locale,
                        'title'            => $translation?->title,
                        'content'          => $translation?->content,
                        'meta_title'       => $translation?->meta_title,
                        'meta_description' => $translation?->meta_description,
                        'meta_keywords'    => $translation?->meta_keywords,
                        'image'            => $translation?->image ? asset('storage/' . $translation->image) : null,
                        'image_alt'        => $translation?->image_alt,
                    ];
                });

            $pages = $pages->merge($modelPages);
        }

        return response()->json($pages->values());
    }

    /**
     * تحديد المودل بناءً على الـ slug
     */
    protected function getModelBySlug(string $slug)
    {
        return match($slug) {
            'about-us' => About::class,
            'contact' => Contact::class,
            'terms' => Terms::class,
            'privacy' => Privacy::class,
            // 'faq' => FAQ::class,
            default => null,
        };
    }
}
