<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\balance;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function getmyaccount(){

        $user_id=auth()->user()->id;

        $useraccount=balance::query()
        ->where('user_id',$user_id)
        ->with(['clients'])
        ->first();

        if(!$useraccount){
            return response()->json([
                'data'=>[],
                'message'=>'Not Found Account User',
                'status'=>200
            ],200);
        }

        $formatedaccount=$useraccount->map(function($useraccount){
            return [
                'id' => $useraccount->id,
                'Name' =>$useraccount->clients->name,
                'email'=>$useraccount->clients->email,
                'phone'=>$useraccount->clients->phone
            ];
        });

        return response()->json([
            'data'=>$formatedaccount,
            'message'=>'This Is Your Account',
            'status'=>200
        ],200);



    }
}