<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Conversation;

use App\Models\User;
use App\Models\Feature;
use App\Events\MessageSent;

use Illuminate\Support\Str;

use App\Models\Car;
use App\Models\Booking;
use App\Models\Favorite;
use App\Models\Message;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Laravel\Scout\Searchable; // For advanced search
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
        public function __construct()
    {
        // $this->middleware(['auth:sanctum', PermissionMiddleware::class . ':role:customer']);
        $this->middleware(['auth:sanctum', 'role:customer']);
        
    }

    // public function viewAvailableCars()
    // {
    //     $cars = Car::where('is_active', true)
    //     ->where('availability_start', '<=', now())
    //     ->where('availability_end', '>=', now())
    //     ->orderBy('sort_order')
    //     ->with([
    //         'translations',
    //         'featureValues.translations',              // القيم
    //         'featureValues.feature.translations'       // اسم الـ feature نفسه
    //     ])
    //     ->get();

    // return response()->json(['data' => $cars], 200);
    // }

    // public function viewPopularCars()
    // {
    //     $popularCars = Car::with('translations')
    //         ->withCount('reviews')
    //         ->orderByDesc('reviews_count')
    //         ->where('is_active', true)
    //         ->limit(10)
    //         ->get();
    //     return response()->json(['data' => $popularCars], 200);
    // }

//     public function viewPopularCars()
// {
//     $popularCars = Car::with([
//             'translations',
//             'features.translations',
//             'features.values.translations'
//         ])
//         ->withCount('reviews')
//         ->where('is_active', true)
//         ->orderByDesc('reviews_count')
//         ->limit(10)
//         ->get();

//     return response()->json(['data' => $popularCars], 200);
// }


public function viewFavoriteCars()
{
    $favorites = Favorite::where('user_id', 1) // جرب ب id موجود فعلاً
        ->with([
            'car.translations',
            'car.features.translations',
            'car.features.values.translations'
        ])
        ->get();

    return response()->json(['favorites_raw' => $favorites], 200);
}






//     public function viewSuggestedCars()
// {
//     $userId = Auth::id();

//     $favoriteCarIds = Favorite::where('user_id', $userId)->pluck('car_id');

//     if ($favoriteCarIds->isEmpty()) {
//         // fallback: أي عربيات active
//         $cars = Car::where('is_active', true)
//             ->with([
//                 'translations',
//                 'featureValues.translations',
//                 'featureValues.feature.translations'
//             ])
//             ->limit(10)
//             ->get();
//     } else {
//         $favoriteCarTypes = Car::whereIn('id', $favoriteCarIds)->pluck('car_type_id');

//         $cars = Car::where('is_active', true)
//             ->whereIn('car_type_id', $favoriteCarTypes)
//             ->whereNotIn('id', $favoriteCarIds)
//             ->with([
//                 'translations',
//                 'featureValues.translations',
//                 'featureValues.feature.translations'
//             ])
//             ->limit(10)
//             ->get();

//         // fallback لو suggested فاضي
//         if ($cars->isEmpty()) {
//             $cars = Car::where('is_active', true)
//                 ->whereNotIn('id', $favoriteCarIds)
//                 ->with([
//                     'translations',
//                     'featureValues.translations',
//                     'featureValues.feature.translations'
//                 ])
//                 ->limit(10)
//                 ->get();
//         }
//     }

//     // تحويل البيانات بنفس شكل viewCategoriesWithCars
//     $data = $cars->map(function ($car) {
//         $carTrans = $car->translations->first();
//         return [
//             'id' => $car->id,
//             'name' => $carTrans?->name,
//             'model' => $car->model,
//             'color' => $car->color,
//             'main_image' => $car->main_image,
//             'slug' => $car->slug,
//             'rental_price' => $car->rental_price,
//             'availability_start' => $car->availability_start,
//             'availability_end' => $car->availability_end,
//             'is_active' => $car->is_active,
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
//         ];
//     });

//     return response()->json(['data' => $data], 200);
// }


