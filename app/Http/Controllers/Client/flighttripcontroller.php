<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Contrey;
use App\Models\FightCompany;
use App\Models\reserveTrip;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class flighttripcontroller extends Controller
{
    public function gettrip(){
        $trip=Trip::query()->with(['country:id,name,Rate','company:id,name,service'])->get();
           if($trip->count()>0){
               return response()->json([
                   'data'=>$trip,
                   'message'=>'this the trip in our app',
                   'status'=>200,
               ],200);
           }else{
               return response()->json([
                   'data'=>[],
                   'message'=>'not found any trip',
                   'status'=>404,
               ],404);
           }
       }
    //Reseve Tripe
    public function ResveFightTrip(Request $request){
        $request->validate([
            "TripID"=>"required",
            "email"=>"required",
            "fatherName"=>"required",
            "MotherName"=>"required",
            "Gendor"=>"required",
            "FlightClass"=>"required",
            "Wight"=>"required",
        ]);
        $User=User::where('email',$request->email)->first();
        if(!$User){
            return response()->json([
                'data'=>[],
                "Message"=>"not found this email",
                "status"=>404,
            ],404);
        }

        $UserId=$User->id;
        $trip =new reserveTrip();
        $trip->users_id=$UserId;
        $trip->fight_air_planes_id=$request->TripID;
        $trip->MotherName=$request->MotherName;
        $trip->fatherName=$request->fatherName;
        $trip->Gendor=$request->Gendor;
        $trip->FlightClass=$request->FlightClass;
        $trip->Wight=$request->Wight;
        $trip->save();

        return response()->json([
            'data'=>$trip,
            "Message"=>"you Reserved This Trip",
            "status"=>200,
        ]);
    }




    public function DeleteReserveTrip(Request $request){
        $request->validate([
            'idTrip'=>'nullable'
        ]);

        $reservetrip=reserveTrip::query()->where('id',$request->idTrip)->first();

        if(!$reservetrip){
            return response()->json([
                'data'=>[],
                'message'=>'The Trip is Not Found To Delete',
                'status'=>404
            ],404);
        }

        reserveTrip::query()->where('id',$request->idTrip)->delete();
        return response()->json([
            'data'=>$reservetrip,
            'message'=>'Your Reserve Trip is canceled',
            'status'=>200
        ],200);
    }




    public function UpdateInfoReserve(Request $request){
        $request->validate([
            "reserveId"=>"nullable",
            "newfatherName"=>"nullable",
            "newMotherName"=>"nullable",
            "newGendor"=>"nullable",
            "newFlightClass"=>"nullable",
            "newWight"=>"nullable",
        ]);


        $reserveTrip=reserveTrip::query()->where('id',$request->reserveId)->first();

        if(!$reserveTrip){
            return response()->json([
                'data'=>[],
                'message'=>'Your Reserve Trip is not found',
                'status'=>404
            ],404);
        }

        reserveTrip::query()->where('id',$request->reserveId)->update([
            'fatherName'=>$request->newfatherName??$reserveTrip->fatherName,
            'MotherName'=>$request->newMotherName??$reserveTrip->MotherName,
            'Gendor'=>$request->newGendor??$reserveTrip->Gendor,
            'FlightClass'=>$request->newFlightClass??$reserveTrip->FlightClass,
            'Wight'=>$request->newWight??$reserveTrip->Wight,
        ]);
        $Reservenewinfo=reserveTrip::query()->where('id',$request->reserveId)->first();
        return response()->json([
            'data'=>$Reservenewinfo,
            'message'=>'The Trip Info Is Updated Successfuly',
            'status'=>200
        ],200);

    }


    public function GetReserveTrip(){

        $userid=auth()->user()->id;

        $reserveTrip=reserveTrip::query()->where('users_id',$userid)->with(['trip'])->get();

        if($reserveTrip->count()<0){
            return response()->json([
                'data'=>[],
                'message'=>'Your do not have reserve trip',
                'status'=>404
            ],404);
        }

        return response()->json([
            'data'=>$reserveTrip,
            'message'=>'Your Reserve Trips',
            'status'=>200
        ],200);

    }



    //Get Company With Trips
    public function getCompanyORCountryWithTrips(Request $request){
        $request->validate([
            "CompanyORCountry"=>"required"
        ]);

       $country = Contrey::query()->where('name',$request->CompanyORCountry)->get();

        if($country->count()>0){
            $country = Contrey::query()->where('name',$request->CompanyORCountry)->first();

            $tripwithcountry=Trip::query()->where('country_id',$country->id)->first();

            if(!$tripwithcountry){
                return response()->json([
                    'data'=>[],
                    'message'=>'not found any trips in this country',
                    'status'=>404
                ],404);
            }

            return response()->json([
                'data'=>$tripwithcountry,
                'message'=>'There Are The Trips Via Country',
                'status'=>200
            ],200);
        }

        $company=FightCompany::query()->where('name',$request->CompanyORCountry)->first();
        if($company->count()>0){

            $tripwithcompany=Trip::query()->where('fight_company_id',$company->id)->first();

            if(!$tripwithcompany){
                return response()->json([
                    'data'=>[],
                    'message'=>'not found any trips in this company',
                    'status'=>404
                ],404);
            }

            return response()->json([
                'data'=>$tripwithcompany,
                'message'=>'There Are The Trips Via Country',
                'status'=>200
            ],200);

        }

        // $CounterWithAirPlanes=new FightCompany();
        // $CounterWithAirPlanes=FightCompany::with(['Trips'=>function($q){
        //     $q->select(['TripPlace','Towards','DayOfTheTrip'
        //     ,'MonthOfTheTrip','TimeOfTheTrip','fight_company_id','id','Price']);
        // }])->where('name',$request->NameOfCompany)->select('name','id')->get();
        // return response()->json([
        //     "sattus"=>"200",
        //     "company"=>$CounterWithAirPlanes
        // ]);
    //}




}
}