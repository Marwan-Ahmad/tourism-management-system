<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Contrey;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class hotelcontroller extends Controller
{

    public function gethotelsforclient(){
        $allhotels=Hotel::query()->with(['contrey'])->get();
        if($allhotels->count()<=0){
            return response()->json([
                'data'=>[],
                'message'=>'no hotels',
                'status'=>404,
            ]);
        }else{

            $formatedresponse=$allhotels->map(function($allhotels){
                return [
                    'id'=>$allhotels->id,
                    'name'=>$allhotels->name,
                    'location'=>$allhotels->location,
                    'description'=>$allhotels->description,
                    'Basicphoto' => url($allhotels->Basicphoto),
                    "Roomphoto1" => url($allhotels->Roomphoto1),
                    "Roomphoto2" => url($allhotels->Roomphoto2),
                    "Roomphoto3" => url($allhotels->Roomphoto3),
                    "food"=>$allhotels->food,
                    "service"=>$allhotels->service,
                    "comforts"=>$allhotels->comforts,
                    "safe"=>$allhotels->safe,
                    "Rate"=>$allhotels->Rate,
                   // 'contreyid'=>$allhotels->contrey->id,
                    'contreyname'=>$allhotels->contrey->name,
                    'contreyphoto' => url($allhotels->contrey->photo),
                    'contreyRate'=>$allhotels->contrey->Rate,
                ];
            });



            return response()->json([
                'data'=>$formatedresponse,
                'message'=>'this is the hotels in your app',
                'status'=>200,
            ]);
        }

    }
    //Search about Hotel
    public function SearchAboutHotel(Request $request){
        $request->validate([
            "nameOfCountrey"=>"required",
            "nameOfHotel"=>"required"
        ]);
         $idcountry=Contrey::query()->where('name',$request->nameOfCountrey)->first();
         if(!$idcountry){
            return response()->json([
                "data"=>[],
                'message'=>"not found any country realeted with this name",
                "status"=>404,
            ],404);
         }
        $hotelsearch=Hotel::query()->where('Country_id',$idcountry->id)->where('name',$request->nameOfHotel)->get();
        if($hotelsearch->count()<=0){
            return response()->json([
                "data"=>[],
                'message'=>"not found any hotel with this name",
                "status"=>404,
            ],404);
        }

        $formatedresponse=$hotelsearch->map(function($hotelsearch){
            return [
                'id'=>$hotelsearch->id,
                'name'=>$hotelsearch->name,
                'location'=>$hotelsearch->location,
                'description'=>$hotelsearch->description,
                'Basicphoto' => url($hotelsearch->Basicphoto),
                "Roomphoto1" => url($hotelsearch->Roomphoto1),
                "Roomphoto2" => url($hotelsearch->Roomphoto2),
                "Roomphoto3" => url($hotelsearch->Roomphoto3),
                "food"=>$hotelsearch->food,
                "service"=>$hotelsearch->service,
                "comforts"=>$hotelsearch->comforts,
                "safe"=>$hotelsearch->safe,
                "Rate"=>$hotelsearch->Rate,
               // 'contreyid'=>$allhotels->contrey->id,
                'contreyname'=>$hotelsearch->contrey->name,
                'contreyphoto' => url($hotelsearch->contrey->photo),
                'contreyRate'=>$hotelsearch->contrey->Rate,
            ];
        });

        return response()->json([
            "data"=>$formatedresponse,
            'message'=>'this the hotel with this search',
            "status"=>200,
        ]);
    }

    //Return Country With Hotel
    // public function ReturnCountreyWithHotel(Request $request){
    //     $request->validate([
    //         "NameOfCountry"=>'required'
    //     ]);
    //     $CounterWithHotels=new Contrey();
    //     $CounterWithHotels=Contrey::with(['Hotels'=>function($q){
    //         $q->select(['id','name','location','description','Roomphoto2','Roomphoto3'
    //         ,'food','service','safe','comforts','Rate','Basicphoto','Roomphoto1','Country_id']);
    //     }])->where('name',$request->NameOfCountry)->get();
    //     if(! $CounterWithHotels){
    //         return response()->json([
    //             "sattus"=>"200",
    //             "Message"=>"the Hotel not found",
    //         ]);
    //     }
    //     // $Services=Contrey::with(['Airplanes'=>function($q){
    //     //     $q->select(['food','service','Comforts','safe','id','Country_id']);
    //     // }])->where('name',$request->NameOfCountry)->get();
    //     // $CounterWithAirPlanes.= $Services;
    //     return response()->json([
    //         "sattus"=>"200",
    //         "Countries"=>$CounterWithHotels,
    //     ]);
    // }

    //Reserve RooM
    // public function ReserveRoom(Request $request){
    //     $request->validate([
    //         'FatherName'=>"required",
    //         'MotherName'=>"required",
    //         'Gendor'=>"required",
    //         'NumberOfPeople'=>"required",
    //         'NumberOfRoom'=>"required",
    //         'TypeRoom'=>"required",
    //         'Meal'=>"required",
    //         'FirstDay'=>"required",
    //         'LastDay'=>"required",
    //         'hotel_id'=>"required",
    //         'email'=>"required",
    //     ]);
    //     $User=User::where('email',$request->email)->first();
    //     if(!$User){
    //         return response()->json([
    //             "sattus"=>"200",
    //             "Message"=>"not found this email"
    //         ]);
    //     }
    //     $UserId=$User->id;
    //     $Room=new Room();
    //     $Room-> FatherName=$request->FatherName;
    //     $Room-> MotherName=$request->MotherName;
    //     $Room-> Gendor=$request->Gendor;
    //     $Room-> NumberOfPeople=$request->NumberOfPeople;
    //     $Room-> NumberOfRoom=$request->NumberOfRoom;
    //     $Room-> TypeRoom=$request->TypeRoom;
    //     $Room-> Meal=$request->Meal;
    //     $Room-> FirstDay=$request->FirstDay;
    //     $Room-> LastDay=$request->LastDay;
    //     $Room-> hotel_id=$request->hotel_id;
    //     $Room-> users_id=$UserId;
    //     $Room->save();
    //     return response()->json([
    //         "sattus"=>"200",
    //         "Message"=>"the Room is reserved"
    //     ]);
    // }
}