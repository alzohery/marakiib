<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('avatar')->nullable();
            
            // حقول مشتركة بين جميع الأدوار
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            
            // حقل الدور، سيتم استخدامه مع Spatie Permissions
            $table->string('role')->default('customer'); // القيمة الافتراضية 'customer'
            
            // حقول خاصة بالعميل
            $table->string('driving_license_image')->nullable();
            
            // حقول خاصة بالمؤجر الخاص
            $table->string('car_license_image')->nullable();
            $table->date('car_license_expiry_date')->nullable();
            
            // حقول خاصة بمكتب التأجير
            $table->string('commercial_registration_number')->nullable();
            
            // حقول التسجيل الاجتماعي
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            // $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('status', ['pending', 'active', 'inactive'])->default('pending');
            // حقول SEO وتحكم العرض
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
        

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
