<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'slug' => 'sedan',
                'image' => 'https://images.unsplash.com/photo-1502877338535-766e1452684a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'is_active' => true,
                'sort_order' => 1,
                'translations' => [
                    ['locale' => 'en', 'name' => 'Sedan', 'description' => 'Comfortable and fuel-efficient cars suitable for city driving.'],
                    ['locale' => 'ar', 'name' => 'سيدان', 'description' => 'سيارات مريحة وموفرة للوقود مناسبة للقيادة في المدينة.']
                ]
            ],
            [
                'slug' => 'suv',
                'image' => 'https://images.unsplash.com/photo-1580273916550-ebdde4c6421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'is_active' => true,
                'sort_order' => 2,
                'translations' => [
                    ['locale' => 'en', 'name' => 'SUV', 'description' => 'Spacious and versatile vehicles for family trips and off-road adventures.'],
                    ['locale' => 'ar', 'name' => 'SUV', 'description' => 'سيارات فسيحة ومتعددة الاستخدامات للرحلات العائلية والمغامرات خارج الطريق.']
                ]
            ],
            [
                'slug' => 'hatchback',
                'image' => 'https://images.unsplash.com/photo-1494976384344-0b8f9e3c6b1a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'is_active' => true,
                'sort_order' => 3,
                'translations' => [
                    ['locale' => 'en', 'name' => 'Hatchback', 'description' => 'Compact cars with a rear door for easy cargo access.'],
                    ['locale' => 'ar', 'name' => 'هاتشباك', 'description' => 'سيارات مدمجة بباب خلفي لسهولة الوصول للأمتعة.']
                ]
            ],
            [
                'slug' => 'coupe',
                'image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'is_active' => true,
                'sort_order' => 4,
                'translations' => [
                    ['locale' => 'en', 'name' => 'Coupe', 'description' => 'Sporty two-door cars with sleek designs.'],
                    ['locale' => 'ar', 'name' => 'كوبيه', 'description' => 'سيارات رياضية ببابين بتصميم أنيق.']
                ]
            ],
            [
                'slug' => 'convertible',
                'image' => 'https://images.unsplash.com/photo-1550355291-bbee04a92027?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'is_active' => true,
                'sort_order' => 5,
                'translations' => [
                    ['locale' => 'en', 'name' => 'Convertible', 'description' => 'Cars with retractable roofs for an open-air driving experience.'],
                    ['locale' => 'ar', 'name' => 'مكشوفة', 'description' => 'سيارات بسقف قابل للطي لتجربة قيادة في الهواء الطلق.']
                ]
            ],
            [
                'slug' => 'pickup',
                'image' => 'https://images.unsplash.com/photo-1502741126168-b0f46260bddd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'is_active' => true,
                'sort_order' => 6,
                'translations' => [
                    ['locale' => 'en', 'name' => 'Pickup', 'description' => 'Rugged trucks designed for heavy-duty tasks and towing.'],
                    ['locale' => 'ar', 'name' => 'بيك أب', 'description' => 'شاحنات قوية مصممة للمهام الشاقة والسحب.']
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create([
                'slug' => $categoryData['slug'],
                'image' => $categoryData['image'],
                'is_active' => $categoryData['is_active'],
                'sort_order' => $categoryData['sort_order'],
            ]);

            $category->translations()->createMany($categoryData['translations']);
        }
    }
}
?>