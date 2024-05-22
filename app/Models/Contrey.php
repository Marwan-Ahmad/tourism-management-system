<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Hotel;
use App\Models\Expert;
use App\Models\touristPlace;
class Contrey extends Model
{
    use HasFactory;
    //  use SoftDeletes;
    protected $table="country";
    protected $fillable=['name','Rate',];
    public $timestamp=true;
    protected $hidden=['created_at','updated_at','id','deleted_at'];
    
    public function Airplanes(){
        return $this->hasMany('App\Models\FightCompany','Country_id');
    }
    public function Hotels(){
        return $this->hasMany('App\Models\Hotel','Country_id');
    }
    public function TouristPlaces(){
        return $this->hasMany('App\Models\touristPlace','Country_id');
    }
    public function Experts(){
        return $this->hasMany('App\Models\Expert','Country_id');
    }
}
