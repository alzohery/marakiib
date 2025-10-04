<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    /**
     * جلب كل الأسئلة والأجوبة مع الترجمة الحالية
     */
    public function index(Request $request)
    {
        $locale = $request->get('locale', app()->getLocale());

        $faqs = FAQ::with(['translations' => function ($q) use ($locale) {
            $q->where('locale', $locale);
        }])
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();

        // تحويل البيانات بصيغة JSON منظمة
        $result = $faqs->map(function ($faq) use ($locale) {
            $translation = $faq->translations->first();

            return [
                'id'        => $faq->id,
                'slug'      => $faq->slug,
                'title'     => $translation?->title,
                'content'   => $translation?->content,
                'meta_title' => $translation?->meta_title,
                'meta_description' => $translation?->meta_description,
                'meta_keywords'    => $translation?->meta_keywords,
                'image'           => $translation?->image ? asset('storage/' . $translation->image) : null,
                'image_alt'       => $translation?->image_alt,
            ];
        });

        return response()->json($result);
    }
}
