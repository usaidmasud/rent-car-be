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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('car_id')->constrained('cars');
            $table->integer('rental_fee')->unsigned()->comment('biaya sewa / hari');
            $table->integer('day')->unsigned()->comment('lama pinjam');
            $table->integer('total_payment')->unsigned()->comment('total biaya');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
