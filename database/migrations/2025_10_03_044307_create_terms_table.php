<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermsTable extends Migration
{
    public function up()
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->comment('رابط ثابت للصفحة');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('term_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('terms_id')->constrained()->onDelete('cascade');
            $table->string('locale', 5)->index(); // مثل: ar, en
            $table->string('title');
            $table->text('content');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('image')->nullable();     // صورة خاصة باللغة
            $table->string('image_alt')->nullable();
            $table->unique(['terms_id', 'locale']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('term_translations');
        Schema::dropIfExists('terms');
    }
}
