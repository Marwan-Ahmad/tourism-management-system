<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\balance;
use App\Models\Contrey;
use App\Models\FightCompany;
use App\Models\reserveTrip;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class flighttripcontroller extends Controller
{
    public function gettrip(){

        $trip=Trip::query()->with(['country:id,name','company:id,name'])->get();



           if($trip->count()>0){
            $formattedTrips = $trip->map(function ($trip) {
                return [
                    'id' => $trip->id,
                    'tripPlace' => $trip->TripPlace,
                    'towards' => $trip->Towards,
                    'timeTrip' => $trip->TimeTrip,
                    'price' => $trip->Price,
                    'amountpeople'=>$trip->amountpeople,
                    'companyName' => $trip->company->name,
                    'countryName' => $trip->country->name
                ];
            });
               return response()->json([
                'data'=>$formattedTrips,
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
    public function ResveFlightTrip(Request $request){
        $request->validate([
            "TripID"=>"required",
            "email"=>"required",
            "fatherName"=>"required",
            "MotherName"=>"required",
            "Gendor"=>"required",
            "FlightClass"=>"required",
            "Wight"=>"required",
            "amountpeople"=>"required"
        ]);

        $User=User::where('email',$request->email)->first();
        if(!$User){
            return response()->json([
                'data'=>[],
                "Message"=>"not found this email",
                "status"=>404,
            ],404);
        }

                $tripuser=reserveTrip::query()->where('users_id',auth()->user()->id)
                ->where('fight_air_planes_id',$request->TripID)->get();
                if($tripuser->count()>0){
                    return response()->json([
                        'data'=>[],
                        "Message"=>"You Are Reserve This Trip Before Thank For That",
                        "status"=>409,
                    ],409);
                }

//amount 200
//if(amountRequest>amount)=>count people more than the abliable chers
//if(amount==0)=>you cannot reserve this trip becouse is cloused of people
//else=> amountnew =amount - amountRequest => you reserve this trip
//first thing i will do
//1-add culomn to trip and reserve trip mains amount of people
//2-change the trip requests for admin [insert update]
//3-change the reserve trip requests for client
//4-try the changes
//__________________________________________//


        $amounttrip=Trip::query()->where('id',$request->TripID)->first();

        if($request->amountpeople > $amounttrip->amountpeople || $amounttrip->amountpeople == 0){
            return response()->json([
                'data'=>[],
                "Message"=>"There are no enough plases for you",
                "status"=>422,
                ],422);
            }

            // $checkbalance=balance::query()->where('user_id',auth()->user()->id)->first();
            // if($checkbalance->balance < $amounttrip->Price || ($amounttrip->Price*$request->amountpeople) > $checkbalance->balance){
            //     return response()->json([
            //         'data'=>[],
            //         "Message"=>"No Enough Money To Reserve This Trip Please Recharge Your Account",
            //         "status"=>422,
            //         ],422);
            // }




        $UserId=$User->id;
        $trip =new reserveTrip();
        $trip->users_id=$UserId;
        $trip->fight_air_planes_id=$request->TripID;
        $trip->MotherName=$request->MotherName;
        $trip->fatherName=$request->fatherName;
        $trip->Gendor=$request->Gendor;
        $trip->FlightClass=$request->FlightClass;
        $trip->Wight=$request->Wight;
        $trip->amountpeople=$request->amountpeople;
        $trip->status='unpayed';
        $trip->save();


            // $checkbalance->balance=$checkbalance->balance - ($amounttrip->Price*$request->amountpeople);
            // $checkbalance->update([
            //     'balance'=>$checkbalance->balance
            // ]);

        $amounttrip->amountpeople=$amounttrip->amountpeople - $request->amountpeople;
                $amounttrip->update([
                    'amountpeople'=>$amounttrip->amountpeople
                ]);

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

        if($reservetrip->status=='unpayed'){
            return response()->json([
                'data'=>[],
                'message'=>'The Trip is Unpayed To delete please pay it first',
                'status'=>404
            ],404);
        }

        if(!$reservetrip){
            return response()->json([
                'data'=>[],
                'message'=>'The Trip is Not Found To Delete',
                'status'=>404
            ],404);
        }




        $amounttrip=Trip::query()->where('id',$reservetrip->fight_air_planes_id)->first();
        $amounttrip->amountpeople=$amounttrip->amountpeople + $reservetrip->amountpeople;
                $amounttrip->update([
                    'amountpeople'=>$amounttrip->amountpeople
                ]);

                $checkbalance=balance::query()->where('user_id',auth()->user()->id)->first();
                $checkbalance->balance=$checkbalance->balance + ($amounttrip->Price * $reservetrip->amountpeople);
                $checkbalance->update([
                    'balance'=>$checkbalance->balance
                ]);


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
            "newamountpeople"=>'nullable'
        ]);


        $reserveTrip=reserveTrip::query()->where('id',$request->reserveId)->first();

        if(!$reserveTrip){
            return response()->json([
                'data'=>[],
                'message'=>'Your Reserve Trip is not found',
                'status'=>404
            ],404);
        }

        if($reserveTrip->status=='unpayed'){
            return response()->json([
                'data'=>[],
                'message'=>'The Trip is Unpayed To update please pay it first',
                'status'=>404
            ],404);
        }




        //if($request)
        //if(request> amount old)=>$request-amount old => new-amount trip
        //if($request>amount trip )=>message amount in trip not enough
        //if(request < old amount)=>old amount -request => new +amount trip
        //else
        // if()


        if($request->newamountpeople){
            $amounttrip=Trip::query()->where('id',$reserveTrip->fight_air_planes_id)->first();

            if($request->newamountpeople > $amounttrip->amountpeople){
                return response()->json([
                    'data'=>[],
                    'message'=>'The NewAmountPeople Is Greater Than The Amount Of Trip ',
                    'status'=>422
                ],422);
            }

            if($request->newamountpeople > $reserveTrip->amountpeople){

               $amountnew=$request->newamountpeople - $reserveTrip->amountpeople;

               $amountnew=$amounttrip->amountpeople-$amountnew  ;

                $amounttrip->update([
                    'amountpeople'=> $amountnew
                ]);

            }
            if($request->newamountpeople <  $reserveTrip->amountpeople){

               $amountnew=  $reserveTrip->amountpeople - $request->newamountpeople ;

               $amountnew=$amountnew + $amounttrip->amountpeople;

                $amounttrip->update([
                    'amountpeople'=> $amountnew
                ]);

            }


            //if($request amount >old amount)=>new=$request - old=>balance=balance old - new*tripprice
                //if(balance>=0)
                   //update
                //else
                   //return not enough mony
            //if($request amount< old amount )=>new=old -$request=>balance=old balance +new*tripprice
                    //update

            $checkbalance=balance::query()->where('user_id',auth()->user()->id)->first();

            if($request->newamountpeople > $reserveTrip->amountpeople){
                $newamount=$request->newamountpeople -  $reserveTrip->amountpeople;

                $checkbala=$checkbalance->balance - $newamount*$amounttrip->Price;

                if($checkbala>=0){
                    $checkbalance->update([
                        'balance'=>$checkbala
                    ]);
                }else{
                    return response()->json([
                        'data'=>[],
                        'message'=>'Not Enough Mouney To Reserve This amount of people',
                        'status'=>422
                    ],422);
                }
            }elseif($request->newamountpeople < $reserveTrip->amountpeople){
                $newamount=$reserveTrip->amountpeople - $request->newamountpeople;

                $checkbala=$checkbalance->balance + $newamount*$amounttrip->Price;

                $checkbalance->update([
                    'balance'=>$checkbala
                ]);
            }
        }



        reserveTrip::query()->where('id',$request->reserveId)->update([
            'fatherName'=>$request->newfatherName??$reserveTrip->fatherName,
            'MotherName'=>$request->newMotherName??$reserveTrip->MotherName,
            'Gendor'=>$request->newGendor??$reserveTrip->Gendor,
            'FlightClass'=>$request->newFlightClass??$reserveTrip->FlightClass,
            'Wight'=>$request->newWight??$reserveTrip->Wight,
            'amountpeople'=>$request->newamountpeople??$reserveTrip->amountpeople,
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

        if($reserveTrip->count()<=0){
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


    public function getunpayedtrip(){
        $userid=auth()->user()->id;

        $reserveTrip=reserveTrip::query()->where('users_id',$userid)->where('status','unpayed')->with(['trip'])->get();
        if($reserveTrip->count() <= 0){
            return response()->json([
                'data'=>[],
                'message'=>'Your do not have un payed reserve trip',
                'status'=>404
            ],404);
        }

        return response()->json([
            'data'=>$reserveTrip,
            'message'=>'Your unpayed Reserve Trips',
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


        $company=FightCompany::query()->where('name',$request->CompanyORCountry)->get();
        if($company->count()>0){
            $company=FightCompany::query()->where('name',$request->CompanyORCountry)->first();

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
                'message'=>'There Are The Trips Via company',
                'status'=>200
            ],200);

        }

        return response()->json([
            'data'=>[],
            'message'=>'Not Found Any Trip With Realated Search',
            'status'=>404
        ],404);
   }



}
/*
first thing i will do somw logic and delete some logic from the code

1=> i will create function to payed will insert phone and email to pay
2=> i will add culmon to reserve trip to payed or un payed defult un payed
3=> i will when the press un payed will give him un payed in db and showed in moinetor
4=> i will when they press payed will give him mointer to enter email phone to paye from price mult the num of amount people



1 =>  add coulmon to reserve trip to payed or not payed
2 =>  get the un payed trips
3 =>  logic of payed in reserve trip transfer to function
4 =>  when press in payed will send the id and have a flight trip price with the amount from reserve
5 =>  update the balance and updated the the status of the trip to payed


*/