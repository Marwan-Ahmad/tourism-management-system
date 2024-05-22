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
        Schema::create('activity', function (Blueprint $table) {
            $table->id();
            $table->string('photo');
            $table->string('name');
            $table->string('location');
            $table->string('type');
            $table->string('descreption');
            $table->string('Rate');
            $table->string('AirplanePhoto');
            $table->string('AirplaneName');
            $table->string('AirplaneLocation');
            $table->string('AirplaneDescreption');
            $table->string('AirplaneRate');
            $table->string('AirplaneServiceFood');
            $table->string('AirplaneServiceComfarts');
            $table->string('AirplaneServiceSafe');
            $table->string('AirplaneAnotherService');
            $table->string('TripPlace');
            $table->string('TripToWards');
            $table->string('TripMonth');
            $table->string('TripDay');
            $table->string('TripHour');
            $table->string('TripPrice');
            $table->string('HotelPhoto');
            $table->string('HotelName');
            $table->string('HotelRate');
            $table->string('HotelLocation');
            $table->string('HotelDescreption');
            $table->string('RoomPhoto1');
            $table->string('RoomPhoto2');
            $table->string('RoomPhoto3');
            $table->string('HotelServiceFood');
            $table->string('HotelServiceSafe');
            $table->string('HotelServiceComforts');
            $table->string('HotelAnotherService');
            $table->string('HotelPrice');
            $table->string('HotelFirstDay');
            $table->string('HotelLastDay');
            $table->string('TouristPlacePhoto');
            $table->string('TouristPlaceName');
            $table->string('TouristPlaceRate');
            $table->string('TouristPlaceLocation');
            $table->string('TouristPlaceDescreption');
            $table->string('TouristPlaceBestTime');
            $table->string('TouristPlaceUniqueStuff');
            $table->string('TouristPlaceServiceFood');
            $table->string('TouristPlaceServiceSafe');
            $table->string('TouristPlaceServiceComforts');
            $table->string('TouristPlaceAnotherService');
            $table->string('ExpertPhoto');
            $table->string('ExpertName');
            $table->string('ExpertRate');
            $table->string('ExpertLocation');
            $table->string('ExpertDescreption');
            $table->string('ExpertLanguage');
            $table->string('ExpertEducation');
            $table->string('ExpertExperience');
            $table->string('ExpertFirstDay');
            $table->string('ExpertLastDay');
            $table->string('ExpertFirstTime');
            $table->string('ExpertLastTime');
            $table->string('ExpertPrice');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity');
    }
};
