<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contrey;
use App\Models\FightCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class airplanecontroller extends Controller
{
     // To Input AirPlaneCompany
     public function InputAirPlaneCompany(Request $request){

            $request->validate([
                "name"=>"required",
                "location"=>"required",
                "description"=>"required",
                "Comforts"=>"required",
                "photo"=>"required",
                "food"=>"required",
                "safe"=>"required",
                "Rate"=>"required",
                "service"=>"required",
                "nameOfCountry"=>"required",
            ]);

            $image = $request->file('photo');
            $fileName = uniqid().'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put($fileName, file_get_contents($image));


            $countrynotexists=Contrey::where('name',$request->nameOfCountry)->count();
            if($countrynotexists==0){
                return response()->json([
                    'data'=>[],
                    "message"=>"the country you insert the air plane company in it you don't have it in your app",
                    "status"=>404,
                ]);
            }


            $contryid=Contrey::where('name',$request->nameOfCountry)->first();
             $count = FightCompany::query()
             ->where('name', $request->name)
             ->where('Country_id', $contryid->id)
             ->where('location',$request->location)
             ->count();
                if ($count >=1) {
                    return response()->json([
                        'data'=>[],
                        "message"=>"you have this company in this country in the same location you cannot add it twice",
                        "status"=>404,
                    ]);
                }



            $contry=Contrey::where('name',$request->nameOfCountry)->first();
            $contry_id=$contry->id;
            $CompanyInformation=new FightCompany();
            $CompanyInformation->name=$request->name;
            $CompanyInformation->location=$request->location;
            $CompanyInformation->description=$request->description;
            $CompanyInformation->Comforts=$request->Comforts;
            $CompanyInformation->food=$request->food;
            $CompanyInformation->safe=$request->safe;
            $CompanyInformation->Rate=$request->Rate;
            $CompanyInformation->service=$request->service;
            $CompanyInformation->photo=Storage::url($fileName);
            $CompanyInformation->Country_id= $contry_id;
            $CompanyInformation->save();

        return response()->json([
            'data'=>$CompanyInformation,
            "message"=>"The Company Added Successfuly",
            "status"=>201,
        ]);
    }
    // TO Delete The AirPlaneCompany
    public function DropAirplaneCompany(Request $request){
        $request->validate([
            "nameOfAirPlaneCompany"=>'required',
            'countryname'=>'required',
            "Location"=>"required"
        ]);
        $contry=Contrey::where('name',$request->countryname)->first();
        $countryid=$contry->id;
        $AirplaneCompnay=FightCompany::query()
        ->where('name',$request->nameOfAirPlaneCompany)
        ->where('Country_id',$countryid)
        ->where('location',$request->Location)
        ->first();

        if(!$AirplaneCompnay){
            return response()->json([
                'data'=>[],
                "messgae"=>"This Company not found in our app to delete it",
                "status"=>404,
            ]);
        }

        else{
        FightCompany::where('name',$request->nameOfAirPlaneCompany)
        ->where('Country_id',$countryid)
        ->where('location',$request->Location)->delete();

        return response()->json([
            'data'=>$AirplaneCompnay,
            "messgae"=>"You Deleted this company",
            "status"=>200,
        ]);

    }
}
    //To Update THe AirPlaneCompany Inormation
    public function updateAirplaneCompany(Request $request){
        $request->validate([
            "OldName"=>"required",
            "OldLocation"=>"required",
            "NewName"=>"required",
            "NewLocation"=>"required",
            "description"=>"required",
            "Comforts"=>"required",
            "photo"=>"required",
            "food"=>"required",
            "safe"=>"required",
            "Rate"=>"required",
            "service"=>"required",
        ]);
        $AirplaneCompnay=FightCompany::where('name',$request->OldName)
        ->where('location',$request->OldLocation)->first();
        if(!$AirplaneCompnay){
            return response()->json([
                "status"=>"200",
                "messgae"=>"the company not found "
            ]);
        }

        else{

        FightCompany::where('name',$request->OldName)->where('location',$request->OldLocation)->
        update([
            'name'=>$request->NewName,
            'location'=>$request->NewLocation,
            'description'=>$request->description,
            'Comforts'=>$request->Comforts,
            'food'=>$request->food,
            'safe'=>$request->safe,
            'Rate'=>$request->Rate,
            'service'=>$request->service,
        ]) ;

        return response()->json([
            "status"=>"200",
            "messgae"=>"the company Informatino is Update"
        ]);
    }

    }
}
