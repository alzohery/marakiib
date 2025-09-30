<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->enum('plate_type', ['white', 'green']);
            $table->enum('type', ['fixed', 'percentage']);
            $table->decimal('value', 10, 2);
            $table->enum('applies_to', ['buyer', 'seller', 'both'])->default('both');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['plate_type', 'type', 'applies_to']);
        });

        Schema::create('commission_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commission_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->text('description')->nullable();
            $table->unique(['commission_id', 'locale']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commission_translations');
        Schema::dropIfExists('commissions');
    }
}
?>