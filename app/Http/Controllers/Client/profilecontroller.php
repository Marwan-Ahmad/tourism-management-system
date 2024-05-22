<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class profilecontroller extends Controller
{
    //The Profile Of The User
    public function Profile(){
        $user=auth()->user();
        if($user){
        return response()->json([
            "message"=>"THis Is The Profile Of The User",
            "data"=>auth()->user(),
        ]);
    }else{
        return response()->json([
            "data"=>[],
            "message"=>"The User Not Found",
            'status'=>404
        ]);
    }
}
}
