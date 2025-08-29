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
        Schema::create('portfolio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('symbol')->unique();
            $table->enum('type', ['stock', 'currency']);
            $table->decimal('quantity', 15, 4)->default(0);
            $table->decimal('purchase_price', 15, 4)->nullable();
            $table->decimal('stop_loss', 15, 4)->nullable();
            $table->decimal('take_profit', 15, 4)->nullable();
            $table->timestamp('added_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio');
    }
};
