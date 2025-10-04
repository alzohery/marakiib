<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivacyTable extends Migration
{
    public function up()
    {
        Schema::create('privacy', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->comment('رابط ثابت للصفحة');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('privacy_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('privacy_id')->constrained('privacy')->onDelete('cascade');
            $table->string('locale', 5)->index(); // مثل: ar, en
            $table->string('title');
            $table->text('content');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('image')->nullable();     // صورة خاصة باللغة
            $table->string('image_alt')->nullable();
            $table->unique(['privacy_id', 'locale']);
        });

    }

    public function down()
    {
        Schema::dropIfExists('privacy_translations');
        Schema::dropIfExists('privacy');
    }
}
