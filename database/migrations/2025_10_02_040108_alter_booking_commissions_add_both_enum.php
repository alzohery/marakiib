<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking_commissions', function (Blueprint $table) {
            $table->enum('applies_to', ['buyer', 'seller', 'both'])
                  ->default('buyer')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('booking_commissions', function (Blueprint $table) {
            $table->enum('applies_to', ['buyer', 'seller'])
                  ->default('buyer')
                  ->change();
        });
    }
};
