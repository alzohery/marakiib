<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Feature;
use App\Models\FeatureValue;
use App\Models\Favorite;
// use App\Models\Option;

class PublicController extends Controller
{
    public function features()
    {
        $features = Feature::with([
            'values.translations' // القيم المرتبطة بالـ feature مع الترجمات
        ])
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();

        // ترتيب القيم داخل كل Feature
        $features->each(function($feature) {
            $feature->values = $feature->values->where('is_active', true)->sortBy('sort_order')->values();
        });

        return response()->json([
            'data' => $features
        ]);
    }

    public function featuresOnly()
    {
        $features = Feature::where('is_active', 1)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'data' => $features
        ]);
    }

    
    public function featureValues()
    {
        $values = \App\Models\FeatureValue::with('translations')
            // ->where('feature_id', $featureId)
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'data' => $values
        ]);
    }



    public function viewAvailableCars(Request $request)
{
    $locale = $request->header('Accept-Language', 'en');
    $startDate = $request->query('start_date', now()->toDateString());
    $endDate = $request->query('end_date', now()->addDays(7)->toDateString());

    $cars = Car::where('is_active', true)
        ->where('availability_start', '<=', $startDate)
        ->where('availability_end', '>=', $endDate)
        ->whereDoesntHave('bookings', function ($query) use ($startDate, $endDate) {
            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate])
                  ->orWhere(function ($subQ) use ($startDate, $endDate) {
                      $subQ->where('start_date', '<=', $startDate)
                           ->where('end_date', '>=', $endDate);
                  });
            });
        })
        ->with([
            'translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            },
            'categories.translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            },
            'featureValues.translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            },
            'featureValues.feature.translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            },
            'options.translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }
        ])
        ->get();

    $data = $cars->map(function ($car) {
        $carTrans = $car->translations->first();

        return [
            'id' => $car->id,
            'name' => $carTrans?->name,
            'model' => $car->model,
            'color' => $car->color,
            'main_image' => $car->main_image,
            'car_type_id' => $car->car_type_id,
            'engine_type' => $car->engine_type,
            'slug' => $car->slug,
            'rental_price' => $car->rental_price,
            'availability_start' => $car->availability_start,
            'availability_end' => $car->availability_end,
            'latitude' => $car->latitude,
            'longitude' => $car->longitude,
            'long_term_guarantee' => $car->long_term_guarantee,
            'pickup_delivery' => $car->pickup_delivery,
            'is_active' => $car->is_active,
            'insurance_type' => $carTrans?->insurance_type,
            'usage_nature' => $carTrans?->usage_nature,
            'description' => $carTrans?->description,
            'meta_title' => $carTrans?->meta_title,
            'meta_description' => $carTrans?->meta_description,
            'image_alt' => $carTrans?->image_alt,
            'categories' => $car->categories->map(function ($category) {
                $catTrans = $category->translations->first();
                return [
                    'id' => $category->id,
                    'name' => $catTrans?->name,
                    'slug' => $category->slug,
                    'image' => $category->image,
                ];
            }),
            'features' => $car->featureValues->map(function ($featureValue) {
                $featureTrans = $featureValue->feature?->translations->first();
                $valueTrans = $featureValue->translations->first();
                return [
                    'feature_id' => $featureValue->feature_id,
                    'feature_name' => $featureTrans?->name,
                    'value_id' => $featureValue->id,
                    'value' => $valueTrans?->value,
                ];
            }),
            'options' => $car->options->map(function ($option) {
                $optTrans = $option->translations->first();
                return [
                    'id' => $option->id,
                    'name' => $optTrans?->name,
                    'slug' => $option->slug,
                    'price' => $option->price,
                ];
            }),
        ];
    });

    return response()->json([
        'data' => $data,
    ]);
}


    // public function viewPopularCars(Request $request)
    // {
    //     $locale = $request->header('Accept-Language', 'en');
    //     $cars = Car::where('is_active', true)
    //         ->withCount('bookings')
    //         ->orderBy('bookings_count', 'desc')
    //         ->take(10)
    //         ->with([
    //             'translations' => function ($query) use ($locale) {
    //                 $query->where('locale', $locale);
    //             },
    //             'categories.translations' => function ($query) use ($locale) {
    //                 $query->where('locale', $locale);
    //             },
    //             'featureValues.translations' => function ($query) use ($locale) {
    //                 $query->where('locale', $locale);
    //             },
    //             'featureValues.feature.translations' => function ($query) use ($locale) {
    //                 $query->where('locale', $locale);
    //             },
    //             'options.translations' => function ($query) use ($locale) {
    //                 $query->where('locale', $locale);
    //             }
    //         ])
    //         ->get();

    //     return response()->json([
    //         'data' => $cars->map(function ($car) use ($locale) {
    //             return [
    //                 'id' => $car->id,
    //                 'name' => $car->translations->first()->name,
    //                 'model' => $car->model,
    //                 'color' => $car->color,
    //                 'main_image' => $car->main_image,
    //                 'car_type_id' => $car->car_type_id,
    //                 'engine_type' => $car->engine_type,
    //                 'slug' => $car->slug,
    //                 'rental_price' => $car->rental_price,
    //                 'availability_start' => $car->availability_start,
    //                 'availability_end' => $car->availability_end,
    //                 'latitude' => $car->latitude,
    //                 'longitude' => $car->longitude,
    //                 'long_term_guarantee' => $car->long_term_guarantee,
    //                 'pickup_delivery' => $car->pickup_delivery,
    //                 'is_active' => $car->is_active,
    //                 'insurance_type' => $car->translations->first()->insurance_type,
    //                 'usage_nature' => $car->translations->first()->usage_nature,
    //                 'description' => $car->translations->first()->description,
    //                 'meta_title' => $car->translations->first()->meta_title,
    //                 'meta_description' => $car->translations->first()->meta_description,
    //                 'image_alt' => $car->translations->first()->image_alt,
    //                 'bookings_count' => $car->bookings_count,
    //                 'categories' => $car->categories->map(function ($category) {
    //                     return [
    //                         'id' => $category->id,
    //                         'name' => $category->translations->first()->name,
    //                         'slug' => $category->slug,
    //                         'image' => $category->image,
    //                     ];
    //                 }),
    //                 'features' => $car->featureValues->map(function ($featureValue) {
    //                     return [
    //                         'feature_id' => $featureValue->feature_id,
    //                         'feature_name' => $featureValue->feature->translations->first()->name,
    //                         'value_id' => $featureValue->id,
    //                         'value' => $featureValue->translations->first()->value,
    //                     ];
    //                 }),
    //                 'options' => $car->options->map(function ($option) {
    //                     return [
    //                         'id' => $option->id,
    //                         'name' => $option->translations->first()->name,
    //                         'slug' => $option->slug,
    //                         'price' => $option->price,
    //                     ];
    //                 }),
    //             ];
    //         })
    //     ]);
    // }

    public function viewPopularCars(Request $request)
{
    $locale = $request->header('Accept-Language', 'en');

    $cars = Car::where('is_active', true)
        ->withCount('bookings')
        ->orderBy('bookings_count', 'desc')
        ->take(10)
        ->with([
            'translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            },
            'categories.translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            },
            'featureValues.translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            },
            'featureValues.feature.translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            },
            'options.translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }
        ])
        ->get();

    return response()->json([
        'data' => $cars->map(function ($car) use ($locale) {
            $translation = $car->translations->first();

            return [
                'id' => $car->id,
                'name' => optional($translation)->name,
                'model' => $car->model,
                'color' => $car->color,
                'main_image' => $car->main_image,
                'car_type_id' => $car->car_type_id,
                'engine_type' => $car->engine_type,
                'slug' => $car->slug,
                'rental_price' => $car->rental_price,
                'availability_start' => $car->availability_start,
                'availability_end' => $car->availability_end,
                'latitude' => $car->latitude,
                'longitude' => $car->longitude,
                'long_term_guarantee' => $car->long_term_guarantee,
                'pickup_delivery' => $car->pickup_delivery,
                'is_active' => $car->is_active,
                'insurance_type' => optional($translation)->insurance_type,
                'usage_nature' => optional($translation)->usage_nature,
                'description' => optional($translation)->description,
                'meta_title' => optional($translation)->meta_title,
                'meta_description' => optional($translation)->meta_description,
                'image_alt' => optional($translation)->image_alt,
                'bookings_count' => $car->bookings_count,

                'categories' => $car->categories->map(function ($category) {
                    $catTrans = $category->translations->first();

                    return [
                        'id' => $category->id,
                        'name' => optional($catTrans)->name,
                        'slug' => $category->slug,
                        'image' => $category->image,
                    ];
                }),

                'features' => $car->featureValues->map(function ($featureValue) {
                    $featTrans = $featureValue->translations->first();
                    $featName = optional($featureValue->feature->translations->first())->name;

                    return [
                        'feature_id' => $featureValue->feature_id,
                        'feature_name' => $featName,
                        'value_id' => $featureValue->id,
                        'value' => optional($featTrans)->value,
                    ];
                }),

                'options' => $car->options->map(function ($option) {
                    $optTrans = $option->translations->first();

                    return [
                        'id' => $option->id,
                        'name' => optional($optTrans)->name,
                        'slug' => $option->slug,
                        'price' => $option->price,
                    ];
                }),
            ];
        })
    ]);
}



