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
        Schema::create('hotel', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->String('description');
            $table->String('Basicphoto');
            $table->String('Roomphoto1');
            $table->String('Roomphoto2');
            $table->String('Roomphoto3');
            $table->String('food');
            $table->String('service');
            $table->String('comforts');
            $table->String('safe');
            $table->String('Rate');
            $table->foreignId('Country_id')->constrained('Country');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel');
    }
};
