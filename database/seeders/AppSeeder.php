<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\CarType;
use App\Models\Car;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\ExtraOption;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // إنشاء مستخدم (private_renter)
        $renter = User::create([
            'name' => 'Test Renter',
            'email' => 'renter@example.com',
            'password' => bcrypt('password123'),
            'role' => 'private_renter',
            'phone_number' => '1234567890',
            'address' => 'Riyadh',
            'latitude' => 24.7136,
            'longitude' => 46.6753,
            'slug' => Str::slug('Test Renter'),
            'is_active' => true,
            'sort_order' => 0,
        ]);
        $renter->assignRole('private_renter');

        // إنشاء مستخدم (customer)
        $customer = User::create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
            'phone_number' => '0987654321',
            'address' => 'Jeddah',
            'latitude' => 21.4858,
            'longitude' => 39.1925,
            'slug' => Str::slug('Test Customer'),
            'is_active' => true,
            'sort_order' => 0,
        ]);
        $customer->assignRole('customer');

        // إنشاء نوع سيارة
        $carType = CarType::create([
            'slug' => Str::slug('Sedan'),
            'image' => 'sedan.jpg',
            'is_active' => true,
            'sort_order' => 0,
        ]);
        $carType->translations()->create([
            'locale' => 'en',
            'name' => 'Sedan',
            'description' => 'Sedan cars for comfortable rides.',
            'meta_title' => 'Sedan Cars',
            'meta_description' => 'Explore sedan cars.',
            'image_alt' => 'Sedan Car Image',
        ]);
        $carType->translations()->create([
            'locale' => 'ar',
            'name' => 'سيدان',
            'description' => 'سيارات سيدان لرحلات مريحة.',
            'meta_title' => 'سيارات سيدان',
            'meta_description' => 'استكشف سيارات السيدان.',
            'image_alt' => 'صورة سيارة سيدان',
        ]);

        // إنشاء سيارة
        $car = Car::create([
            'user_id' => $renter->id,
            'car_type_id' => $carType->id,
            'model' => '2023',
            'color' => 'Black',
            'main_image' => 'car.jpg',
            'extra_images' => ['extra1.jpg', 'extra2.jpg'],
            'engine_type' => 'V6',
            'slug' => Str::slug('Toyota Camry 2023'),
            'plate_type' => 'white',
            'rental_price' => 100.00,
            'availability_start' => now(),
            'availability_end' => now()->addMonths(6),
            'is_active' => true,
            'sort_order' => 0,
        ]);
        $car->translations()->create([
            'locale' => 'en',
            'name' => 'Toyota Camry',
            'insurance_type' => 'Comprehensive',
            'usage_nature' => 'Personal',
            'description' => 'A reliable sedan.',
            'meta_title' => 'Toyota Camry 2023',
            'meta_description' => 'Rent a Toyota Camry 2023.',
            'image_alt' => 'Toyota Camry 2023 Sedan',
        ]);
        $car->translations()->create([
            'locale' => 'ar',
            'name' => 'تويوتا كامري',
            'insurance_type' => 'شامل',
            'usage_nature' => 'شخصي',
            'description' => 'سيدان موثوق.',
            'meta_title' => 'تويوتا كامري 2023',
            'meta_description' => 'استأجر تويوتا كامري 2023.',
            'image_alt' => 'سيارة تويوتا كامري 2023 سيدان',
        ]);

        // إنشاء تصنيف
        $category = Category::create([
            'slug' => Str::slug('Sedan'),
            'image' => 'sedan.jpg',
            'is_active' => true,
            'sort_order' => 0,
        ]);
        $category->translations()->create([
            'locale' => 'en',
            'name' => 'Sedan',
            'description' => 'Sedan cars for comfortable rides.',
            'meta_title' => 'Sedan Cars',
            'meta_description' => 'Explore sedan cars.',
            'image_alt' => 'Sedan Car Image',
        ]);
        $category->translations()->create([
            'locale' => 'ar',
            'name' => 'سيدان',
            'description' => 'سيارات سيدان لرحلات مريحة.',
            'meta_title' => 'سيارات سيدان',
            'meta_description' => 'استكشف سيارات السيدان.',
            'image_alt' => 'صورة سيارة سيدان',
        ]);

        // ربط السيارة بالتصنيف
        DB::table('car_category')->insert([
            'car_id' => $car->id,
            'category_id' => $category->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // إنشاء تاج
        $tag = Tag::create([
            'slug' => Str::slug('Luxury'),
            'image' => 'luxury.jpg',
            'is_active' => true,
            'sort_order' => 0,
        ]);
        $tag->translations()->create([
            'locale' => 'en',
            'name' => 'Luxury',
            'description' => 'Luxury cars for premium experience.',
            'meta_title' => 'Luxury Cars',
            'meta_description' => 'Explore luxury cars.',
            'image_alt' => 'Luxury Car Image',
        ]);
        $tag->translations()->create([
            'locale' => 'ar',
            'name' => 'فاخر',
            'description' => 'سيارات فاخرة لتجربة مميزة.',
            'meta_title' => 'سيارات فاخرة',
            'meta_description' => 'استكشف السيارات الفاخرة.',
            'image_alt' => 'صورة سيارة فاخرة',
        ]);

        // ربط السيارة بالتاج
        DB::table('car_tag')->insert([
            'car_id' => $car->id,
            'tag_id' => $tag->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // إنشاء Option
        $option = Option::create([
            'slug' => Str::slug('Color'),
            'image' => 'color.jpg',
            'type' => 'select',
            'is_active' => true,
            'sort_order' => 0,
        ]);
        $option->translations()->create([
            'locale' => 'en',
            'name' => 'Color',
            'description' => 'Choose the car color.',
            'meta_title' => 'Car Color Option',
            'meta_description' => 'Select your preferred car color.',
            'image_alt' => 'Car Color Image',
        ]);
        $option->translations()->create([
            'locale' => 'ar',
            'name' => 'اللون',
            'description' => 'اختر لون السيارة.',
            'meta_title' => 'خيار لون السيارة',
            'meta_description' => 'اختر لون السيارة المفضل لديك.',
            'image_alt' => 'صورة لون السيارة',
        ]);

        // إنشاء Option Value
        $optionValue = OptionValue::create([
            'option_id' => $option->id,
            'slug' => Str::slug('Black'),
            'image' => 'black.jpg',
            'is_active' => true,
            'sort_order' => 0,
        ]);
        $optionValue->translations()->create([
            'locale' => 'en',
            'value' => 'Black',
            'description' => 'Black color option.',
            'meta_title' => 'Black Color',
            'meta_description' => 'Black color for cars.',
            'image_alt' => 'Black Color Image',
        ]);
        $optionValue->translations()->create([
            'locale' => 'ar',
            'value' => 'أسود',
            'description' => 'خيار اللون الأسود.',
            'meta_title' => 'اللون الأسود',
            'meta_description' => 'اللون الأسود للسيارات.',
            'image_alt' => 'صورة اللون الأسود',
        ]);

        // ربط السيارة بالـ Option Value
        DB::table('car_options')->insert([
            'car_id' => $car->id,
            'option_value_id' => $optionValue->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // إنشاء Extra Option
        $extraOption = ExtraOption::create([
            'slug' => Str::slug('GPS'),
            'image' => 'gps.jpg',
            'price' => 10.00,
            'type' => 'checkbox',
            'is_active' => true,
            'sort_order' => 0,
        ]);
        $extraOption->translations()->create([
            'locale' => 'en',
            'name' => 'GPS',
            'description' => 'GPS navigation system.',
            'meta_title' => 'GPS Navigation',
            'meta_description' => 'Add GPS to your car rental.',
            'image_alt' => 'GPS Image',
        ]);
        $extraOption->translations()->create([
            'locale' => 'ar',
            'name' => 'نظام تحديد المواقع',
            'description' => 'نظام تحديد المواقع للملاحة.',
            'meta_title' => 'نظام تحديد المواقع',
            'meta_description' => 'أضف نظام تحديد المواقع لتأجير السيارة.',
            'image_alt' => 'صورة نظام تحديد المواقع',
        ]);

        // ربط السيارة بالـ Extra Option
        DB::table('car_extra_options')->insert([
            'car_id' => $car->id,
            'extra_option_id' => $extraOption->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // إنشاء Booking
        $booking = Booking::create([
            'car_id' => $car->id,
            'customer_id' => $customer->id,
            'start_date' => now(),
            'end_date' => now()->addDays(3),
            'total' => 300.00,
            'extra_options' => ['gps' => 10.00],
            'status' => 'pending',
            'contact_number' => '0987654321',
            'gender' => 'male',
            'slug' => Str::slug('Booking 1'),
            'is_active' => true,
            'sort_order' => 0,
        ]);

        // إنشاء Review
        $review = Review::create([
            'car_id' => $car->id,
            'user_id' => $customer->id,
            'rating' => 5,
            'comment' => 'Great car, very comfortable!',
            'slug' => Str::slug('Review 1'),
            'is_active' => true,
            'sort_order' => 0,
        ]);
    }
}
