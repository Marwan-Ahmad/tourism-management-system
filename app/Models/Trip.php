<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $table="fight_air_planes";
    protected $fillable=['TripPlace','Towards','TimeTrip','Price','country_id','fight_company_id','amountpeople'];
    public $timestamp=true;
    protected $hidden=['created_at','updated_at'];



    public function country(){
        return $this->belongsTo('App\Models\Contrey','country_id');
    }


    public function company(){
        return $this->belongsTo('App\Models\FightCompany','fight_company_id');
    }
}