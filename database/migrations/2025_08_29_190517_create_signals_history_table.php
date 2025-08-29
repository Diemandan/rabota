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
        Schema::create('signals_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('symbol');
            $table->enum('signal_type', ['buy', 'sell', 'hold']);
            $table->decimal('rsi', 5, 2)->nullable();
            $table->decimal('price', 15, 4)->nullable();
            $table->timestamp('sent_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signals_history');
    }
};