public function viewSuggestedCars()
{
    $locale = request()->header('Accept-Language', 'en');
    $userId = Auth::id();

    $favoriteCarIds = Favorite::where('user_id', $userId)->pluck('car_id');

    if ($favoriteCarIds->isEmpty()) {
        $carsQuery = Car::where('is_active', true);
    } else {
        $favoriteCarTypes = Car::whereIn('id', $favoriteCarIds)->pluck('car_type_id');

        $carsQuery = Car::where('is_active', true)
            ->whereIn('car_type_id', $favoriteCarTypes)
            ->whereNotIn('id', $favoriteCarIds);

        if ($carsQuery->count() === 0) {
            $carsQuery = Car::where('is_active', true)
                ->whereNotIn('id', $favoriteCarIds);
        }
    }

    $cars = $carsQuery->with([
        'translations' => function ($q) use ($locale) {
            $q->where('locale', $locale);
        },
        'categories.translations' => function ($q) use ($locale) {
            $q->where('locale', $locale);
        },
        'featureValues.translations' => function ($q) use ($locale) {
            $q->where('locale', $locale);
        },
        'featureValues.feature.translations' => function ($q) use ($locale) {
            $q->where('locale', $locale);
        }
    ])->limit(10)->get();

    $data = $cars->map(function ($car) {
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
        ];
    });

    return response()->json(['data' => $data], 200);
}




    public function advancedSearch(Request $request)
    {
        $query = Car::search($request->input('query'))->query(function ($query) use ($request) {
            if ($request->has('car_type_id')) {
                $query->where('car_type_id', $request->input('car_type_id'));
            }
            if ($request->has('price_min')) {
                $query->where('rental_price', '>=', $request->input('price_min'));
            }
            if ($request->has('price_max')) {
                $query->where('rental_price', '<=', $request->input('price_max'));
            }
            if ($request->has('nearest')) {
                $latitude = $request->input('latitude');
                $longitude = $request->input('longitude');
                $query->whereRaw(' (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) <= ?', [$latitude, $longitude, $latitude, 50]); // 50 km radius
            }
            $query->orderBy('created_at', 'desc');
        });

        // $cars = $query->get()->loadTranslations();
        $cars = $query->get()->load('translations');

        return response()->json(['data' => $cars], 200);
    }

//     public function getCarDetails(Car $car)
// {
//     $car->load([
//         'translations',
//         'features.translations',
//         'features.values.translations',
//         'reviews.user', // لو عايز كمان الريفيوهات مع بيانات اليوزر
//     ]);

//     return response()->json([
//         'data' => $car
//     ], 200);
// }


    public function realTimeChat(Booking $booking)
    {
        $this->authorize('view', $booking);
        $messages = Message::where('booking_id', $booking->id)->with('sender', 'receiver')->get();
        return response()->json(['data' => $messages], 200);
    }

    // public function sendMessage(Request $request, Booking $booking)
    // {
    //     $this->authorize('update', $booking);
    //     $validated = $request->validate([
    //         'message' => 'required|string',
    //     ]);

    //     $message = Message::create([
    //         'booking_id' => $booking->id,
    //         'sender_id' => Auth::id(),
    //         'receiver_id' => $booking->car->user_id,
    //         'message' => $validated['message'],
    //         'slug' => Str::slug($validated['message'] . '-' . Str::random(6)),
    //         'is_active' => true,
    //         'sort_order' => 0,
    //     ]);

    //     return response()->json(['data' => $message], 201);
    // }

    public function createBooking(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'extra_options' => 'nullable|array',
            'contact_number' => 'required|string',
            'gender' => 'required|string|in:male,female',
        ]);

        $car = Car::findOrFail($validated['car_id']);
        $extraPrice = $car->extraOptions()->whereIn('id', $validated['extra_options'] ?? [])->sum('price');
        $total = $car->rental_price + $extraPrice;

        $booking = Booking::create([
            'car_id' => $car->id,
            'customer_id' => Auth::id(),
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total' => $total,
            'extra_options' => $validated['extra_options'],
            'contact_number' => $validated['contact_number'],
            'gender' => $validated['gender'],
            'slug' => Str::slug('booking-' . Auth::user()->name . '-' . Str::random(6)),
            'is_active' => true,
            'sort_order' => 0,
        ]);

        // Integrate MyFatoorah payment if needed

        return response()->json(['data' => $booking], 201);
    }

    public function addFavorite(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
        ]);

        $favorite = Favorite::create([
            'user_id' => Auth::id(),
            'car_id' => $validated['car_id'],
            'slug' => Str::slug('favorite-' . Auth::id() . '-' . $validated['car_id']),
            'is_active' => true,
            'sort_order' => 0,
        ]);

        return response()->json(['data' => $favorite], 201);
    }

    public function removeFavorite(Favorite $favorite)
    {
        $this->authorize('delete', $favorite);
        $favorite->delete();
        return response()->json(['message' => 'Favorite removed successfully'], 200);
    }

