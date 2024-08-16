<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class restaurant extends Model
{
    use HasFactory;
    protected $fillable=[
        'RestaurantName',
        'location',
        'PhoneOFRestaurant',
        'description',
        'food',
        'service',
        'comforts',
        'safe',
        'Rate',
        'opening_hours',
        'closing_hours',
        'Country_id',
        'photo',
        'x',
        'y',
    ];

    protected $hidden=[
        "updated_at",
        "created_at"
    ];

    public function contrey(){
        return $this->belongsTo('App\Models\Contrey','Country_id');
    }
}