<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إعادة تعيين ذاكرة التخزين المؤقت للأدوار والتصاريح
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // إنشاء التصاريح الأساسية
        // يمكننا إضافة المزيد من التصاريح هنا في المستقبل
        Permission::firstOrCreate(['name' => 'view dashboard']);
        Permission::firstOrCreate(['name' => 'manage cars']);
        Permission::firstOrCreate(['name' => 'manage bookings']);
        Permission::firstOrCreate(['name' => 'chat with users']);
        Permission::firstOrCreate(['name' => 'manage wallet']);
        
        // إنشاء الأدوار وتعيين التصاريح لها
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        $customerRole->givePermissionTo([
            'view dashboard',
            'chat with users',
        ]);
        
        $privateRenterRole = Role::firstOrCreate(['name' => 'private_renter']);
        $privateRenterRole->givePermissionTo([
            'view dashboard',
            'manage cars',
            'manage bookings',
            'chat with users',
            'manage wallet',
        ]);

        $rentalOfficeRole = Role::firstOrCreate(['name' => 'rental_office']);
        $rentalOfficeRole->givePermissionTo([
            'view dashboard',
            'manage cars',
            'manage bookings',
            'chat with users',
            'manage wallet',
        ]);
    }
}
