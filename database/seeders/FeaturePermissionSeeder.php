<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class FeaturePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // إعادة تعيين ذاكرة التخزين المؤقت للأدوار والتصاريح
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // إنشاء الـ permission الجديدة
        Permission::firstOrCreate(['name' => 'manage-features']);

        // إعطاء الـ permission لدور الـ admin فقط
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo('manage-features');
    }
}