// ---------------- CHAT ----------------

public function startConversation(Request $request)
{
    $validated = $request->validate([
        'renter_id' => 'required|exists:users,id',
    ]);

    $user1_id = Auth::id();
    $user2_id = $validated['renter_id'];

    $conversation = Conversation::where(function ($q) use ($user1_id, $user2_id) {
        $q->where('user1_id', $user1_id)->where('user2_id', $user2_id);
    })->orWhere(function ($q) use ($user1_id, $user2_id) {
        $q->where('user1_id', $user2_id)->where('user2_id', $user1_id);
    })->first();

    if (!$conversation) {
        $conversation = Conversation::create([
            'user1_id' => min($user1_id, $user2_id),
            'user2_id' => max($user1_id, $user2_id),
            'is_active' => true,
            'sort_order' => 0,
        ]);
    }

    return response()->json(['data' => $conversation], 201);
}

public function getUserChats()
{
    $userId = Auth::id();

    $conversations = Conversation::where('is_active', true)
        ->where(function ($q) use ($userId) {
            $q->where('user1_id', $userId)->orWhere('user2_id', $userId);
        })
        ->with([
            'user1:id,name,image',
            'user2:id,name,image',
            'lastMessage:id,conversation_id,message,sender_id,created_at,read_at',
        ])
        ->latest('updated_at')
        ->get()
        ->map(function ($conversation) use ($userId) {
            $chatWith = $conversation->user1_id == $userId ? $conversation->user2 : $conversation->user1;
            return [
                'id' => $conversation->id,
                'chat_with' => [
                    'id' => $chatWith->id,
                    'name' => $chatWith->name,
                    'image' => $chatWith->image,
                ],
                'last_message' => $conversation->lastMessage?->message,
                'last_message_time' => optional($conversation->lastMessage)->created_at?->diffForHumans(),
                'unread_count' => $conversation->unreadCountForUser($userId),
            ];
        });

    return response()->json(['data' => $conversations], 200);
}

public function getConversationMessages($id)
{
    $conversation = Conversation::findOrFail($id);
    $this->authorize('view', $conversation);

    $messages = $conversation->messages()
        ->with(['sender:id,name,email', 'receiver:id,name,email'])
        ->select('id','conversation_id','sender_id','receiver_id','message','image','read_at','created_at')
        ->get();

    return response()->json(['data' => $messages], 200);
}

public function sendMessage(Request $request, $id)
{
    $conversation = Conversation::findOrFail($id);
    $this->authorize('update', $conversation);

    $validated = $request->validate([
        'message' => 'required|string',
        'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
    ]);

    $imagePath = $request->hasFile('image') ? $request->file('image')->store('chat_images', 'public') : null;

    $message = Message::create([
        'conversation_id' => $conversation->id,
        'sender_id' => Auth::id(),
        'receiver_id' => $conversation->user1_id === Auth::id() ? $conversation->user2_id : $conversation->user1_id,
        'message' => $validated['message'],
        'image' => $imagePath,
        'slug' => Str::slug($validated['message'] . '-' . Str::random(6)),
        'is_active' => true,
        'sort_order' => 0,
    ]);

    $conversation->update(['last_message_id' => $message->id]);

    event(new MessageSent($message));

    return response()->json(['data' => $message], 201);
}

public function markConversationAsRead($id)
{
    $conversation = Conversation::findOrFail($id);

    Message::where('conversation_id', $conversation->id)
        ->where('receiver_id', Auth::id())
        ->whereNull('read_at')
        ->update(['read_at' => now()]);

    return response()->json(['message' => 'Conversation marked as read'], 200);
}



}