// public function getCarDetails(Request $request, $id)
// {
//     $locale = $request->header('Accept-Language', 'en');

//     $car = Car::where('is_active', true)
//         ->where('id', $id)
//         ->with([
//             'user',
//             'translations' => function ($query) use ($locale) {
//                 $query->where('locale', $locale);
//             },
//             'categories.translations' => function ($query) use ($locale) {
//                 $query->where('locale', $locale);
//             },
//             'featureValues.translations' => function ($query) use ($locale) {
//                 $query->where('locale', $locale);
//             },
//             'featureValues.feature.translations' => function ($query) use ($locale) {
//                 $query->where('locale', $locale);
//             },
//             'options.translations' => function ($query) use ($locale) {
//                 $query->where('locale', $locale);
//             },
//             // إضافة الريفيوز مع المستخدم
//             'reviews.user',
//         ])
//         ->firstOrFail();

//     $carTrans = $car->translations->first();

//     return response()->json([
//         'data' => [
//             'id' => $car->id,
//             'name' => $carTrans?->name,
//             'model' => $car->model,
//             'color' => $car->color,
//             'main_image' => $car->main_image,
//             'extra_images' => $car->extra_images,

//             'car_type_id' => $car->car_type_id,
//             'engine_type' => $car->engine_type,
//             'slug' => $car->slug,
//             'rental_price' => $car->rental_price,
//             'availability_start' => $car->availability_start,
//             'availability_end' => $car->availability_end,
//             'latitude' => $car->latitude,
//             'longitude' => $car->longitude,
//             'long_term_guarantee' => $car->long_term_guarantee,
//             'pickup_delivery' => $car->pickup_delivery,
//             'is_active' => $car->is_active,
//             'insurance_type' => $carTrans?->insurance_type,
//             'usage_nature' => $carTrans?->usage_nature,
//             'description' => $carTrans?->description,
//             'meta_title' => $carTrans?->meta_title,
//             'meta_description' => $carTrans?->meta_description,
//             'image_alt' => $carTrans?->image_alt,

