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
        Schema::create('cadences', function (Blueprint $table) {
            $table->id();
            $table->integer('daily_rate')->default(75);
            $table->boolean('status_finish')->default(0);
            $table->date('start');
            $table->date('finish')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cadences');
    }
};
