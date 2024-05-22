<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Contrey;
use Illuminate\Http\Request;

class touristplacecontroller extends Controller
{
    //Get Country With Tourist Place
    public function getcountreyWithTourirstPlace(Request $request){
        $request->validate([
            "NameOfCountry"=>'required'
        ]);
        $CounterWithTouristPlaces=new Contrey();
        $CounterWithTouristPlaces=Contrey::with(['TouristPlaces'=>function($q){
            $q->select(['id','name','location','description','photo','BestTime','uniqueStuff'
            ,'service','comforts','safe','food','Rate','Country_id']);
        }])->where('name',$request->NameOfCountry)->get();
        if(! $CounterWithTouristPlaces){
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
            "Countries"=>$CounterWithTouristPlaces,
        ]);
    }

    //Search About Tourist Place
    public function SearchAboutTouristPlace(Request $request){
        $request->validate([
            "nameOfCountrey"=>"required",
            "nameOfToriustPlace"=>"required"
        ]);

         $nameOfToriustPlace=$request->nameOfToriustPlace;
        $CounterWithTouristPlace=Contrey::with(['TouristPlaces'=>function($q)use($nameOfToriustPlace){
            $q->select(['id','name','location','description','photo','BestTime','uniqueStuff'
            ,'service','comforts','safe','food','Rate','Country_id'])
            ->where('name',$nameOfToriustPlace);}])->where("name",$request->nameOfCountrey)->select('name','id')->first();
        if(!$CounterWithTouristPlace){
            return response()->json([
                "status"=>"200",
                "data"=>"not found any Tourist Place with this name in this country"
            ]);
        }

        return response()->json([
            "status"=>"200",
            "data"=>$CounterWithTouristPlace
        ]);
    }
}