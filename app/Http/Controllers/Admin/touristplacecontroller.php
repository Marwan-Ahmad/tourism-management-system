<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contrey;
use App\Models\touristPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class touristplacecontroller extends Controller
{
    //To Input TouristPLace
    public function inputInoformationTouirstPlace(Request $request){
        $request->validate([
            'name'=>"required",
            'location'=>"required",
            'description'=>"required",
            'photo'=>"required",
            'BestTime'=>"required",
            'uniqueStuff'=>"required",
            'service'=>"required",
            'comforts'=>"required",
            'safe'=>"required",
            'food'=>"required",
            'Rate'=>"required",
            'CountryName'=>"required",
        ]);
        $photo = $request->file('photo');
        $fileName = uniqid().'.'. $photo->getClientOriginalExtension();
        Storage::disk('public')->put($fileName, file_get_contents( $photo));
        $photo=Storage::url($fileName);

        $contry=Contrey::where('name',$request->CountryName)->first();

        if(!$contry){
            return response()->json([
                "status"=>"200",
                "message"=>"the country not found please check the name of country "
        ]);
        $contry_id=$contry->id;

        }
        $TouristPlace=new touristPlace();
        $TouristPlace->name=$request->name;
        $TouristPlace->location=$request->location;
        $TouristPlace->description=$request->description;
        $TouristPlace->photo= $photo;
        $TouristPlace->BestTime=$request->BestTime;
        $TouristPlace->uniqueStuff=$request->uniqueStuff;
        $TouristPlace->service=$request->service;
        $TouristPlace->comforts=$request->comforts;
        $TouristPlace->safe=$request->safe;
        $TouristPlace->food=$request->food;
        $TouristPlace->Rate=$request->Rate;
        $TouristPlace->Country_id=$contry->id;
        $TouristPlace->save();
        return response()->json([
            "status"=>"200",
            "message"=>"the information of Tourist Place saved and "
        ]);
    }

    //To Delete TouristPlace
    public function DropTouirstPlace(Request $request){
        $request->validate([
            "IdOfTouristPlace"=>"required"
        ]);
        $TouristPalce=touristPlace::where('id',$request->IdOfTouristPlace)->first();
        if(!$TouristPalce){
            return response()->json([
                "status"=>"200",
                "messgae"=>"the Tourist Place not found "
            ]);}
            touristPlace::where('id',$request->IdOfTouristPlace)->delete();
        return response()->json([
            "status"=>"200",
            "messgae"=>"the ToristPlace is deleted"
        ]);
    }

    //To Update Tourist Place
    public function UpdateInoformationTouirstPlace(Request $request){
        $request->validate([
            "idOfTouristPlace",
            'name'=>"required",
            'location'=>"required",
            'description'=>"required",
            // 'photo'=>"required",
            'BestTime'=>"required",
            'uniqueStuff'=>"required",
            'service'=>"required",
            'comforts'=>"required",
            'safe'=>"required",
            'food'=>"required",
            'Rate'=>"required",
            'CountryName'=>"required",
        ]);
        // $photo = $request->file('photo');
        // $fileName = uniqid().'.'. $photo->getClientOriginalExtension();
        // Storage::disk('public')->put($fileName, file_get_contents( $photo));
        // $photo=Storage::url($fileName);

        $contry=Contrey::where('name',$request->CountryName)->first();

        if(!$contry){
            return response()->json([
                "status"=>"200",
                "message"=>"the country not found please check the name of country "
        ]);
        }
        $contry_id=$contry->id;

        touristPlace::where('id',$request->idOfTouristPlace)->update([
            'name'=>$request->name,
            'location'=>$request->location,
            'description'=>$request->description,
        //    'photo'=> $photo,
            'BestTime'=>$request->BestTime,
            'uniqueStuff'=>$request->uniqueStuff,
            'service'=>$request->service,
           'comforts'=>$request->comforts,
           'safe'=>$request->safe,
            'food'=>$request->food,
            'Rate'=>$request->Rate,
           'Country_id'=>$contry->id,
        ]);
        return response()->json([
            "status"=>"200",
            "message"=>"the information of Tourist Place Udpated "
        ]);
    }
}