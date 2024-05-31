<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Contrey;
use App\Models\FightCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class airplanecontroller extends Controller
{
    //Get Country With AirPlane
    public function GetAirPlanesCompany(){

        $CounterWithAirPlanes=new Contrey();
        $CounterWithAirPlanes=FightCompany::query()->get();

        $CounterWithAirPlanes->each(function ($item) {
            $item->photo = url($item->photo);
        });
        if(FightCompany::query()->count()>0){
        return response()->json([
            "data"=>$CounterWithAirPlanes,
            'message'=>'there are the company',
            "sattus"=>200,
        ]);
      }else{
        return response()->json([
            "data"=>[],
            'message'=>'not found any compamy',
            "sattus"=>404,
        ]);
      }
    }

    //Search About AirPlane
    public function SearchAboutAirPlaneCompany(Request $request){
        $request->validate([
            "nameOfCompany"=>"required",
            //"nameOfCountry"=>"required",
        ]);
        $CounterWithAirPlanes=FightCompany::query()->where('name',$request->nameOfCompany)->first();
        if(!$CounterWithAirPlanes){
            return response()->json([
                "data"=>[],
                'message'=>'not found',
                "sattus"=>404,
            ],404);
        }
        $CounterWithAirPlanes->photo = url($CounterWithAirPlanes->photo);
        return response()->json([
            "data"=>$CounterWithAirPlanes,
            'message'=>'this is the company with your search',
            "sattus"=>200,
        ]);
    }
}

//Get Description for Air Plane
    // public function GetDescrrptionrAirPlanes(){
    //     $CounterWithAirPlanes=new Contrey();
    //     $CounterWithAirPlanes=Contrey::with(['Airplanescompany'])->get();
    //     return response()->json([
    //         "sattus"=>"200",
    //         "Countries"=>$CounterWithAirPlanes
    //     ]);
    // }

    //Service of Air Plane
    // public function ServiceOfCompnayAirplane(Request $request){
    //     $request->validate([
    //         "IdOfCompany"=>"required"
    //     ]);
    //     $service=FightCompany::where('id',$request->IdOfCompany)->Select('food','service',
    //     'Comforts','safe')->first();
    //     if(!$service){
    //         return response()->json([
    //             "sattus"=>"200",
    //             "Message"=>"not found any Company with this id"
    //         ]);
    //     }
    //     return response()->json([
    //         "sattus"=>"200",
    //         "Service"=>$service
    //     ]);
    // }