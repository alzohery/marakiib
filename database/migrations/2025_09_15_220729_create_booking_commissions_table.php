<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_commissions', function (Blueprint $table) {
            $table->id();

            // الربط مع الحجز
            $table->foreignId('booking_id')
                ->constrained()
                ->cascadeOnDelete();

            // الربط مع العمولة
            $table->foreignId('commission_id')
                ->constrained()
                ->cascadeOnDelete();

            // القيمة المحسوبة للعمولة
            $table->decimal('amount', 10, 2);

            // نوع الطرف المطبق عليه العمولة
            $table->enum('applies_to', ['buyer', 'seller']);

            // عشان ما يحصلش إدخال مكرر لنفس العمولة على نفس الحجز ونفس الطرف
            $table->unique(['booking_id', 'commission_id', 'applies_to'], 'booking_commission_unique');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_commissions');
    }
};
