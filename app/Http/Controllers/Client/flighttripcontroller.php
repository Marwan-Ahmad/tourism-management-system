<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\FightCompany;
use App\Models\reserveTrip;
use App\Models\User;
use Illuminate\Http\Request;

class flighttripcontroller extends Controller
{
    //Reseve Tripe
    public function ResveFightTrip(Request $request){
        $request->validate([
            "fatherName"=>"required",
            "MotherName"=>"required",
            "Gendor"=>"required",
            "FlightClass"=>"required",
            "Wight"=>"required",
            "TripID"=>"required",
            "email"=>"required",
        ]);
        $User=User::where('email',$request->email)->first();
        if(!$User){
            return response()->json([
                "sattus"=>"200",
                "Message"=>"not found this email"
            ]);
        }
        $UserId=$User->id;

        $trip =new reserveTrip();
        $trip->users_id=$UserId;
        $trip->MotherName=$request->MotherName;
        $trip->fight_air_planes_id=$request->TripID;
        $trip->fatherName=$request->fatherName;
        $trip->Gendor=$request->Gendor;
        $trip->FlightClass=$request->FlightClass;
        $trip->Wight=$request->Wight;
        $trip->save();
        return response()->json([
            "sattus"=>"200",
            "Message"=>"the Trip is reserved"
        ]);
    }

    //Get Company With Trips
    public function getCompanyWithTrips(Request $request){
        $request->validate([
            "NameOfCompany"=>"required"
        ]);
        $CounterWithAirPlanes=new FightCompany();
        $CounterWithAirPlanes=FightCompany::with(['Trips'=>function($q){
            $q->select(['TripPlace','Towards','DayOfTheTrip'
            ,'MonthOfTheTrip','TimeOfTheTrip','fight_company_id','id','Price']);
        }])->where('name',$request->NameOfCompany)->select('name','id')->get();
        return response()->json([
            "sattus"=>"200",
            "company"=>$CounterWithAirPlanes
        ]);
    }
}
