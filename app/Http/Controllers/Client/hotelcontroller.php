<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Contrey;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class hotelcontroller extends Controller
{
    //Search about Hotel
    public function SearchAboutHotel(Request $request){
        $request->validate([
            "nameOfCountrey"=>"required",
            "nameOfHotel"=>"required"
        ]);
         $nameOfHotel=$request->nameOfHotel;
        $CounterWithHotels=Contrey::with(['Hotels'=>function($q)use($nameOfHotel){
            $q->select(['id','name','location','description','Basicphoto','Roomphoto1','Roomphoto2'
            ,'Roomphoto3' ,'Country_id','food','service',
            'Comforts','safe','Rate',])
            ->where('name',$nameOfHotel);}])->where("name",$request->nameOfCountrey)->select('name','id')->first();
        if(!$CounterWithHotels){
            return response()->json([
                "status"=>"200",
                "data"=>"not found any Company with this name"
            ]);
        }

        return response()->json([
            "status"=>"200",
            "data"=>$CounterWithHotels
        ]);
    }

    //Return Country With Hotel
    public function ReturnCountreyWithHotel(Request $request){
        $request->validate([
            "NameOfCountry"=>'required'
        ]);
        $CounterWithHotels=new Contrey();
        $CounterWithHotels=Contrey::with(['Hotels'=>function($q){
            $q->select(['id','name','location','description','Roomphoto2','Roomphoto3'
            ,'food','service','safe','comforts','Rate','Basicphoto','Roomphoto1','Country_id']);
        }])->where('name',$request->NameOfCountry)->get();
        if(! $CounterWithHotels){
            return response()->json([
                "sattus"=>"200",
                "Message"=>"the Hotel not found",
            ]);
        }
        // $Services=Contrey::with(['Airplanes'=>function($q){
        //     $q->select(['food','service','Comforts','safe','id','Country_id']);
        // }])->where('name',$request->NameOfCountry)->get();
        // $CounterWithAirPlanes.= $Services;
        return response()->json([
            "sattus"=>"200",
            "Countries"=>$CounterWithHotels,
        ]);
    }

    //Reserve RooM
    public function ReserveRoom(Request $request){
        $request->validate([
            'FatherName'=>"required",
            'MotherName'=>"required",
            'Gendor'=>"required",
            'NumberOfPeople'=>"required",
            'NumberOfRoom'=>"required",
            'TypeRoom'=>"required",
            'Meal'=>"required",
            'FirstDay'=>"required",
            'LastDay'=>"required",
            'hotel_id'=>"required",
            'email'=>"required",
        ]);
        $User=User::where('email',$request->email)->first();
        if(!$User){
            return response()->json([
                "sattus"=>"200",
                "Message"=>"not found this email"
            ]);
        }
        $UserId=$User->id;
        $Room=new Room();
        $Room-> FatherName=$request->FatherName;
        $Room-> MotherName=$request->MotherName;
        $Room-> Gendor=$request->Gendor;
        $Room-> NumberOfPeople=$request->NumberOfPeople;
        $Room-> NumberOfRoom=$request->NumberOfRoom;
        $Room-> TypeRoom=$request->TypeRoom;
        $Room-> Meal=$request->Meal;
        $Room-> FirstDay=$request->FirstDay;
        $Room-> LastDay=$request->LastDay;
        $Room-> hotel_id=$request->hotel_id;
        $Room-> users_id=$UserId;
        $Room->save();
        return response()->json([
            "sattus"=>"200",
            "Message"=>"the Room is reserved"
        ]);
    }
}