//             'categories' => $car->categories->map(function ($category) {
//                 $catTrans = $category->translations->first();
//                 return [
//                     'id' => $category->id,
//                     'name' => $catTrans?->name,
//                     'slug' => $category->slug,
//                     'image' => $category->image,
//                 ];
//             }),

//             'features' => $car->featureValues->map(function ($featureValue) {
//                 $featureTrans = $featureValue->feature?->translations->first();
//                 $valueTrans = $featureValue->translations->first();
//                 return [
//                     'feature_id' => $featureValue->feature_id,
//                     'feature_name' => $featureTrans?->name,
//                     'value_id' => $featureValue->id,
//                     'value' => $valueTrans?->value,
//                 ];
//             }),

//             'options' => $car->options->map(function ($option) {
//                 $optTrans = $option->translations->first();
//                 return [
//                     'id' => $option->id,
//                     'name' => $optTrans?->name,
//                     'slug' => $option->slug,
//                     'price' => $option->price,
//                 ];
//             }),

//             'user' => [
//                 'id' => $car->user?->id,
//                 'name' => $car->user?->name,
//                 'email' => $car->user?->email,
//                 'phone_number' => $car->user?->phone_number,
//                 'address' => $car->user?->address,
//                 'avatar' => $car->user?->avatar,
//             ],

//             // 🆕 هنا هنرجع الريفيوز
//             'reviews' => $car->reviews->map(function ($review) {
//                 return [
//                     'id' => $review->id,
//                     'rating' => $review->rating,
//                     'comment' => $review->comment,
//                     'created_at' => $review->created_at,
//                     'user' => [
//                         'id' => $review->user?->id,
//                         'name' => $review->user?->name,
//                         'avatar' => $review->user?->avatar,
//                     ]
//                 ];
//             }),
//         ]
//     ]);
// }

// public function getCarDetails(Request $request, $id)
// {
//     $locale = $request->header('Accept-Language', 'en');

//     $car = Car::where('is_active', true)
//         ->where('id', $id)
//         ->with([
//             'user',
//             'translations' => fn($q) => $q->where('locale', $locale),
//             'categories.translations' => fn($q) => $q->where('locale', $locale),
//             'featureValues.translations' => fn($q) => $q->where('locale', $locale),
//             'featureValues.feature.translations' => fn($q) => $q->where('locale', $locale),
//             'options.translations' => fn($q) => $q->where('locale', $locale),
//             'reviews.user',
//         ])
//         ->firstOrFail();

