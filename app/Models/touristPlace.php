<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class touristPlace extends Model
{
    use HasFactory;
    protected $table="tourist_place";
    protected $fillable=['name','location','description','photo','BestTime','uniqueStuff'
    ,'service','comforts','safe','food','Rate','Country_id'];
    protected $hidden=['updated_at','created_at'];
}
