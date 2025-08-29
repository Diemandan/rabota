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
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->string('telegram_api_key')->nullable();
            $table->string('telegram_chat_id')->nullable();
            $table->string('tradernet_user_id')->nullable();
            $table->string('tradernet_api_key')->nullable();
            $table->string('sid')->nullable();
            $table->string('notify_frequency')->default('daily');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};
