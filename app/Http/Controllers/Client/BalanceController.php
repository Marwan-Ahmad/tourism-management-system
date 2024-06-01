<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\balance;
use App\Models\reserveTrip;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function getmyaccount(){
        $user_id=auth()->user();
        $useraccount=balance::query()
        ->where('user_id',$user_id->id)
        ->with(['clients'])
        ->get();
        if(!$useraccount){
            return response()->json([
                'data'=>[],
                'message'=>'Not Found Account User',
                'status'=>200
            ],200);
        }
        $formattedAccount = $useraccount->map(function ($useraccount) {
            return [
                'id' => $useraccount->id,
                'FirstName' =>$useraccount->clients->Firstname,
                'LastName' =>$useraccount->clients->Lastname,
                'balance'=>$useraccount->balance .'$',
                'last_transaction_date'=>$useraccount->last_transaction_date,
                'email'=>$useraccount->clients->email,
                'phone'=>$useraccount->clients->phone
            ];
        });
        return response()->json([
            'data'=>$formattedAccount,
            'message'=>'This Is Your Account',
            'status'=>200
        ],200);
    }


    public function PayedToTrip(Request $request){
        $request->validate([
            'idreservetrip'=>'required',
            'email'=>'required',
            'phone'=>'required',
        ]);



        $user=User::query()->where('email',$request->email)->where('phone',$request->phone)->first();

        if(!$user){
            return response()->json([
                'data'=>[],
                'message'=>'Client not found',
                'status'=>200
            ]);
        }

        $reservetrip=reserveTrip::query()->where('id',$request->idreservetrip)->where('status','unpayed')->first();

        if(!$reservetrip){
            return response()->json([
                'data'=>[],
                'message'=>'This trip payed',
                'status'=>200
            ]);
        }

        $tripinfo=Trip::query()->where('id',$reservetrip->fight_air_planes_id)->first();

        $checkbalance=balance::query()->where('user_id',$user->id)->first();
        if($checkbalance->balance < $tripinfo->Price || ($tripinfo->Price*$reservetrip->amountpeople) > $checkbalance->balance){
            return response()->json([
                'data'=>[],
                "Message"=>"No Enough Money To Reserve This Trip Please Recharge Your Account",
                "status"=>422,
                ],422);
        }

        $checkbalance->balance=$checkbalance->balance - ($tripinfo->Price*$reservetrip->amountpeople);
        $checkbalance->update([
            'balance'=>$checkbalance->balance
        ]);

        $reservetrip->update([
            'status'=>'payed'
        ]);

        return response()->json([
            'data'=>$reservetrip,
            'message'=>'thank you for payed to this trip enjoy in it',
            'status'=>200
        ]);
    }

}
