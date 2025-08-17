<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraOptionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('extra_options', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('type'); // checkbox, select
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('extra_option_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('extra_option_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('image_alt')->nullable();
            $table->unique(['extra_option_id', 'locale']);
        });

        Schema::create('car_extra_options', function (Blueprint $table) {
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->foreignId('extra_option_id')->constrained()->onDelete('cascade');
            $table->primary(['car_id', 'extra_option_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_extra_options');
        Schema::dropIfExists('extra_option_translations');
        Schema::dropIfExists('extra_options');
    }
}