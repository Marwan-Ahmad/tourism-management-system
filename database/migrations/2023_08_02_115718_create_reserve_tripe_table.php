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
            $table->foreignId('users_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('fight_air_planes_id')->constrained('fight_air_planes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("fatherName");
            $table->string("MotherName");
            $table->string("Gendor");
            $table->string("FlightClass");
            $table->integer("Wight");
            $table->integer('amountpeople');
            $table->string('status')->default('unpayed');
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