//     $carTrans = $car->translations->first();

    
//     $isFavourite = false;
//     if(auth()->check() && auth()->user()->hasRole('customer')) {
//         $isFavourite = $car->favourites()
//             ->where('user_id', auth()->id())
//             ->exists();
//     }

//     return response()->json([
//         'data' => [
//             'id' => $car->id,
//             'name' => $carTrans?->name,
//             'model' => $car->model,
//             'color' => $car->color,
//             'main_image' => $car->main_image,
//             'extra_images' => $car->extra_images,
//             'car_type_id' => $car->car_type_id,
//             'engine_type' => $car->engine_type,
//             'slug' => $car->slug,
//             'rental_price' => $car->rental_price,
//             'availability_start' => $car->availability_start,
//             'availability_end' => $car->availability_end,
//             'latitude' => $car->latitude,
//             'longitude' => $car->longitude,
//             'long_term_guarantee' => $car->long_term_guarantee,
//             'pickup_delivery' => $car->pickup_delivery,
//             'is_active' => $car->is_active,
//             'insurance_type' => $carTrans?->insurance_type,
//             'usage_nature' => $carTrans?->usage_nature,
//             'description' => $carTrans?->description,
//             'meta_title' => $carTrans?->meta_title,
//             'meta_description' => $carTrans?->meta_description,
//             'image_alt' => $carTrans?->image_alt,

//             'is_favourite' => $isFavourite, // ✅ هنا القيمة

//             'categories' => $car->categories->map(fn($category) => [
//                 'id' => $category->id,
//                 'name' => $category->translations->first()?->name,
//                 'slug' => $category->slug,
//                 'image' => $category->image,
//             ]),

//             'features' => $car->featureValues->map(fn($featureValue) => [
//                 'feature_id' => $featureValue->feature_id,
//                 'feature_name' => $featureValue->feature?->translations->first()?->name,
//                 'value_id' => $featureValue->id,
//                 'value' => $featureValue->translations->first()?->value,
//             ]),

//             'options' => $car->options->map(fn($option) => [
//                 'id' => $option->id,
//                 'name' => $option->translations->first()?->name,
//                 'slug' => $option->slug,
//                 'price' => $option->price,
//             ]),

//             'user' => [
//                 'id' => $car->user?->id,
//                 'name' => $car->user?->name,
//                 'email' => $car->user?->email,
//                 'phone_number' => $car->user?->phone_number,
//                 'address' => $car->user?->address,
//                 'avatar' => $car->user?->avatar,
//             ],

//             'reviews' => $car->reviews->map(fn($review) => [
//                 'id' => $review->id,
//                 'rating' => $review->rating,
//                 'comment' => $review->comment,
//                 'created_at' => $review->created_at,
//                 'user' => [
//                     'id' => $review->user?->id,
//                     'name' => $review->user?->name,
//                     'avatar' => $review->user?->avatar,
//                 ]
//             ]),
//         ]
//     ]);
// }

