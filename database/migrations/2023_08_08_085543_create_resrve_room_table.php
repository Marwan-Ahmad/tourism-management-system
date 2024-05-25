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
        Schema::create('resrve_room', function (Blueprint $table) {
            $table->id();
            $table->string('FatherName');
            $table->string('MotherName');
            $table->string('Gendor');
            $table->string('NumberOfPeople');
            $table->string('NumberOfRoom');
            $table->string('TypeRoom');
            $table->string('Meal');
            $table->string('FirstDay');
            $table->string('LastDay');
            $table->foreignId('users_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('hotel_id')->constrained('hotel')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resrve_room');
    }
};