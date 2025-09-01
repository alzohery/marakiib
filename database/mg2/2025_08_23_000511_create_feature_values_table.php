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
        Schema::create('feature_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feature_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('feature_value_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feature_value_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('value');
            $table->text('description')->nullable();
            $table->unique(['feature_value_id', 'locale']);
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_value_translations');
        Schema::dropIfExists('feature_values');
    }
};
