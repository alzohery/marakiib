<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\FeaturePermissionSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\AppSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            FeaturePermissionSeeder::class,
            CategorySeeder::class,
            AppSeeder::class,
            
        ]);
    }
}
