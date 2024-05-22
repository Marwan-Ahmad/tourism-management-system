<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reserveExpert extends Model
{
    use HasFactory;
    protected $table="reserve_expert";
    protected $fillable=['Gendor','FirstDay','LastDay']; 
}
