<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('permission:write-review', ['only' => ['store']]);
        $this->middleware('permission:view-reviews', ['only' => ['index']]);
    }

    public function index(Request $request, $carId)
    {
        $locale = $request->header('Accept-Language', 'en');

        $car = Car::findOrFail($carId);

        $reviews = Review::where('car_id', $carId)
            ->where('is_active', true)
            ->with([
                'customer:id,name,avatar',
                'car.translations' => fn($q) => $q->where('locale', $locale)
            ])
            ->get();

        return \App\Http\Resources\ReviewResource::collection($reviews);
    }


    public function store(Request $request, $carId)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $car = Car::findOrFail($carId);

        $hasCompletedBooking = Booking::where('customer_id', Auth::id())
            ->where('car_id', $carId)
            ->where('status', 'completed')
            ->exists();

        if (!$hasCompletedBooking) {
            return response()->json(['message' => 'You can only review a car after completing a booking.'], 403);
        }

        $existingReview = Review::where('user_id', Auth::id())
            ->where('car_id', $carId)
            ->exists();

        if ($existingReview) {
            return response()->json(['message' => 'You have already reviewed this car.'], 422);
        }

        $review = Review::create([
            'car_id' => $carId,
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'slug' => Str::slug('review-' . $carId . '-' . Auth::id() . '-' . now()->timestamp),
            'is_active' => true,
        ]);

        return response()->json([
            'message' => 'Review created successfully',
            'data' => $this->formatReview($review)
        ], 201);
    }

    public function update(Request $request, $reviewId)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review = Review::where('id', $reviewId)
            ->where('user_id', Auth::id()) // عشان مايعدلش على مراجعة غيره
            ->firstOrFail();

        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return response()->json([
            'message' => 'Review updated successfully',
            'data' => $this->formatReview($review)
        ]);
    }

    private function formatReview($review)
    {
        return [
            'id' => $review->id,
            'car_id' => $review->car_id,
            'user' => [
                'id' => $review->user->id,
                'name' => $review->user->name,
                'avatar' => $review->user->avatar,
            ],
            'rating' => $review->rating,
            'comment' => $review->comment,
            'created_at' => $review->created_at,
            'updated_at' => $review->updated_at,
        ];
    }


     
    

    public function destroy($reviewId)
    {
        $review = Review::where('id', $reviewId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $review->delete();

        return response()->json([
            'message' => 'Review deleted successfully'
        ]);
    }



}
