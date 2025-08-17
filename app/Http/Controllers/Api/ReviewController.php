<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Car;
use Illuminate\Http\Request;
use Spatie\Permission\Middlewares\PermissionMiddleware;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', PermissionMiddleware::class . ':manage-reviews'])->except(['index', 'show']);
    }

    public function index()
    {
        $reviews = Review::with(['car', 'user'])->get();
        return response()->json(['data' => $reviews], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'slug' => 'required|string|unique:reviews,slug',
        ]);

        $car = Car::findOrFail($validated['car_id']);
        if ($car->user_id === auth()->id()) {
            return response()->json(['message' => 'You cannot review your own car'], 403);
        }

        $review = Review::create([
            'car_id' => $validated['car_id'],
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'slug' => $validated['slug'],
            'is_active' => true,
            'sort_order' => 0,
        ]);

        return response()->json(['data' => $review->load(['car', 'user'])], 201);
    }

    public function show(Review $review)
    {
        return response()->json(['data' => $review->load(['car', 'user'])], 200);
    }

    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);
        $validated = $request->validate([
            'rating' => 'integer|min:1|max:5',
            'comment' => 'nullable|string',
            'slug' => 'string|unique:reviews,slug,' . $review->id,
        ]);

        $review->update($validated);
        return response()->json(['data' => $review->load(['car', 'user'])], 200);
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        $review->delete();
        return response()->json(['message' => 'Review deleted successfully'], 200);
    }
}
