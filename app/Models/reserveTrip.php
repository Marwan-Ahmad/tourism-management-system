<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reserveTrip extends Model
{
    use HasFactory;
    protected $table="reserve_tripe";
    protected $fillable=['fatherName','MotherName','Gendor','FlightClass','Wight','amountpeople'];
    protected $hidden=["updated_at","created_at"];

    public function trip(){
        return $this->belongsTo('App\Models\Trip','fight_air_planes_id');
    }

}
