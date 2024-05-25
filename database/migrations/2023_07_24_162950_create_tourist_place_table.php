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
        Schema::create('tourist_place', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->String('description');
            $table->String('photo');
            $table->String('BestTime');
            $table->String('uniqueStuff');
            $table->String('service');
            $table->String('comforts');
            $table->String('safe');
            $table->String('food');
            $table->String('Rate');
            $table->foreignId('Country_id')->constrained('Country')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_place');
    }
};