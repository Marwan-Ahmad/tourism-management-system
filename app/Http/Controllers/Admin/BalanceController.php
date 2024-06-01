<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\balance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BalanceController extends Controller
{



    public function getClientsAccount(){
        $account=balance::query()->with(['clients:id,Firstname,Lastname,email,phone'])->get();

        if($account->count()==0){
            return response()->json([
                'data'=>[],
                'message'=>'Clients Accounts Not Found',
                'status'=>404
            ],404);
        }

        return response()->json([
            'data'=>$account,
            'message'=>'Client Account',
            'status'=>200
        ],200);
    }


// public function CreateAccountForClient(Request $request){
//     $request->validate([
//         'PhoneUser'=>'required',
//         'EmailUser'=>'required',
//         'Balance'=>'required'

//     ]);

//     $user_id=User::query()->where('email',$request->EmailUser)
//     ->where('phone',$request->PhoneUser)
//     ->first();



//     if(!$user_id){
//         return response()->json([
//             'data'=>[],
//             'message'=>'Client Not Found To Transfer Cash To Him',
//             'status'=>404
//         ],404);
//     }

//     $haveaccount=balance::query()->where('user_id',$user_id->id)->get();

//     if($haveaccount->count()>0){
//         return response()->json([
//             'data'=>[],
//             'message'=>'Client already have account',
//             'status'=>409
//         ],404);
//     }
//         $cash=balance::query()->create([
//             'balance'=>$request->Balance,
//             'user_id'=>$user_id->id,
//             'last_transaction_date'=>Carbon::now()
//         ]);

//         return response()->json([
//             'data'=>$cash,
//             'message'=>'Client Account created successfuly with balance'." ". $request->Balance,
//             'status'=>201
//         ],201);
//    }




   public function DeleteAccountClient(Request $request){

    $request->validate([
        'idaccount'=>'nullable'
    ]);

    $useraccount=balance::query()->where('id',$request->idaccount)->first();

    if(!$useraccount){
        return response()->json([
            'data'=>[],
            'message'=>'Client Account Not Found',
            'status'=>404
        ],404);
    }

    $useraccount->delete();
    return response()->json([
        'data'=>$useraccount,
        'message'=>'Client Account deleted successfuly',
        'status'=>200
    ],200);
   }

    public function UpdateClientAccount(Request $request){
        $request->validate([
            'idaccount'=>'nullable',
            'Balance'=>'nullable'
        ]);
        $useraccount=balance::query()->where('id',$request->idaccount)->first();
        if(!$useraccount){
           return response()->json([
            'data'=>[],
            'message'=>'Client Account Not Found',
            'status'=>404
            ],404);
        }
            $useraccount->update([
                'balance'=>$request->Balance??$useraccount->balance
            ]);
            return response()->json([
                'data'=>$useraccount,
                'message'=>'Client Account balance updated successfuly',
                'status'=>200
                ],200);

    }
}