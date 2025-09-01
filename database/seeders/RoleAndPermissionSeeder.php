<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // ---- 1. تعريف الأدوار ----
        $roles = [
            'admin',
            'customer',
            'private_renter',
            'rental_office',
        ];

        // إنشاء الأدوار الفريدة
        foreach ($roles as $roleName) {
            Role::findOrCreate($roleName);
        }

        // ---- 2. تعريف الصلاحيات ----
        $permissions = [
            'view-dashboard',
            'manage-cars',
            'manage cars', // أضيفت هنا كصلاحية منفصلة
            'manage-bookings',
            'chat-with-users',
            'manage-wallet',
            'manage-features',
            'create-car',
            'view-bookings',
            'book-car',
            'cancel-booking',
            'confirm-booking',
            'manage-offers',
            'write-review',
            'view-reviews',
            'manage-favourites',
        ];

        // إنشاء الصلاحيات الفريدة
        foreach ($permissions as $permName) {
            Permission::findOrCreate($permName);
        }

        // ---- 3. تعيين الصلاحيات لكل دور ----
        $rolePermissions = [
            'admin' => $permissions, // الأدمن عنده كل الصلاحيات
            'customer' => [
                'view-dashboard',
                'book-car',
                'view-reviews',
                'write-review',
            ],
            'private_renter' => [
                'view-dashboard',
                'manage-cars',
                'manage cars', // أضف هنا إذا كانت مطلوبة
                'manage-bookings',
                'view-bookings',
                'confirm-booking',
                'cancel-booking',
            ],
            'rental_office' => [
                'view-dashboard',
                'manage-cars',
                'manage cars', // أضف هنا إذا كانت مطلوبة
                'manage-bookings',
                'view-bookings',
                'confirm-booking',
                'cancel-booking',
                'manage-offers',
            ],
        ];

        foreach ($rolePermissions as $roleName => $perms) {
            $role = Role::findByName($roleName);
            $role->syncPermissions($perms); // يربط الصلاحيات بدون تكرار
        }

        $this->command->info('تم إنشاء الأدوار والصلاحيات وربطها بنجاح!');
    }
}