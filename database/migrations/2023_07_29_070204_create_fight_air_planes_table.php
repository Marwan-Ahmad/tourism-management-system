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
        Schema::create('fight_air_planes', function (Blueprint $table) {
            $table->id();
            $table->string("TripPlace");
            $table->string("Towards");
            $table->string("DayOfTheTrip");
            $table->string("MonthOfTheTrip");
            $table->string("TimeOfTheTrip");
            $table->string("Price");
            $table->foreignId('fight_company_id')->constrained('fight_company');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fight_air_planes');
    }
};
