<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Contrey;
use App\Models\restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function getrestaurantforclient(){
        $allrestaurant=restaurant::query()->with(['contrey'])->get();
        if($allrestaurant->count()<=0){
            return response()->json([
                'data'=>[],
                'message'=>'no restaurant',
                'status'=>404,
            ]);
        }else{

            $formatedresponse=$allrestaurant->map(function($allrestaurant){
                return [
                    'id'=>$allrestaurant->id,
                    'RestaurantName'=>$allrestaurant->RestaurantName,
                    'location'=>$allrestaurant->location,
                    "PhoneOFRestaurant"=>$allrestaurant->PhoneOFRestaurant,
                    'description'=>$allrestaurant->description,
                    'photo' => url($allrestaurant->photo),
                    "food"=>$allrestaurant->food,
                    "service"=>$allrestaurant->service,
                    "comforts"=>$allrestaurant->comforts,
                    "safe"=>$allrestaurant->safe,
                    "Rate"=>$allrestaurant->Rate,
                    "opening_hours"=> $allrestaurant->opening_hours,
                    "closing_hours"=> $allrestaurant->closing_hours,
                    'contreyname'=>$allrestaurant->contrey->name,
                    'contreyphoto' => url($allrestaurant->contrey->photo),
                    'contreyRate'=>$allrestaurant->contrey->Rate,
                ];
            });



            return response()->json([
                'data'=>$formatedresponse,
                'message'=>'this is the restaurants in your app',
                'status'=>200,
            ]);
        }
    }


    public function SearchAboutRestaurant(Request $request){
        $request->validate([
            "nameOfCountrey"=>"required",
            "nameOfRestaurant"=>"required"
        ]);
         $idcountry=Contrey::query()->where('name',$request->nameOfCountrey)->first();
         if(!$idcountry){
            return response()->json([
                "data"=>[],
                'message'=>"not found any country realeted with this name",
                "status"=>404,
            ],404);
         }
        $restaurantsearch=restaurant::query()->where('Country_id',$idcountry->id)->where('RestaurantName',$request->nameOfRestaurant)->get();
        if($restaurantsearch->count()<=0){
            return response()->json([
                "data"=>[],
                'message'=>"not found any Restaurant with this name",
                "status"=>404,
            ],404);
        }

        $formatedresponse=$restaurantsearch->map(function($restaurantsearch){
            return [
                'id'=>$restaurantsearch->id,
                    'RestaurantName'=>$restaurantsearch->RestaurantName,
                    'location'=>$restaurantsearch->location,
                    "PhoneOFRestaurant"=>$restaurantsearch->PhoneOFRestaurant,
                    'description'=>$restaurantsearch->description,
                    'photo' => url($restaurantsearch->photo),
                    "food"=>$restaurantsearch->food,
                    "service"=>$restaurantsearch->service,
                    "comforts"=>$restaurantsearch->comforts,
                    "safe"=>$restaurantsearch->safe,
                    "Rate"=>$restaurantsearch->Rate,
                    "opening_hours"=> $restaurantsearch->opening_hours,
                    "closing_hours"=> $restaurantsearch->closing_hours,
                    'contreyname'=>$restaurantsearch->contrey->name,
                    'contreyphoto' => url($restaurantsearch->contrey->photo),
                    'contreyRate'=>$restaurantsearch->contrey->Rate,
            ];
        });

        return response()->json([
            "data"=>$formatedresponse,
            'message'=>'this the Restaurant with this search',
            "status"=>200,
        ]);
    }
}
