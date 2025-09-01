<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_type_id')->constrained()->onDelete('cascade');
            $table->string('model');
            $table->string('color');
            $table->string('main_image');
            $table->json('extra_images')->nullable();
            $table->string('engine_type');
            $table->string('slug')->unique();
            $table->string('plate_type'); // white/green
            $table->decimal('rental_price', 8, 2);
            $table->dateTime('availability_start');
            $table->dateTime('availability_end');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->boolean('long_term_guarantee')->default(false);
            $table->boolean('pickup_delivery')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('car_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('insurance_type');
            $table->string('usage_nature');
            $table->text('description');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('image_alt')->nullable();
            $table->unique(['car_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_translations');
        Schema::dropIfExists('cars');
    }
}