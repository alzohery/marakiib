<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AssignAdditionalPermissionsSeeder extends Seeder
{
    public function run()
    {
        $rolePermissions = [
            'private_renter' => [
                'view-reviews',
                'manage-wallet',
            ],
            'rental_office' => [
                'view-reviews',
                'manage-wallet',
            ],
            'customer' => [
                
               'view-bookings',
               'cancel-booking',
               'manage-favourites', // أضفتها هنا
            ],
        ];

        foreach ($rolePermissions as $roleName => $perms) {
            $role = Role::findByName($roleName);
            $role->givePermissionTo($perms); // يضيف الصلاحيات بدون حذف القديمة
        }

        $this->command->info('dooooooooooon');
    }
}
