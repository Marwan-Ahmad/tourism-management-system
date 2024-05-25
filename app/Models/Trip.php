<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $table="fight_air_planes";
    protected $fillable=['TripPlace','Towards','DayOfTheTrip','MonthOfTheTrip','TimeOfTheTrip','Price'];
    public $timestamp=true;
    protected $hidden=['created_at','updated_at'];

}