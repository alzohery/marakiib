<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\CarType;
use App\Models\Car;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Feature;
use App\Models\FeatureValue;
use App\Models\ExtraOption;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class AppSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // إنشاء المستخدمين
        $renter = User::firstOrCreate([
            'name' => 'suber admin',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone_number' => '123445167890',
            'email_verified_at'=> '2025-08-23T00:58:28.000000Z',
            'car_license_expiry_date'=> '2026-01-09T00:00:00.000000Z',

            'car_license_image'=> 'licenses/JJlTY6MVjWTRDRst3QI9e9kPBvmDR0D5ipIOxeKe.jpg',
            
            'commercial_registration_number'=> '7894824999',

            'address' => 'Mansoura',
            'slug' => Str::slug('suber admin1'),
            'is_active' => true,
            'sort_order' => 0,
        ]);
        $renter->assignRole('admin');
        $renter = User::firstOrCreate([
            'name' => 'Test Renter',
            'email' => 'renter7@example.com',
            'password' => Hash::make('password123'),
            'role' => 'private_renter',
            'phone_number' => '12345167890',
            'email_verified_at'=> '2025-08-23T00:58:28.000000Z',
            'car_license_expiry_date'=> '2026-01-09T00:00:00.000000Z',

            'car_license_image'=> 'licenses/JJlTY6MVjWTRDRst3QI9e9kPBvmDR0D5ipIOxeKe.jpg',
            
            'commercial_registration_number'=> '7894824999',

            'address' => 'Mansoura',
            'slug' => Str::slug('7Test Renter'),
            'is_active' => true,
            'sort_order' => 0,
        ]);
        $renter->assignRole('private_renter');
        

        

        $customer = User::firstOrCreate([
            'name' => 'mohamed alzohery',
            'email' => '2mohamedmohasenalzohery@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at'=> '2025-08-23T00:58:28.000000Z',
            'car_license_image'=> 'licenses/JJlTY6MVjWTRDRst3QI9e9kPBvmDR0D5ipIOxeKe.jpg',
            'car_license_expiry_date'=> '2026-01-09T00:00:00.000000Z',
            'commercial_registration_number'=> '7894824999',
            'phone_number' => '09187654321',
            'address' => 'Mansoura',
            'slug' => Str::slug('2mohamed-mohasen-alzohery'),
            'is_active' => true,
            'sort_order' => 0,
        ]);
        $customer->assignRole('customer');


        // أنواع السيارات
        $carTypes = [];
        foreach (['Sedan', 'SUV', 'Hatchback', 'Coupe', 'Convertible'] as $typeName) {
            $type = CarType::firstOrCreate([
                'slug' => Str::slug($typeName),
                'image' => strtolower($typeName) . '.jpg',
                'is_active' => true,
                'sort_order' => 0,
            ]);
            $type->translations()->create(['locale' => 'en', 'name' => $typeName, 'description' => "$typeName cars"]);
            $type->translations()->create(['locale' => 'ar', 'name' => $typeName, 'description' => "$typeName سيارات"]);
            $carTypes[] = $type;
        }

        // Features مترجمة
        $featuresData = [
            'color' => ['en' => 'Color', 'ar' => 'اللون', 'values' => [
                'Black' => 'أسود', 'White' => 'أبيض', 'Red' => 'أحمر', 'Blue' => 'أزرق', 'Gray' => 'رمادي', 'Silver' => 'فضي', 'Green' => 'أخضر'
            ]],
            'transmission' => ['en' => 'Transmission', 'ar' => 'نوع القير', 'values' => [
                'Automatic' => 'أوتوماتيك', 'Manual' => 'يدوي'
            ]],
            'fuel' => ['en' => 'Fuel Type', 'ar' => 'نوع الوقود', 'values' => [
                'Petrol' => 'بنزين', 'Diesel' => 'سولار', 'Electric' => 'كهرباء', 'Hybrid' => 'هايبرد'
            ]],
            'seats' => ['en' => 'Seats', 'ar' => 'عدد المقاعد', 'values' => [
                '2' => 'مقعدين', '4' => '4 مقاعد', '5' => '5 مقاعد', '7' => '7 مقاعد'
            ]],
            'ac' => ['en' => 'Air Conditioning', 'ar' => 'مكيف', 'values' => [
                'Yes' => 'نعم', 'No' => 'لا'
            ]],
        ];

        $features = [];
        foreach ($featuresData as $slug => $data) {
            $feature = Feature::create([
                'slug' => $slug,
                'type' => 'select',
                'is_required' => true,
                'is_active' => true,
            ]);
            $feature->translations()->create(['locale' => 'en', 'name' => $data['en']]);
            $feature->translations()->create(['locale' => 'ar', 'name' => $data['ar']]);

            $values = [];
            foreach ($data['values'] as $en => $ar) {
                $val = FeatureValue::create([
                    'feature_id' => $feature->id,
                    'slug' => Str::slug($en),
                    'is_active' => true,
                ]);
                $val->translations()->create(['locale' => 'en', 'value' => $en]);
                $val->translations()->create(['locale' => 'ar', 'value' => $ar]);
                $values[] = $val;
            }
            $features[$slug] = $values;
        }

        // Extra Options
        $extraOptionsData = [
            ['slug' => 'gps', 'name_en' => 'GPS', 'name_ar' => 'نظام تحديد المواقع', 'price' => 15.0],
            ['slug' => 'child_seat', 'name_en' => 'Child Seat', 'name_ar' => 'كرسي أطفال', 'price' => 5.0],
            ['slug' => 'insurance', 'name_en' => 'Insurance', 'name_ar' => 'تأمين', 'price' => 20.0],
            ['slug' => 'wifi', 'name_en' => 'WiFi', 'name_ar' => 'انترنت', 'price' => 10.0],
        ];
        $extraOptions = [];
        foreach ($extraOptionsData as $eo) {
            $eoObj = ExtraOption::create([
                'slug' => $eo['slug'],
                'price' => $eo['price'],
                'type' => 'checkbox',
                'is_active' => true,
                'sort_order' => 0
            ]);
            $eoObj->translations()->create(['locale' => 'en', 'name' => $eo['name_en']]);
            $eoObj->translations()->create(['locale' => 'ar', 'name' => $eo['name_ar']]);
            $extraOptions[] = $eoObj;
        }

        // 50 سيارة مع ربط Categories وترجمات
        for ($i = 1; $i <= 50; $i++) {
            $carType = $carTypes[array_rand($carTypes)];
            $car = Car::create([
                'user_id' => $renter->id,
                'car_type_id' => $carType->id,
                'model' => $faker->year,
                'color' => $faker->randomElement(['Black', 'White', 'Red', 'Blue', 'Gray']),
                'main_image' => 'car' . $i . '.jpg',
                'extra_images' => [$faker->imageUrl(), $faker->imageUrl()],
                'engine_type' => $faker->randomElement(['V4', 'V6', 'V8']),
                'slug' => Str::slug($carType->slug . '-' . $i),
                'plate_type' => $faker->randomElement(['white', 'green']),
                'rental_price' => $faker->randomFloat(2, 50, 200),
                'availability_start' => now(),
                'availability_end' => now()->addMonths(rand(1, 6)),
                'latitude' => $faker->latitude(31.0364, 31.0644),
                'longitude' => $faker->longitude(31.3782, 31.4140),
                'long_term_guarantee' => $faker->boolean,
                'pickup_delivery' => $faker->boolean,
                'is_active' => true,
                'sort_order' => 0,
            ]);

            // إضافة الترجمات مع locale
            $car->translations()->create([
                'locale' => 'en',
                'name' => $faker->company . ' ' . $car->model,
                'insurance_type' => 'Comprehensive',
                'usage_nature' => 'Personal',
                'description' => $faker->sentence,
                'meta_title' => $faker->sentence(6),
                'meta_description' => $faker->paragraph,
                'image_alt' => $faker->sentence(3),
            ]);
            $car->translations()->create([
                'locale' => 'ar',
                'name' => 'سيارة ' . $i,
                'insurance_type' => 'شامل',
                'usage_nature' => 'شخصي',
                'description' => $faker->sentence,
                'meta_title' => 'سيارة ' . $i,
                'meta_description' => 'وصف السيارة ' . $i,
                'image_alt' => 'صورة سيارة ' . $i,
            ]);

            // ربط Categories عشوائية
            $categoryIds = Category::pluck('id')->random(rand(1, 3))->toArray();
            $car->categories()->sync($categoryIds);

            // ربط Features عشوائية
            foreach ($features as $slug => $values) {
                $val = $values[array_rand($values)];
                DB::table('car_feature_values')->insert([
                    'car_id' => $car->id,
                    'feature_value_id' => $val->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Extra Options عشوائية
            foreach ($extraOptions as $eo) {
                if (rand(0, 1)) {
                    DB::table('car_extra_options')->insert([
                        'car_id' => $car->id,
                        'extra_option_id' => $eo->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            // ريفيوهات
            for ($r = 1; $r <= rand(1, 5); $r++) {
                Review::create([
                    'car_id' => $car->id,
                    'user_id' => $customer->id,
                    'rating' => rand(3, 5),
                    'comment' => $faker->sentence,
                    'slug' => Str::slug('7review-' . $i . '-' . $r),
                    'is_active' => true,
                    'sort_order' => 0,
                ]);
            }
        }
    }
}
?>