<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    use HasFactory;
    protected $table="expert";
    protected $fillable=['name','location','descreption','language','photo','Experience',
    'Eduction','Rate','Country_id'];
    
}