public function getCarDetails(Request $request, $id)
{
    $locale = $request->header('Accept-Language', 'en');

    $car = Car::where('is_active', true)
        ->where('id', $id)
        ->with([
            'user',
            'translations' => fn($q) => $q->where('locale', $locale),
            'categories.translations' => fn($q) => $q->where('locale', $locale),
            'featureValues.translations' => fn($q) => $q->where('locale', $locale),
            'featureValues.feature.translations' => fn($q) => $q->where('locale', $locale),
            'options.translations' => fn($q) => $q->where('locale', $locale),
            'reviews.user',
            'favourites', // مهم لحساب is_favourite
        ])
        ->firstOrFail();

    $carTrans = $car->translations->first();

    // حساب إذا السيارة مفضلة فقط لو المستخدم مسجل
    $isFavourite = auth()->check() && auth()->user()->hasRole('customer')
        ? $car->favourites->contains('user_id', auth()->id())
        : false;

    return response()->json([
        'data' => [
            'id' => $car->id,
            'name' => $carTrans?->name,
            'model' => $car->model,
            'color' => $car->color,
            'main_image' => $car->main_image,
            'extra_images' => $car->extra_images,
            'car_type_id' => $car->car_type_id,
            'engine_type' => $car->engine_type,
            'slug' => $car->slug,
            'rental_price' => $car->rental_price,
            'availability_start' => $car->availability_start,
            'availability_end' => $car->availability_end,
            'latitude' => $car->latitude,
            'longitude' => $car->longitude,
            'long_term_guarantee' => $car->long_term_guarantee,
            'pickup_delivery' => $car->pickup_delivery,
            'is_active' => $car->is_active,
            'insurance_type' => $carTrans?->insurance_type,
            'usage_nature' => $carTrans?->usage_nature,
            'description' => $carTrans?->description,
            'meta_title' => $carTrans?->meta_title,
            'meta_description' => $carTrans?->meta_description,
            'image_alt' => $carTrans?->image_alt,

            'is_favourite' => $isFavourite,

            'categories' => $car->categories->map(fn($category) => [
                'id' => $category->id,
                'name' => $category->translations->first()?->name,
                'slug' => $category->slug,
                'image' => $category->image,
            ]),

            'features' => $car->featureValues->map(fn($featureValue) => [
                'feature_id' => $featureValue->feature_id,
                'feature_name' => $featureValue->feature?->translations->first()?->name,
                'value_id' => $featureValue->id,
                'value' => $featureValue->translations->first()?->value,
            ]),

            'options' => $car->options->map(fn($option) => [
                'id' => $option->id,
                'name' => $option->translations->first()?->name,
                'slug' => $option->slug,
                'price' => $option->price,
            ]),

            'user' => [
                'id' => $car->user?->id,
                'name' => $car->user?->name,
                'email' => $car->user?->email,
                'phone_number' => $car->user?->phone_number,
                'address' => $car->user?->address,
                'avatar' => $car->user?->avatar,
            ],

            'reviews' => $car->reviews->map(fn($review) => [
                'id' => $review->id,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'created_at' => $review->created_at,
                'user' => [
                    'id' => $review->user?->id,
                    'name' => $review->user?->name,
                    'avatar' => $review->user?->avatar,
                ]
            ]),
        ]
    ]);
}


    public function viewCategoriesWithCars(Request $request)
    {
        $locale = $request->header('Accept-Language', 'en');
        $startDate = $request->query('start_date', now()->toDateString());
        $endDate = $request->query('end_date', now()->addDays(7)->toDateString());

        $categories = Category::with([
            'translations' => function ($q) use ($locale) {
                $q->where('locale', $locale);
            },
            'cars' => function ($q) use ($startDate, $endDate) {
                $q->where('is_active', true)
                ->where('availability_start', '<=', $startDate)
                ->where('availability_end', '>=', $endDate)
                ->whereDoesntHave('bookings', function ($query) use ($startDate, $endDate) {
                    $query->where(function ($q2) use ($startDate, $endDate) {
                        $q2->whereBetween('start_date', [$startDate, $endDate])
                            ->orWhereBetween('end_date', [$startDate, $endDate])
                            ->orWhere(function ($subQ) use ($startDate, $endDate) {
                                $subQ->where('start_date', '<=', $startDate)
                                    ->where('end_date', '>=', $endDate);
                            });
                    });
                });
            },
            'cars.translations' => function ($q) use ($locale) {
                $q->where('locale', $locale);
            },
            'cars.featureValues.translations' => function ($q) use ($locale) {
                $q->where('locale', $locale);
            },
            'cars.featureValues.feature.translations' => function ($q) use ($locale) {
                $q->where('locale', $locale);
            }
        ])->get();

        $data = $categories->map(function ($category) {
            $catTrans = $category->translations->first();
            return [
                'id' => $category->id,
                'name' => $catTrans?->name,
                'slug' => $category->slug,
                'image' => $category->image,
                'cars' => $category->cars->map(function ($car) {
                    $carTrans = $car->translations->first();
                    return [
                        'id' => $car->id,
                        'name' => $carTrans?->name,
                        'model' => $car->model,
                        'color' => $car->color,
                        'main_image' => $car->main_image,
                        'slug' => $car->slug,
                        'rental_price' => $car->rental_price,
                        'availability_start' => $car->availability_start,
                        'availability_end' => $car->availability_end,
                        'is_active' => $car->is_active,
                        'features' => $car->featureValues->map(function ($featureValue) {
                            $featureTrans = $featureValue->feature?->translations->first();
                            $valueTrans = $featureValue->translations->first();
                            return [
                                'feature_id' => $featureValue->feature_id,
                                'feature_name' => $featureTrans?->name,
                                'value_id' => $featureValue->id,
                                'value' => $valueTrans?->value,
                            ];
                        }),
                    ];
                }),
            ];
        });

        return response()->json(['data' => $data]);
    }

     


 }

?>