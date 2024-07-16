<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contrey;
use App\Models\restaurant;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{

    public function getrestaurant(){
        $getrestaurant=restaurant::query()->with(['contrey'])->get();

        if($getrestaurant->count() <= 0){
            return response()->json([
                'data'=>[],
                'message'=>'Not Found Any Restaurant',
                'status'=>200
            ]);
        }

        return response()->json([
            'data'=>$getrestaurant,
            'message'=>'This IS The Restaurant In Our App',
            'status'=>200
        ]);
    }

public function inputrestaurant(Request $request){

    $request->validate([
        'RestaurantName'=>'required',
        'location'=>'required',
        'nameOfCountry'=>'required',
    	'PhoneOFRestaurant'=>'required',
      	'description'=>'required',
        'food'=>'required',
        'service'=>'required',
        'comforts'=>'required',
        'safe'=>'required',
        'Rate'=>'required',
        'opening_hours'=>'required',
        'closing_hours'=>'required',
        'photo'=>'required'
    ]);

    $photo = $request->file('photo');
    $fileName = uniqid().'.'.$photo->getClientOriginalExtension();
    Storage::disk('public')->put($fileName, file_get_contents($photo));
    $photo=Storage::url($fileName);

    $contry=Contrey::query()->where('name',$request->nameOfCountry)->first();


    if(!$contry){
        return response()->json([
            'data'=>[],
            "message"=>"the country not found please check the name of country",
            "status"=>404,
      ],404);
    }

    $existrestaurant=restaurant::query()
    ->where('RestaurantName',$request->RestaurantName)
    ->where('location',$request->location)
    ->where('Country_id',$contry->id)
    ->first();

    if($existrestaurant){
        return response()->json([
            'data'=>[],
            'message'=>'the restaurant exist before',
            'status'=>429,
        ]);
    }

    $inputrestaurant=restaurant::query()->create([
        'RestaurantName'=>$request->RestaurantName,
        'location'=>$request->location,
    	'PhoneOFRestaurant'=>$request->PhoneOFRestaurant,
      	'description'=>$request->description,
        'food'=>$request->food,
        'service'=>$request->service,
        'comforts'=>$request->comforts,
        'safe'=>$request->safe,
        'Rate'=>$request->Rate,
        'opening_hours'=>$request->opening_hours,
        'closing_hours'=>$request->closing_hours,
        'photo'=>$photo,
        'Country_id'=>$contry->id,
    ]);

    return response()->json([
        'data'=>$inputrestaurant,
        'messaage'=>'You Insert The Restaurant',
        'status'=>200
    ]);
}

public function deleterestaurant(Request $request){
    $request->validate([
        'idrestaurant'=>'required',
    ]);

    $restaurantexist=restaurant::query()->where('id',$request->idrestaurant)->first();
    if(!$restaurantexist){
        return response()->json([
            'data'=>[],
            "messgae"=>"the Restaurant not found",
            "status"=>404,
        ],404);
    }
    $oldPhotoPathbasic = str_replace('/storage', '', $restaurantexist->photo);
        if (Storage::disk('public')->exists($oldPhotoPathbasic)) {
            Storage::disk('public')->delete($oldPhotoPathbasic);
        }

        restaurant::query()->where('id',$request->idrestaurant)->delete();

        return response()->json([
            'data'=>$restaurantexist,
            "messgae"=>"the Restaurant is deleted",
            "status"=>200,
        ]);
}

public function restaurantupdate(Request $request){
    $request->validate([
        "idrestaurant"=>"required",
        'RestaurantName'=>'nullable',
        'location'=>'nullable',
        'nameOfCountry'=>'nullable',
    	'PhoneOFRestaurant'=>'nullable',
      	'description'=>'nullable',
        'food'=>'nullable',
        'service'=>'nullable',
        'comforts'=>'nullable',
        'safe'=>'nullable',
        'Rate'=>'nullable',
        'opening_hours'=>'nullable',
        'closing_hours'=>'nullable',
        'photo'=>'nullable'
    ]);

    $restaurantexist=restaurant::query()->where('id',$request->idrestaurant)->first();
    if(!$restaurantexist){
        return response()->json([
            'data'=>[],
            "messgae"=>"the Restaurant not found ",
            "status"=>404,
        ],404);
    }

    $countryinfo=Contrey::query()->where('id',$restaurantexist->Country_id)->first();
        $contry_id=Contrey::query()->where('name',$request->nameOfCountry??$countryinfo->name)->first();

        if(!$contry_id){
            return response()->json([
                'data'=>[],
                "message"=>"the country not found",
                "status"=>404,
          ],404);
        }

        $restaurantisexist=restaurant::query()->where('RestaurantName',$request->RestaurantName)
        ->where('location',$request->location)
        ->where('Country_id',$contry_id->id)
        ->first();
        if($restaurantisexist){
            return response()->json([
                'data'=>[],
                "message"=>"the Restaurant is exist before at the same place",
                "status"=>429,
          ],429);
        }

        if ($request->hasFile('photo')) {
            $oldPhotoPathbasic = str_replace('/storage', '', $restaurantexist->photo);
            if (Storage::disk('public')->exists($oldPhotoPathbasic)) {
                Storage::disk('public')->delete($oldPhotoPathbasic);
            }

            $image = $request->file('photo');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk('public')->put($fileName, file_get_contents($image));
            $photoPathbsic = Storage::url($fileName);
        } else {

            $photoPathbsic = $restaurantexist->photo;
        }

        restaurant::query()->where('id',$request->idrestaurant)
        ->update([
            'RestaurantName'=>$request->RestaurantName??$restaurantexist->RestaurantName,
            'location'=>$request->location??$restaurantexist->location,
            'PhoneOFRestaurant'=>$request->PhoneOFRestaurant??$restaurantexist->PhoneOFRestaurant,
            'description'=>$request->description??$restaurantexist->description,
            'food'=>$request->food??$restaurantexist->food,
            'service'=>$request->service??$restaurantexist->service,
            'comforts'=>$request->comforts??$restaurantexist->comforts,
            'safe'=>$request->safe??$restaurantexist->safe,
            'Rate'=>$request->Rate??$restaurantexist->Rate,
            'opening_hours'=>$request->opening_hours??$restaurantexist->opening_hours,
            'closing_hours'=>$request->closing_hours??$restaurantexist->closing_hours,
            'photo'=>$photoPathbsic,
            'Country_id'=>$contry_id->id??$countryinfo->id
        ]);

        $restaurantinfo=restaurant::query()->where('id',$request->idrestaurant)->first();

        return response()->json([
            'data'=>$restaurantinfo,
            'message'=>'The Information Of Restaurant is Updated',
            'status'=>200
        ]);


    }
}
