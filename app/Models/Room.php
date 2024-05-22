<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table="resrve_room";
    protected $fillable=['FatherName','MotherName','Gendor','NumberOfPeople',
    'NumberOfRoom','TypeRoom','Meal','FirstDay','LastDay'];
    
}
