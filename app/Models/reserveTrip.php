<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reserveTrip extends Model
{
    use HasFactory;
    protected $table="reserve_tripe";
    protected $fillable=['fatherName','MotherName','Gendor','FlightClass','Wight'];
    protected $hidden=['id','users_id','fight_air_planes_id'];    

}
