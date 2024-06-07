<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contrey;
use App\Models\FightCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class airplanecontroller extends Controller
{


        public function getcompany(){
            $getcompany=FightCompany::query()->with(['contrey'])->get();
            if($getcompany->count()>0){
            return response()->json([
                'data'=>$getcompany,
                "message"=>"this is the company in your app",
                "status"=>200,
            ]);
        }else{
            return response()->json([
                'data'=>[],
                "message"=>"Ypu Don't have any company in your app",
                "status"=>200,
            ]);
        }
    }



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

            $image = $request->file('photo');
            $fileName = uniqid().'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put($fileName, file_get_contents($image));

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
            'id'=>'nullable'
        ]);
        $AirplaneCompnay=FightCompany::query()
        ->where('id',$request->id)
        ->first();

        if(!$AirplaneCompnay){
            return response()->json([
                'data'=>[],
                "messgae"=>"This Company not found in our app to delete it",
                "status"=>404,
            ]);
        }

        else{

            $Airplanephoto=FightCompany::query()
            ->where('id',$request->id)
            ->first();

        $oldPhotoPath = str_replace('/storage', '', $Airplanephoto->photo);
        if (Storage::disk('public')->exists($oldPhotoPath)) {
            Storage::disk('public')->delete($oldPhotoPath);
        }

        FightCompany::query()
        ->where('id',$request->id)
        ->delete();


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
            "idOldName"=>'nullable',
            "NewName"=>'nullable',
            "NewLocation"=>'nullable',
            "description"=>'nullable',
            'photo'=>'nullable',
            "Comforts"=>'nullable',
            "food"=>'nullable',
            "safe"=>'nullable',
            "Rate"=>'nullable',
            "service"=>'nullable',
            "nameOfCountry"=>'nullable',
        ]);
        $AirplaneCompnay=FightCompany::where('id',$request->idOldName)
        ->first();

        $namecountry=Contrey::query()->where('name',$request->nameOfCountry)->first();




        if(!$AirplaneCompnay){
            return response()->json([
                'data'=>[],
                "messgae"=>"the company not found and if you do not need to update the information please enter just the old name and the old location  ",
                "status"=>404,
            ],404);
        }

        else{


            if(FightCompany::query()->where('name',$request->NewName)->where('id','!=',$AirplaneCompnay->id)->first()){
                return response()->json([
                    'Data'=>[],
                    "message"=>"the name of company you use it is exists before",
                    "satuts"=>400,
                ],400);
            }

            if ($request->hasFile('photo')) {
                $oldPhotoPath = str_replace('/storage', '', $AirplaneCompnay->photo);
                if (Storage::disk('public')->exists($oldPhotoPath)) {
                    Storage::disk('public')->delete($oldPhotoPath);
                }

                $image = $request->file('photo');
                $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->put($fileName, file_get_contents($image));
                $photoPath = Storage::url($fileName);
            } else {

                $photoPath = $AirplaneCompnay->photo;
            }

        FightCompany::where('id',$request->idOldName)
        ->update([
            'name'=>$request->NewName??$AirplaneCompnay->name,
            'location'=>$request->NewLocation??$AirplaneCompnay->location,
            'description'=>$request->description??$AirplaneCompnay->description,
            'Comforts'=>$request->Comforts??$AirplaneCompnay->Comforts,
            'food'=>$request->food??$AirplaneCompnay->food,
            'safe'=>$request->safe??$AirplaneCompnay->safe,
            'Rate'=>$request->Rate??$AirplaneCompnay->Rate,
            'service'=>$request->service??$AirplaneCompnay->service,
            'photo'=>$photoPath,
            'Country_id'=>$namecountry->id??$AirplaneCompnay->id
        ]) ;
        $AirplaneCompnaynew=FightCompany::where('name',$request->NewName??$AirplaneCompnay->name)
        ->where('location',$request->NewLocation??$AirplaneCompnay->location)
        ->first();

        return response()->json([
            'data'=>$AirplaneCompnaynew,
            "messgae"=>"the company is updated",
            "status"=>200,
        ]);
    }

    }



}