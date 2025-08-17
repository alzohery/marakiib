<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Spatie\Permission\Middlewares\PermissionMiddleware;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', PermissionMiddleware::class . ':manage-bookings']);
    }

    public function index()
    {
        $bookings = Booking::with(['car', 'customer'])->get();
        return response()->json(['data' => $bookings], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total' => 'required|numeric|min:0',
            'extra_options' => 'nullable|array',
            'contact_number' => 'required|string',
            'gender' => 'required|string|in:male,female',
            'slug' => 'required|string|unique:bookings,slug',
        ]);

        $car = Car::findOrFail($validated['car_id']);
        if ($car->user_id === auth()->id()) {
            return response()->json(['message' => 'You cannot book your own car'], 403);
        }

        $booking = Booking::create([
            'car_id' => $validated['car_id'],
            'customer_id' => auth()->id(),
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total' => $validated['total'],
            'extra_options' => $validated['extra_options'],
            'status' => 'pending',
            'contact_number' => $validated['contact_number'],
            'gender' => $validated['gender'],
            'slug' => $validated['slug'],
            'is_active' => true,
            'sort_order' => 0,
        ]);

        return response()->json(['data' => $booking->load(['car', 'customer'])], 201);
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        return response()->json(['data' => $booking->load(['car', 'customer'])], 200);
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);
        $validated = $request->validate([
            'start_date' => 'date',
            'end_date' => 'date|after:start_date',
            'total' => 'numeric|min:0',
            'extra_options' => 'nullable|array',
            'contact_number' => 'string',
            'gender' => 'string|in:male,female',
            'status' => 'string|in:pending,confirmed,canceled',
            'slug' => 'string|unique:bookings,slug,' . $booking->id,
        ]);

        $booking->update($validated);
        return response()->json(['data' => $booking->load(['car', 'customer'])], 200);
    }

    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);
        $booking->delete();
        return response()->json(['message' => 'Booking deleted successfully'], 200);
    }
}
