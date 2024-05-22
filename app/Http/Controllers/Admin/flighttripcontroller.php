<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FightCompany;
use App\Models\Trip;
use Illuminate\Http\Request;

class flighttripcontroller extends Controller
{
    //To Input Flight Trip In The App
    public function InputFlightTrip(Request $request){
        $request->validate([
            "TripPlace"=>"required",
            "Towards"=>"required",
            "DayOfTheTrip"=>"required",
            "MonthOfTheTrip"=>"required",
            "TimeOfTheTrip"=>"required",
            "nameOfFlightCompany"=>"required",
            "locationOfFlightCompany"=>"required",
            "Price"=>"required",
        ]);
        $flightName=FightCompany::where('name',$request->nameOfFlightCompany)
        ->where('location',$request->locationOfFlightCompany)->first();

        if(!$flightName){
            return response()->json([
                "sattus"=>"200",
                "message"=>"the flight Company not found"
            ]);
        }
        $flight_id= $flightName->id;
        $Trip=new Trip();
        $Trip->TripPlace=$request->TripPlace;
        $Trip->Towards=$request->Towards;
        $Trip->DayOfTheTrip=$request->DayOfTheTrip;
        $Trip->MonthOfTheTrip=$request->MonthOfTheTrip;
        $Trip->TimeOfTheTrip=$request->TimeOfTheTrip;
        $Trip->Price=$request->Price;
        $Trip->fight_company_id=$flight_id;
        $Trip->save();
        return response()->json([
            "sattus"=>"200",
            "message"=>"The Trip is saved"
        ]);
    }

    //To Drop a Trip
    public function DropFlightTrip(Request $request){
        $request->validate([
            "TripPlace"=>"required",
            "Towards"=>"required"
        ]);
        $Trip=Trip::where('TripPlace', $request->TripPlace)->
        where('Towards', $request->Towards)->first();
        if(!$Trip){
            return response()->json([
                "sattus"=>"200",
                "message"=>"the Trip not found"
            ]);
        }
        Trip::where('TripPlace', $request->TripPlace)->
        where('Towards', $request->Towards)->delete();
        return response()->json([
            "sattus"=>"200",
            "message"=>"the Trip is deleted"
        ]);

    }
    //To Update A Trip
    public function UpdateFlightTrip(Request $request){
        $request->validate([
            "OldTripPlace"=>"required",
            "OldTowards"=>"required",
            "NewTripPlace"=>"required",
            "NewTowards"=>"required",
            "DayOfTheTrip"=>"required",
            "MonthOfTheTrip"=>"required",
            "TimeOfTheTrip"=>"required",
            "Price"=>"required"
        ]);
        $Trip=Trip::where('TripPlace', $request->OldTripPlace)->
        where('Towards', $request->OldTowards)->first();
        if(!$Trip){
            return response()->json([
                "status"=>"200",
                "messgae"=>"the Trip not found"
            ]);
        }
        $Trip->update([
            'TripPlace'=>$request->NewTripPlace,
            'Towards'=>$request->NewTowards,
            'DayOfTheTrip'=>$request->DayOfTheTrip,
            'MonthOfTheTrip'=>$request->MonthOfTheTrip,
            'Price'=>$request->Price,
            'TimeOfTheTrip'=>$request->TimeOfTheTrip,
        ]);
        return response()->json([
            "status"=>"200",
            "messgae"=>"the Trip is updated"
        ]);
    }
}