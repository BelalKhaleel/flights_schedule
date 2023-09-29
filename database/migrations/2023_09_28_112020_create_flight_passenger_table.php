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
        Schema::create('flight_passenger', function (Blueprint $table) {
            $table->id();
            $table->foreignId('passenger_id')->constrained('passengers')->onDelete('cascade');
            $table->foreignId('flight_id')->constrained('flights')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_passenger');
    }
};
