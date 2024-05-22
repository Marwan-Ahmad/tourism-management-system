<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contrey;
use App\Models\Room;
class Hotel extends Model
{
    use HasFactory;
    protected $table="hotel";
    protected $fillable=['name','location','description','Roomphoto2','Roomphoto3'
    ,'food','service','safe','comforts','ٌRate','Basicphoto','Roomphoto1'];
    public $timestamp=true;
    protected $hidden=['created_at','updated_at'];
    
    public function contrey(){
        return $this->belongsTo('App\Models\Contrey','Country_id');
    }
    public function Rooms(){
        return $this->hasMany('App\Models\Room','hotel_id');
    }

}
