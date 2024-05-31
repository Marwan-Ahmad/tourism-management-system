<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contrey;
use App\Models\FightCompany;
use App\Models\Trip;
use Illuminate\Http\Request;

class flighttripcontroller extends Controller
{


    public function gettrip(){
             $trip=Trip::query()->with(['country:id,name,Rate','company:id,name,Rate'])->get();
                if($trip->count()>0){
                    return response()->json([
                        'data'=>$trip,
                        'message'=>'this the trip in your app',
                        'status'=>200,
                    ],200);
                }else{
                    return response()->json([
                        'data'=>[],
                        'message'=>'not found any trip',
                        'status'=>200,
                    ],200);
                }
            }


    //To Input Flight Trip In The App
    public function InputFlightTrip(Request $request){
        $request->validate([
            "TripPlace"=>"required",
            "CountryIdTowards"=>"required",
            "TimeTrip"=>"required",
            "Price"=>"required",
            'amountpeople'=>'required',
            'IdCompany'=>'required'
        ]);
        $flightName=FightCompany::where('id',$request->IdCompany)
        ->first();
        $country_id=Contrey::query()->where('id',$request->CountryIdTowards)->first();

        if(!$flightName){
            return response()->json([
                'data'=>[],
                "message"=>"the Flight Company Not Found",
                "status"=>404,
            ]);
        }

        if(!$country_id){
            return response()->json([
                'data'=>[],
                "message"=>"the country Not Found",
                "status"=>404,
            ]);
        }

            $flight_id= $flightName->id;
            //This is for dounlicate the trip in the app
            $doubletrip=Trip::query()->where('TripPlace',$request->TripPlace)
            ->where('Towards',$country_id->name)
            ->where('TimeTrip',$request->TimeTrip)
            ->where('fight_company_id',$flight_id)
            ->where('Price',$request->Price)
            ->where('country_id',$country_id->id)->first();
            if($doubletrip){
                $doubletrip->amountpeople=$doubletrip->amountpeople + $request->amountpeople;
                $doubletrip->update([
                    'amountpeople'=>$doubletrip->amountpeople
                ]);
                return response()->json([
                    'data'=>$doubletrip,
                    "message"=>"The Trip is already exist the amountpeople change to $doubletrip->amountpeople",
                    "status"=>200,
                ]);
            }

        $Trip=new Trip();
        $Trip->TripPlace=$request->TripPlace;
        $Trip->Towards=$country_id->name;
        $Trip->TimeTrip=$request->TimeTrip;
        $Trip->Price=$request->Price;
        $Trip->amountpeople=$request->amountpeople;
        $Trip->fight_company_id=$flight_id;
        $Trip->country_id=$country_id->id;
        $Trip->save();

            $getTrip=Trip::query()
            ->where('TripPlace',$request->TripPlace)
            ->where('Towards',$country_id->name)
            ->where('TimeTrip',$request->TimeTrip)
            ->where('Price',$request->Price)->where('fight_company_id',$flight_id)
            ->with(['country:id,name,Rate'])
            ->first();
        return response()->json([
            'data'=>$getTrip,
            "message"=>"Trip Added Successfly",
            "status"=>201,
        ]);
    }

    //To Drop a Trip
    public function DropFlightTrip(Request $request){
        $request->validate([
           'id'=>'nullable'
        ]);
        $Trip=Trip::query()->where('id', $request->id)->with(['country:id,name,Rate'])
        ->first();
        if(!$Trip){
            return response()->json([
                'data'=>[],
                "message"=>"The Trip Not Found",
                "status"=>404,
            ]);
        }
        Trip::where('id', $request->id)->delete();
        return response()->json([
            'data'=> $Trip,
            "message"=>"the Trip Deleted Successfuly",
            "status"=>200,
        ]);

    }
    //To Update A Trip
    public function UpdateFlightTrip(Request $request){
        $request->validate([
            'id'=>'nullable',
            "NewTripPlace"=>"nullable",
            "NewTowards"=>"nullable",
            "TimeTrip"=>"nullable",
            "Price"=>"nullable",
            "amountpeople"=>"nullable",

        ]);
        $Trip=Trip::where('id', $request->id)->with(['country:id,name,Rate'])->first();
        if(!$Trip){
            return response()->json([
                'data'=>[],
                "message"=>"The Trip Not Found",
                "status"=>404,
            ]);
        }

            $country_id=Contrey::query()->where('name',$request->NewTowards??$Trip->Towards)->first();

            if(!$country_id){
                return response()->json([
                    'data'=>[],
                    "message"=>"The country you added the trip in it Not Found",
                    "status"=>404,
                ]);
            }


        $Trip->update([
            'TripPlace'=>$request->NewTripPlace??$Trip->TripPlace,
            'Towards'=>$request->NewTowards??$Trip->Towards,
            "TimeTrip"=>$request->TimeTrip??$Trip->TimeTrip,
            "amountpeople"=>$request->amountpeople??$Trip->amountpeople,
            'Price'=>$request->Price??$Trip->Price,
            'country_id'=>$country_id->id
        ]);

        return response()->json([
            'data'=> $Trip,
            "message"=>"the Trip Updated Successfuly",
            "status"=>200,
        ]);
    }
}
