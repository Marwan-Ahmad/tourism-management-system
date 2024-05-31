<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\reserveExpert;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Firstname',
        'email',
        'Lastname',
        'Nationalty',
        'role',
        'visaphoto',
        'password',
    ];
    public function RserveExperts(){
        return $this->belongsToMany('App\Models\expert','reserve_expert','users_id','expert_id');
    }
    public function RserveTrips(){
        return $this->belongsToMany('App\Models\Trip','reserve_tripe','users_id','fight_air_planes_id');
    }
    public function RserveHotels(){
        return $this->belongsToMany('App\Models\Hotel','resrve_room','users_id','hotel_id');
    }
    public function Rserveactivity(){
        return $this->belongsToMany('App\Models\Activity','reserve_activity','users_id','activity_id');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at','updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
