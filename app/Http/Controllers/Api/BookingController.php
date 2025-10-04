<?php

  namespace App\Http\Controllers\Api;

  use App\Http\Controllers\Controller;
  use App\Models\Booking;
  use App\Models\Car;
  use App\Models\ExtraOption;
  use App\Models\Wallet;
  use App\Models\Transaction;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Str;

  class BookingController extends Controller
  {
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('permission:view-bookings', ['guard' => 'api', 'only' => ['index', 'show']]);
        $this->middleware('permission:book-car', ['guard' => 'api', 'only' => ['store']]);
        $this->middleware('permission:cancel-booking', ['guard' => 'api', 'only' => ['cancel']]);
        $this->middleware('permission:confirm-booking', ['guard' => 'api', 'only' => ['confirm', 'reject']]);

    }

      /**
     * إنشاء حجز جديد
     */
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'car_id' => 'required|exists:cars,id',
    //         'start_date' => 'required|date|after_or_equal:today',
    //         'end_date' => 'required|date|after:start_date',
    //         'contact_number' => 'required|string|max:255',
    //         // 'gender' => 'required|in:male,female',
    //     ]);

    //     try {
    //         $car = Car::findOrFail($validated['car_id']);

    //         if ($car->availability_start > $validated['start_date'] || $car->availability_end < $validated['end_date']) {
    //             return response()->json(['message' => 'Car is not available for the selected dates'], 422);
    //         }

    //         // ✅ استبعاد الحجوزات الملغية
    //         $existingBooking = Booking::where('car_id', $validated['car_id'])
    //             ->where('status', '!=', 'cancelled')
    //             ->where(function ($query) use ($validated) {
    //                 $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
    //                     ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
    //                     ->orWhere(fn($q) => $q->where('start_date', '<=', $validated['start_date'])
    //                                         ->where('end_date', '>=', $validated['end_date']));
    //             })->exists();

    //         if ($existingBooking) {
    //             return response()->json(['message' => 'Car is already booked for the selected dates'], 422);
    //         }

    //         // ✅ حساب السعر الأساسي (بدون عمولة)
    //         $basePrice = $this->calculateTotalPrice(
    //             $car,
    //             $validated['start_date'],
    //             $validated['end_date'],
    //             []
    //         );

    //         $wallet = Wallet::where('user_id', Auth::id())->first();
    //         if (!$wallet || $wallet->balance < $basePrice) {
    //             return response()->json(['message' => 'Insufficient wallet balance'], 422);
    //         }

    //         $slug = \Str::slug($car->slug . '-' . now()->timestamp . '-' . Auth::id());

    //         return DB::transaction(function () use ($validated, $car, $basePrice, $slug, $wallet) {
    //             // إنشاء الحجز بالسعر الأساسي فقط
    //             $booking = Booking::create([
    //                 'customer_id' => Auth::id(),
    //                 'car_id' => $validated['car_id'],
    //                 'start_date' => $validated['start_date'],
    //                 'end_date' => $validated['end_date'],
    //                 'total' => $basePrice, // هنا بدون عمولة
    //                 'commission_amount' => 0, // هيتحدث لاحقاً
    //                 'status' => 'pending',
    //                 'contact_number' => $validated['contact_number'],
    //                 // 'gender' => $validated['gender'],
    //                 'slug' => $slug,
    //                 'is_active' => true,
    //             ]);

    //             // ✅ حساب العمولة وتحديث total
    //             $booking->applyCommissions();

    //             // لازم نجيب الـ total بعد التحديث
    //             $finalTotal = $booking->total;

    //             // خصم الرصيد
    //             $wallet->update(['balance' => $wallet->balance - $finalTotal]);

    //             // إنشاء معاملة
    //             Transaction::create([
    //                 'wallet_id' => $wallet->id,
    //                 'amount' => $finalTotal,
    //                 'type' => 'payment',
    //                 'status' => 'completed',
    //                 'slug' => \Str::slug('payment-booking-' . $booking->id . '-' . now()->timestamp),
    //                 'is_active' => true,
    //             ]);

    //             return response()->json(['data' => $booking], 201);
    //         });

    //     } catch (\Exception $e) {
    //         \Log::error('Booking creation failed', [
    //             'customer_id' => Auth::id(),
    //             'input' => $request->all(),
    //             'error' => $e->getMessage(),
    //         ]);

    //         return response()->json([
    //             'message' => 'Failed to create booking',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    public function store(Request $request)
{
    $validated = $request->validate([
        'car_id' => 'required|exists:cars,id',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after:start_date',
        'contact_number' => 'required|string|max:255',
    ]);

    try {
        $car = Car::findOrFail($validated['car_id']);

        // ✅ تحقق من التوافر
        if ($car->availability_start > $validated['start_date'] || $car->availability_end < $validated['end_date']) {
            return response()->json(['message' => 'Car is not available for the selected dates'], 422);
        }

        // ✅ استبعاد الحجوزات الملغية
        $existingBooking = Booking::where('car_id', $validated['car_id'])
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhere(fn($q) => $q->where('start_date', '<=', $validated['start_date'])
                                        ->where('end_date', '>=', $validated['end_date']));
            })->exists();

        if ($existingBooking) {
            return response()->json(['message' => 'Car is already booked for the selected dates'], 422);
        }

        // ✅ حساب السعر الأساسي (بدون عمولة)
        $basePrice = $this->calculateTotalPrice(
            $car,
            $validated['start_date'],
            $validated['end_date'],
            []
        );

        $wallet = Wallet::where('user_id', Auth::id())->first();
        if (!$wallet || $wallet->balance < $basePrice) {
            return response()->json(['message' => 'Insufficient wallet balance'], 422);
        }

        $slug = \Str::slug($car->slug . '-' . now()->timestamp . '-' . Auth::id());

        return DB::transaction(function () use ($validated, $car, $basePrice, $slug, $wallet) {
            // ✅ إنشاء الحجز بالسعر الأساسي
            $booking = Booking::create([
                'customer_id' => Auth::id(),
                'car_id' => $validated['car_id'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'base_price' => $basePrice, // السعر الأساسي
                'total' => $basePrice,      // مبدئيًا = base_price
                'commission_amount' => 0,
                'status' => 'pending',
                'contact_number' => $validated['contact_number'],
                'slug' => $slug,
                'is_active' => true,
            ]);

            // ✅ حساب العمولة وتحديث total
            $booking->applyCommissions();

            // خصم من المحفظة على أساس الـ total بعد العمولة
            $wallet->update(['balance' => $wallet->balance - $booking->total]);

            // ✅ إنشاء معاملة
            Transaction::create([
                'wallet_id' => $wallet->id,
                'amount' => $booking->total,
                'type' => 'payment',
                'status' => 'completed',
                'slug' => \Str::slug('payment-booking-' . $booking->id . '-' . now()->timestamp),
                'is_active' => true,
            ]);

            return response()->json(['data' => $booking], 201);
        });

    } catch (\Exception $e) {
        \Log::error('Booking creation failed', [
            'customer_id' => Auth::id(),
            'input' => $request->all(),
            'error' => $e->getMessage(),
        ]);

        return response()->json([
            'message' => 'Failed to create booking',
            'error' => $e->getMessage()
        ], 500);
    }
}




    /**
     * تأكيد الحجز
     */
    public function confirm($id)
    {
        $booking = Booking::with(['car', 'bookingCommissions'])->findOrFail($id);

        if ($booking->status !== 'pending') {
            return response()->json(['status' => 'error', 'message' => 'لا يمكن تأكيد هذا الحجز'], 422);
        }

        DB::transaction(function () use ($booking) {
            // تطبيق العمولات
            $booking->applyCommissions();

            // خصم العمولات من المحافظ
            $booking->deductCommissionsFromWallets();

            // دفع صافي المبلغ للمؤجر
            $sellerWallet = Wallet::firstOrCreate(
                ['user_id' => $booking->car->user_id],
                ['balance' => 0, 'is_active' => true, 'slug' => 'wallet-' . $booking->car->user_id]
            );

            $netAmount = $booking->total - $booking->commission_amount;

            $sellerWallet->increment('balance', $netAmount);

            Transaction::create([
                'wallet_id' => $sellerWallet->id,
                'amount' => $netAmount,
                'type' => 'earning',
                'status' => 'completed',
                'slug' => 'booking-earning-' . now()->timestamp,
                'is_active' => true,
            ]);

            // تحديث حالة الحجز
            $booking->update(['status' => 'confirmed']);
        });

        return response()->json([
            'status' => 'success',
            'message' => 'تم تأكيد الحجز بنجاح',
            'data' => $booking->fresh(['bookingCommissions']),
        ]);
    }

    /**
     * إلغاء الحجز (لو لسه pending)
     */
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status !== 'pending') {
            return response()->json(['status' => 'error', 'message' => 'لا يمكن إلغاء هذا الحجز'], 422);
        }

        DB::transaction(function () use ($booking) {
            // استرجاع المبلغ للعميل
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $booking->customer_id],
                ['balance' => 0, 'is_active' => true, 'slug' => 'wallet-' . $booking->customer_id]
            );

            $wallet->increment('balance', $booking->total);

            Transaction::create([
                'wallet_id' => $wallet->id,
                'amount' => $booking->total,
                'type' => 'refund',
                'status' => 'completed',
                'slug' => 'booking-refund-' . now()->timestamp,
                'is_active' => true,
            ]);

            $booking->update(['status' => 'cancelled']);
        });

        return response()->json(['status' => 'success', 'message' => 'تم إلغاء الحجز']);
    }

    public function index(Request $request)
    {
        $locale = $request->header('Accept-Language', 'en');
        $user = Auth::user();

        $bookings = Booking::with([
            'car.translations' => fn($q) => $q->where('locale', $locale),
            'car.categories.translations' => fn($q) => $q->where('locale', $locale),
            'car.featureValues.translations' => fn($q) => $q->where('locale', $locale),
            'car.featureValues.feature.translations' => fn($q) => $q->where('locale', $locale),
            'customer'
        ])
        ->where(function ($q) use ($user) {
            if ($user->hasRole('private_renter') || $user->hasRole('rental_office')) {
                $q->whereHas('car', fn($c) => $c->where('user_id', $user->id));
            } else {
                $q->where('customer_id', $user->id);
            }
        })
        ->whereHas('car')
        ->get();

        return response()->json([
            'data' => $bookings->map(function ($booking) use ($locale) {
                $car = $booking->car;
                $customer = $booking->customer;

                return [
                    'id' => $booking->id,
                    'car_id' => $booking->car_id,
                    'car_name' => $car->translations->first()?->name ?? $car->model,
                    'car_model' => $car->model,
                    'start_date' => $booking->start_date,
                    'end_date' => $booking->end_date,
                    'total' => $booking->total,
                    'status' => $booking->status,
                    'contact_number' => $booking->contact_number,
                    'slug' => $booking->slug,
                    'image' => $booking->image,
                    'is_active' => $booking->is_active,
                    'renter_name' => $customer?->name ?? 'Unknown',
                    'car' => [
                        'id' => $car->id,
                        'name' => $car->translations->first()?->name ?? $car->model,
                        'model' => $car->model,
                        'color' => $car->color,
                        'main_image' => $car->main_image,
                        'rental_price' => $car->rental_price,
                        'categories' => $car->categories->map(fn($category) => [
                            'id' => $category->id,
                            'name' => $category->translations->where('locale', $locale)->first()?->name ?? $category->slug,
                            'slug' => $category->slug,
                            'image' => $category->image,
                        ])->toArray(),
                        'features' => $car->featureValues->map(fn($featureValue) => [
                            'feature_id' => $featureValue->feature_id,
                            'feature_name' => $featureValue->feature?->translations->where('locale', $locale)->first()?->name ?? $featureValue->feature->slug,
                            'value_id' => $featureValue->id,
                            'value' => $featureValue->translations->where('locale', $locale)->first()?->value ?? '',
                        ])->toArray(),
                    ],
                ];
            })
        ]);
    }

    public function show(Request $request, $id)
    {
        $locale = $request->header('Accept-Language', 'en');
        $user = Auth::user();

        $booking = Booking::with([
            'car.translations' => fn($q) => $q->where('locale', $locale),
            'car.categories.translations' => fn($q) => $q->where('locale', $locale),
            'car.featureValues.translations' => fn($q) => $q->where('locale', $locale),
            'car.featureValues.feature.translations' => fn($q) => $q->where('locale', $locale),
        ])
        ->where('id', $id)
        ->where(function($q) use ($user) {
            if ($user->hasAnyRole(['private_renter', 'rental_office'])) {
                $q->whereHas('car', fn($c) => $c->where('user_id', $user->id));
            } else {
                $q->where('customer_id', $user->id);
            }
        })
        ->firstOrFail();

        return response()->json([
            'data' => [
                'id' => $booking->id,
                'car_id' => $booking->car_id,
                'car_name' => $booking->car->translations->first()->name ?? $booking->car->model,
                'car_model' => $booking->car->model,
                'start_date' => $booking->start_date,
                'end_date' => $booking->end_date,
                'total' => $booking->total,
                'status' => $booking->status,
                'contact_number' => $booking->contact_number,
                'slug' => $booking->slug,
                'image' => $booking->image,
                'is_active' => $booking->is_active,
                'car' => [
                    'id' => $booking->car->id,
                    'name' => $booking->car->translations->first()->name ?? $booking->car->model,
                    'model' => $booking->car->model,
                    'color' => $booking->car->color,
                    'main_image' => $booking->car->main_image,
                    'rental_price' => $booking->car->rental_price,
                    'categories' => $booking->car->categories->map(fn($category) => [
                        'id' => $category->id,
                        'name' => $category->translations->where('locale', $locale)->first()->name ?? $category->slug,
                        'slug' => $category->slug,
                        'image' => $category->image,
                    ]),
                    'features' => $booking->car->featureValues->map(fn($featureValue) => [
                        'feature_id' => $featureValue->feature_id,
                        'feature_name' => $featureValue->feature->translations->where('locale', $locale)->first()->name ?? $featureValue->feature->slug,
                        'value_id' => $featureValue->id,
                        'value' => $featureValue->translations->where('locale', $locale)->first()->value ?? '',
                    ]),
                ],
            ]
        ]);
    }


 

    public function reject(Request $request, $id)
    {
        try {
            $booking = Booking::where('id', $id)
                ->with('car')
                ->firstOrFail();

            if (!Auth::user()->hasRole('admin') && $booking->car->user_id != Auth::id()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            if ($booking->status != 'pending') {
                return response()->json(['message' => 'Booking cannot be rejected'], 422);
            }

            return DB::transaction(function () use ($booking) {
                $booking->update(['status' => 'rejected', 'is_active' => false]);

                $customerWallet = Wallet::where('user_id', $booking->customer_id)->firstOrFail();
                $customerWallet->update(['balance' => $customerWallet->balance + $booking->total]);

                Transaction::create([
                    'wallet_id' => $customerWallet->id,
                    'amount' => $booking->total,
                    'type' => 'refund',
                    'status' => 'completed',
                    'slug' => Str::slug('refund-booking-' . $booking->id . '-' . now()->timestamp),
                    'is_active' => true,
                ]);

                return response()->json([
                    'message' => 'Booking rejected successfully',
                    'data' => $booking->load(
                        'car.translations',
                        'car.categories.translations',
                        'car.featureValues.translations',
                        'car.featureValues.feature.translations'
                    )
                ]);
            });
        } catch (\Exception $e) {
            \Log::error('Booking rejection failed', [
                'user_id' => Auth::id(),
                'booking_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Failed to reject booking',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    

    



    private function calculateTotalPrice(Car $car, $startDate, $endDate, array $optionIds)
    {
        $days = (new \DateTime($startDate))->diff(new \DateTime($endDate))->days;
        $basePrice = $car->rental_price * $days;
        $optionsPrice = 0;

        if (!empty($optionIds)) {
            $optionsPrice = ExtraOption::whereIn('id', $optionIds)->sum('price') * $days;
        }

        return $basePrice + $optionsPrice;
    }

}
?> 

