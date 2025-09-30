<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   return new class extends Migration
   {
       public function up(): void
       {
           Schema::create('site_commissions', function (Blueprint $table) {
               $table->id();
               $table->foreignId('booking_commission_id')->constrained()->onDelete('cascade');
               $table->decimal('amount', 10, 2);
               $table->enum('applies_to', ['buyer', 'seller', 'both'])->default('both');
               $table->text('description')->nullable();
               $table->timestamps();
           });
       }

       public function down(): void
       {
           Schema::dropIfExists('site_commissions');
       }
   };
   ?>