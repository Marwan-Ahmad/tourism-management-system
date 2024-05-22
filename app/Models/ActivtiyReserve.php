<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivtiyReserve extends Model
{
    use HasFactory;
    
    protected $table="reserve_activity";
    protected $fillable=['activity_id','users_id','LastDay']; 
}
