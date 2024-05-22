<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contrey;
use App\Models\Trip;
class FightCompany extends Model
{

    use HasFactory;
    protected $table="fight_company";
    protected $fillable=['name','location','description','photo','food','service',
    'Comforts','safe','familier'];
    public $timestamp=true;
    protected $hidden=['created_at','updated_at','fight_company_id'];

    public function contrey(){
        return $this->belongsTo('App\Models\Contrey','Country_id');
    }
    public function Trips(){
        return $this->hasMany('App\Models\Trip','fight_company_id');
    }

}