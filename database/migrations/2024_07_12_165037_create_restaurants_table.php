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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('RestaurantName');
            $table->string('location');
            $table->string('PhoneOFRestaurant');
            $table->String('description');
            $table->String('food');
            $table->String('service');
            $table->String('comforts');
            $table->String('safe');
            $table->String('Rate');
            $table->string('opening_hours');
            $table->string('closing_hours');
            $table->string('photo');
            $table->foreignId('Country_id')->constrained('Country')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
