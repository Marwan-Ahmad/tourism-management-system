<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $table="activity";
    protected $fillable=['name','photo','location','Rate','type','descreption','AirplanePhoto',
    'AirplaneName','AirplaneLocation','AirplaneDescreption','AirplaneServiceFood',
    'AirplaneServiceComfarts','AirplaneRate','AirplaneServiceSafe','AirplaneAnotherService',
    'TripPlace','TripToWards','TripMonth','TripDay','TripHour','TripPrice',
    'HotelPhoto','HotelName','HotelRate','HotelLocation','HotelDescreption','RoomPhoto3',
    'RoomPhoto1','RoomPhoto2','HotelServiceFood','HotelServiceComforts','HotelAnotherService',
    'HotelPrice','HotelFirstDay','HotelLastDay','TouristPlacePhoto','TouristPlaceName','TouristPlaceRate',
    'TouristPlaceLocation','TouristPlaceDescreption','TouristPlaceBestTime','TouristPlaceUniqueStuff',
    'TouristPlaceServiceFood','TouristPlaceServiceSafe','TouristPlaceServiceComforts','TouristPlaceAnotherService',
    'ExpertPhoto','ExpertName','ExpertRate','ExpertLocation','ExpertDescreption','ExpertLanguage',
    'ExpertEducation','ExpertExperience','ExpertFirstDay','ExpertLastDay','ExpertFirstTime',
    'ExpertLastTime','ExpertPrice','id'];
    protected $hidden=['created_at','updated_at','deleted_at'];
 
            
}
