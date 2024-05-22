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
        Schema::create('reserve_tripe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users');
            $table->foreignId('fight_air_planes_id')->constrained('fight_air_planes');
            $table->string("fatherName");
            $table->string("MotherName");
            $table->string("Gendor");
            $table->string("FlightClass");
            $table->string("Wight");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserve_tripe');
    }
};
