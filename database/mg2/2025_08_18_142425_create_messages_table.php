<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // إنشاء جدول conversations
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user1_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user2_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('last_message_id')->nullable(); // فقط nullable الآن
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['user1_id', 'user2_id']);
        });

        // إنشاء جدول messages
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            $table->text('message');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // الآن نضيف الـ foreign keys التي كانت تسبب circular reference
        Schema::table('messages', function (Blueprint $table) {
            $table->foreignId('conversation_id')
                  ->nullable()
                  ->constrained('conversations')
                  ->onDelete('cascade')
                  ->after('id');
        });

        Schema::table('conversations', function (Blueprint $table) {
            $table->foreign('last_message_id')
                  ->references('id')
                  ->on('messages')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropForeign(['last_message_id']);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['conversation_id']);
        });

        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversations');
    }
};
