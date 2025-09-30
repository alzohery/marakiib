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
            Role::findOrCreate($roleName, 'web');
        }

        // ---- 2. تعريف الصلاحيات ----
        $permissions = [
            'view-any-Users', // الصلاحية الجديدة للـ admin فقط
            'view-Users', // الصلاحية الجديدة للـ admin فقط
            'create-Users', // الصلاحية الجديدة للـ admin فقط
            'update-Users', // الصلاحية الجديدة للـ admin فقط
            'delete-Users', // الصلاحية الجديدة للـ admin فقط

            
            'view-any-Bookings',
            'view-All_Bookings',
            'create-Bookings',
            'update-Bookings',
            'delete-Bookings',
            'manage-roles',
            'manage-permissions',
            // 
            'manage-commissions',

            'view-adminpanel', // الصلاحية الجديدة للـ admin فقط
            'view-dashboard', // احتفظت بيها لو عايز تستخدمها لاحقًا
            'manage-cars',
            'manage cars', // لسه موجودة، ممكن ندمجها لاحقًا
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
            'manage-favorites',
        ];

        // إنشاء الصلاحيات الفريدة
        foreach ($permissions as $permName) {
            Permission::findOrCreate($permName, 'web');
        }

        // ---- 3. تعيين الصلاحيات لكل دور ----
        $rolePermissions = [
            'admin' => $permissions, // الأدمن عنده كل الصلاحيات بما فيها view-adminpanel
            'customer' => [
                'view-dashboard',
                'book-car',
                'view-reviews',
                'write-review',
                'manage-favorites',
            ],
            'private_renter' => [
                'view-dashboard',
                'manage-cars',
                'manage cars',
                'manage-bookings',
                'view-bookings',
                'confirm-booking',
                'cancel-booking',
            ],
            'rental_office' => [
                'view-dashboard',
                'manage-cars',
                'manage cars',
                'manage-bookings',
                'view-bookings',
                'confirm-booking',
                'cancel-booking',
                'manage-offers',
            ],
        ];

        foreach ($rolePermissions as $roleName => $perms) {
            $role = Role::findByName($roleName, 'web');
            $role->syncPermissions($perms);
        }

        $this->command->info('تم إنشاء الأدوار والصلاحيات وربطها بنجاح!');
    }
}
?>