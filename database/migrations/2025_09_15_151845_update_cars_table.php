<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // تنظيف البيانات قبل التغيير
        DB::table('cars')
            ->whereNotIn('plate_type', ['white', 'green'])
            ->orWhereNull('plate_type')
            ->update(['plate_type' => 'white']); // قيمة افتراضية

        Schema::table('cars', function (Blueprint $table) {
            if (Schema::hasColumn('cars', 'car_type_id')) {
                $table->dropForeign(['car_type_id']);
                $table->dropColumn(['car_type_id']);
            }

            if (Schema::hasColumn('cars', 'model')) {
                $table->dropColumn('model');
            }

            if (Schema::hasColumn('cars', 'color')) {
                $table->dropColumn('color');
            }

            if (Schema::hasColumn('cars', 'engine_type')) {
                $table->dropColumn('engine_type');
            }

            $table->enum('plate_type', ['white', 'green'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->foreignId('car_type_id')->constrained()->onDelete('cascade');
            $table->string('model');
            $table->string('color');
            $table->string('engine_type');
            $table->string('plate_type')->change(); // نرجعه String عادي
        });
    }
};
