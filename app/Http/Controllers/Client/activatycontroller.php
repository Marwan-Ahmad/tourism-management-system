<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivtiyReserve;
use App\Models\User;
use Illuminate\Http\Request;

class activatycontroller extends Controller
{
    //Get Activaty
    public function GetActivities(){
        $Activties=Activity::get();
        return response()->json([
            "status"=>"200",
            "Activties"=>$Activties
        ]);
    }

    //Reseve Activity
    public function ReserveAvtivity(Request $request){

        $request->validate([
            'email'=>"required",
            'IdOfActivity'=>"required",
        ]);
        $User=User::where('email',$request->email)->first();
        if(!$User){
            return response()->json([
                "sattus"=>"200",
                "Message"=>"not found this email"
            ]);
        }

        $UserId=$User->id;
        $ActivtiyReserve=new ActivtiyReserve();
        $ActivtiyReserve-> users_id=$UserId;
        $ActivtiyReserve-> activity_id=$request->IdOfActivity;
        $ActivtiyReserve->save();
        return response()->json([
            "sattus"=>"200",
            "Message"=>"The activity is reserved"
        ]);
        // $UserId=$User->id;
        // DB::table('reserve_activity')->insert([
        //     'activity_id'=>$request->IdOfActivity,
        //     'users_id'=>$UserId
        // ]);
        // return response()->json([
        //     "sattus"=>"200",
        //     "Message"=>"The activity is reserved"
        // ]);
    }

}