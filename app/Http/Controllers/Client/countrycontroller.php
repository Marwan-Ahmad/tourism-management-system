<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Contrey;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class countrycontroller extends Controller
{
    //Search About Country
    public function SearchAboutContrey(Request $request){
        $request->validate([
            "name"=>"required",
        ]);
        $CountriesNames= Contrey::where('name',$request->name)->first();
        if(!$CountriesNames){
            return response()->json([
                "data"=>$CountriesNames,
                'message'=>'not found any country with this name',
                "status"=>404,
            ]);
        }
        else{
        return response()->json([
            "data"=>$CountriesNames,
            'message'=>' The country with this name',
            "status"=>200,
        ]);
    }
}

    //return Country
    public function ReturnCountrey(){
        $countrey= Contrey::all();
        if($countrey->count()==0){
            return response()->json([
                "data"=>$countrey,
                'message'=>'There is no country to show it',
                "status"=>404,
            ]);
       }else{
        return response()->json([
            "data"=>$countrey,
            'message'=>'This The country in your app',
            "status"=>200,
        ]);

       }
}
}
