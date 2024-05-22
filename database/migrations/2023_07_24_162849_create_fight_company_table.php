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
        Schema::create('fight_company', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->String('location');
            $table->string('description');
            $table->string('photo');
            $table->string('Rate');
            $table->string('food');
            $table->string('service');
            $table->string('Comforts');
            $table->string('safe');
            $table->foreignId('Country_id')->constrained('Country');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fight_company');
    }
};
