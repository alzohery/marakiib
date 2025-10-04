<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supports', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('اسم المرسل');
            $table->string('email')->comment('إيميل المرسل');
            $table->string('subject')->comment('موضوع التذكرة');
            $table->text('message')->comment('رسالة التذكرة');
            $table->enum('status', ['open', 'closed'])->default('open')->comment('حالة التذكرة');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supports');
    }
};