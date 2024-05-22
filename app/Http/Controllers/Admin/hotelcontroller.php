<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contrey;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class hotelcontroller extends Controller
{
    //To Input Hotell
    public function inputHotelInformation(Request $request){

        $request->validate([
            "name"=>"required",
            "location"=>"required",
            "description"=>"required",
            "Comforts"=>"required",
            "food"=>"required",
            "safe"=>"required",
            "service"=>"required",
            "Basicphoto"=>"required",
            "Roomphoto1"=>"required",
            "Roomphoto2"=>"required",
            "Roomphoto3"=>"required",
            "Rate"=>"required",
            "nameOfCountry"=>"required"
        ]);
        $Basicphoto = $request->file('Basicphoto');
        $fileName = uniqid().'.'.$Basicphoto->getClientOriginalExtension();
        Storage::disk('public')->put($fileName, file_get_contents($Basicphoto));
        $Basicphoto=Storage::url($fileName);

        $Roomphoto1 = $request->file('Roomphoto1');
        $fileName = uniqid().'.'.$Roomphoto1->getClientOriginalExtension();
        Storage::disk('public')->put($fileName, file_get_contents($Roomphoto1));
        $Roomphoto1=Storage::url($fileName);

        $Roomphoto2 = $request->file('Roomphoto2');
        $fileName = uniqid().'.'.$Roomphoto2->getClientOriginalExtension();
        Storage::disk('public')->put($fileName, file_get_contents($Roomphoto2));
        $Roomphoto2=Storage::url($fileName);

        $Roomphoto3 = $request->file('Roomphoto3');
        $fileName = uniqid().'.'.$Roomphoto3->getClientOriginalExtension();
        Storage::disk('public')->put($fileName, file_get_contents($Roomphoto3));
        $Roomphoto3=Storage::url($fileName);

        $contry=Contrey::where('name',$request->nameOfCountry)->first();
        $contry_id=$contry->id;

        if( !$contry){
            return response()->json([
                "status"=>"200",
                "message"=>"the country not found please check the name of country "
        ]);
        }

        $CompanyInformation=new Hotel();
        $CompanyInformation->name=$request->name;
        $CompanyInformation->location=$request->location;
        $CompanyInformation->description=$request->description;
        $CompanyInformation->Comforts=$request->Comforts;
        $CompanyInformation->food=$request->food;
        $CompanyInformation->safe=$request->safe;
        $CompanyInformation->service=$request->service;
        $CompanyInformation->Basicphoto=$Basicphoto;
        $CompanyInformation->Roomphoto1= $Roomphoto1;
        $CompanyInformation->Roomphoto2= $Roomphoto2;
        $CompanyInformation->Roomphoto3= $Roomphoto3;
        $CompanyInformation->Country_id=$contry_id;
        $CompanyInformation->Rate=$request->Rate;
        $CompanyInformation->save();

        return response()->json([
                "status"=>"200",
                "message"=>"the information of Hotel saved and "
        ]);

    }
    //To Drop Hotel From The App
    public function DropHotel(Request $request){
        $request->validate([
            "IdHotel"=>"required"
        ]);
        $Hotel=hotel::where('id',$request->IdHotel)->first();
        if(!$Hotel){
            return response()->json([
                "status"=>"200",
                "messgae"=>"the Hotel not found "
            ]);}
            hotel::where('id',$request->IdHotel)->delete();
        return response()->json([
            "status"=>"200",
            "messgae"=>"the Hotel is deleted"
        ]);

    }
    //To Update Hotell Inormtion
    public function updateHotel(Request $request){
        $request->validate([
           "IdOfHotel"=>"required",
            "name"=>"required",
            "location"=>"required",
            "description"=>"required",
            "Comforts"=>"required",
            "Basicphoto"=>"required",
            // "Roomphoto1"=>"required",
            // "Roomphoto2"=>"required",
            // "Roomphoto3"=>"required",
            "food"=>"required",
            "comforts"=>"required",
            "safe"=>"required",
            "Rate"=>"required",
            "service"=>"required",
        ]);
        $Hotel=hotel::where('id',$request->IdOfHotel)->first();
        if(!$Hotel){
            return response()->json([
                "status"=>"200",
                "messgae"=>"the company not found "
            ]);}
        else{
            hotel::where('id',$request->IdOfHotel)->
        update([
            'name'=>$request->name,
            'location'=>$request->location,
            'description'=>$request->description,
            'Comforts'=>$request->Comforts,
            'food'=>$request->food,
            'safe'=>$request->safe,
            'Rate'=>$request->Rate,
            'Basicphoto'=>$request->Basicphoto,
            // 'Roomphoto1'=>$request->Roomphoto1,
            // 'Roomphoto2'=>$request->Roomphoto2,
            // 'Roomphoto3'=>$request->Roomphoto3,
            'service'=>$request->service,
        ]) ;
        }
        return response()->json([
            "status"=>"200",
            "messgae"=>"the company Informatino is Update"
        ]);
    }
}