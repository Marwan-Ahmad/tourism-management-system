<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Contrey;
use App\Models\FightCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class airplanecontroller extends Controller
{
    //Get COuntry With AirPlane
    public function GetCounterWithAirPlanes(Request $request){
        $request->validate([
            "NameOfCountry"=>'required'
        ]);
        $CounterWithAirPlanes=new Contrey();
        $CounterWithAirPlanes=Contrey::with(['Airplanes'=>function($q){
            $q->select(['name','location','description','photo','Rate','id'
            ,'Country_id','food','service','Comforts','safe','id','Country_id']);
        }])->where('name',$request->NameOfCountry)->get();
        $Services=Contrey::with(['Airplanes'=>function($q){
            $q->select(['food','service','Comforts','safe','id','Country_id']);
        }])->where('name',$request->NameOfCountry)->get();
        // $CounterWithAirPlanes.= $Services;
        return response()->json([
            "sattus"=>"200",
            "Countries"=>$CounterWithAirPlanes,
        ]);
    }

    //Search About AirPlane
    public function SearchAboutAirPlaneCompany(Request $request){
        $request->validate([
            "nameOfCountrey"=>"required",
            "nameOfCompany"=>"required"
        ]);
         $nameOfCompany=$request->nameOfCompany;
        $CounterWithAirPlanes=Contrey::with(['Airplanes'=>function($q)use($nameOfCompany){
            $q->select(['name','location','description','photo','Country_id','food','service',
            'Comforts','safe','Rate'])
            ->where('name',$nameOfCompany);}])->where("name",$request->nameOfCountrey)->first();
        if(!$CounterWithAirPlanes){
            return response()->json([
                "status"=>"200",
                "data"=>"not found any Company with this name"
            ]);
        }

        return response()->json([
            "status"=>"200",
            "data"=>$CounterWithAirPlanes
        ]);
    }

    //Get Description for Air Plane
    public function GetDescrrptionrAirPlanes(){

        $CounterWithAirPlanes=new Contrey();
        $CounterWithAirPlanes=Contrey::with(['Airplanes'])->get();
        return response()->json([
            "sattus"=>"200",
            "Countries"=>$CounterWithAirPlanes
        ]);
    }

    //Service of Air Plane
    public function ServiceOfCompnayAirplane(Request $request){
        $request->validate([
            "IdOfCompany"=>"required"
        ]);
        $service=FightCompany::where('id',$request->IdOfCompany)->Select('food','service',
        'Comforts','safe')->first();
        if(!$service){
            return response()->json([
                "sattus"=>"200",
                "Message"=>"not found any Company with this id"
            ]);
        }
        return response()->json([
            "sattus"=>"200",
            "Service"=>$service
        ]);
    }

}