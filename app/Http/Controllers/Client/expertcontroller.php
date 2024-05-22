<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Contrey;
use App\Models\reserveExpert;
use App\Models\User;
use Illuminate\Http\Request;

class expertcontroller extends Controller
{
    //Get Country With Experts
    public function getCountryWithExpert(Request $request){
        $request->validate([
            "NameOfCountry"=>'required'
        ]);
        $CounterWithExpert=new Contrey();
        $CounterWithExpert=Contrey::with(['Experts'=>function($q){
            $q->select(['id','name','location','language','descreption','photo','Experience',
            'Eduction','Rate','Country_id']);
        }])->where('name',$request->NameOfCountry)->get();
        if(! $CounterWithExpert){
            return response()->json([
                "sattus"=>"200",
                "Message"=>"the Tourist place not found",
            ]);
        }
        // $Services=Contrey::with(['Airplanes'=>function($q){
        //     $q->select(['food','service','Comforts','safe','id','Country_id']);
        // }])->where('name',$request->NameOfCountry)->get();
        // $CounterWithAirPlanes.= $Services;
        return response()->json([
            "sattus"=>"200",
            "Countries"=>$CounterWithExpert,
        ]);
    }

    //Reseve Experts
    public function ReservExpert(Request $request){
        $request->validate([
            'Gendor'=>"required",
            'FirstDay'=>"required",
            'LastDay'=>"required",
            'FirstTime'=>"required",
            'LastTime'=>"required",
            'email'=>"required",
            'Expert_id'=>"required",
        ]);
        $User=User::where('email',$request->email)->first();
        if(!$User){
            return response()->json([
                "sattus"=>"200",
                "Message"=>"not found this email"
            ]);
        }

        $UserId=$User->id;
        $Expert=new reserveExpert();
        $Expert-> Gendor=$request->Gendor;
        $Expert-> FirstDay=$request->FirstDay;
        $Expert-> LastDay=$request->LastDay;
        $Expert-> FirstTime=$request->FirstTime;
        $Expert-> LastTime=$request->LastTime;
        $Expert-> expert_id=$request->Expert_id;
        $Expert-> users_id=$UserId;
        $Expert->save();
        return response()->json([
            "sattus"=>"200",
            "Message"=>"the Expert is reserved"
        ]);
    }
}