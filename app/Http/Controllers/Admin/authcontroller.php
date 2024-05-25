<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class authcontroller extends Controller
{
    public function login(Request $request){
        $request->validate([
          "email"=>'required|email',
          "password"=>'required|between:8,16'
        ]);



        $data=[];
        if(!auth()->attempt($request->only(['email','password']))){
            return response()->json([
                'Data'=>[],
                'Massage'=>'The email or password is Not Correct please try again',
                'status'=>401
            ],401);
        }
                    $info=User::where('email',$request->email)->first();
                    $token=$info->createToken("auth_token")->plainTextToken;
                return response()->json([
                    'Data'=>$info,
                    'token'=>$token,
                    'message'=>'Admin login succesfuly',
                    'status'=>200
                ]);

    }
    public function logout(){
        auth()->user()->currentAccessToken()->delete();
        return response()->json([
            'data'=>[],
            'Massage'=>'you logging out',
            'satatus'=>200
        ]);
    }

}