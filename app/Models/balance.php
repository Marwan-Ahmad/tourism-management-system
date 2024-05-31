<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class balance extends Model
{
    use HasFactory;

    protected $fillable=['balance','last_transaction_date','user_id'];
    protected $hidden=['created_at','updated_at'];

    public function clients(){
        return $this->belongsTo('App\Models\User','user_id');
    }

}
