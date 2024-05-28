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
                        'status'=>404,
                    ],404);
                }
            }


    //To Input Flight Trip In The App
    public function InputFlightTrip(Request $request){
        $request->validate([
            "TripPlace"=>"required",
            "Towards"=>"required",
            "TimeTrip"=>"required",
            "Price"=>"required",
            "nameOfFlightCompany"=>"required",
            "locationOfFlightCompany"=>"required",
        ]);
        $flightName=FightCompany::where('name',$request->nameOfFlightCompany)
        ->where('location',$request->locationOfFlightCompany)->first();
        $country_id=Contrey::query()->where('name',$request->Towards)->first();

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
        $Trip=new Trip();
        $Trip->TripPlace=$request->TripPlace;
        $Trip->Towards=$request->Towards;
        $Trip->TimeTrip=$request->TimeTrip;
        $Trip->Price=$request->Price;
        $Trip->fight_company_id=$flight_id;
        $Trip->country_id=$country_id->id;
        $Trip->save();
            $getTrip=Trip::query()
            ->where('TripPlace',$request->TripPlace)
            ->where('Towards',$request->Towards)
            ->where('TimeTrip',$request->TimeTrip)
            ->where('Price',$request->Price)->where('fight_company_id',$flight_id)
            ->with(['country:id,name,Rate'])
            ->first();
        return response()->json([
            'data'=>$getTrip,
            "message"=>"Trip Added Successfyly",
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
            "Price"=>"nullable"
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