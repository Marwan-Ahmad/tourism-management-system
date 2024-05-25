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
        Schema::create('reserve_expert', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('expert_id')->constrained('expert')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('Gendor');
            $table->string('FirstDay');
            $table->string('LastDay');
            $table->string('FirstTime');
            $table->string('LastTime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserve_expert');
    }
};