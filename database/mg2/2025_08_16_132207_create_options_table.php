<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->string('type'); // select, text
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('option_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('option_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('image_alt')->nullable();
            $table->unique(['option_id', 'locale']);
        });

        Schema::create('option_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('option_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('option_value_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('option_value_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('value');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('image_alt')->nullable();
            $table->unique(['option_value_id', 'locale']);
        });

        Schema::create('car_options', function (Blueprint $table) {
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->foreignId('option_value_id')->constrained()->onDelete('cascade');
            $table->primary(['car_id', 'option_value_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_options');
        Schema::dropIfExists('option_value_translations');
        Schema::dropIfExists('option_values');
        Schema::dropIfExists('option_translations');
        Schema::dropIfExists('options');
    }
}