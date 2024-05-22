<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contrey;
use App\Models\Expert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class expertcontroller extends Controller
{
    //For Input Experts
    public function inputInformationOfExpert(Request $request){
        $request->validate([
            "name"=>"required",
            "location"=>"required",
            "Rate"=>"required",
            "language"=>"required",
            "photo"=>"required",
            "description"=>"required",
            "Eduction"=>"required",
            "Experience"=>"required",
            "CountryName"=>"required",
        ]);
        $photo = $request->file('photo');
        $fileName = uniqid().'.'. $photo->getClientOriginalExtension();
        Storage::disk('public')->put($fileName, file_get_contents( $photo));
        $photo=Storage::url($fileName);

        $contry=Contrey::where('name',$request->CountryName)->first();

        if(!$contry){
            return response()->json([
                "status"=>"200",
                "message"=>"the country not found please check the name of country "
        ]);
        $contry_id=$contry->id;

        }
        $Expert=new Expert();
        $Expert->name=$request->name;
        $Expert->location=$request->location;
        $Expert->descreption=$request->description;
        $Expert->photo= $photo;
        $Expert->Eduction= $request->description;
        $Expert->Experience= $request->description;
        $Expert->language= $request->language;
        $Expert->Rate=$request->Rate;
        $Expert->Country_id=$contry->id;
        $Expert->save();
        return response()->json([
            "status"=>"200",
            "message"=>"the information of Expert Place saved and "
        ]);
    }

    //To Delete Expert
    public function DropExpert(Request $request){
        $request->validate([
            "IdOfExpert"=>"required"
        ]);
        $Expert=Expert::where('id',$request->IdOfExpert)->first();
        if(!$Expert){
            return response()->json([
                "status"=>"200",
                "messgae"=>"the Expert not found "
            ]);}
            Expert::where('id',$request->IdOfExpert)->delete();
        return response()->json([
            "status"=>"200",
            "messgae"=>"the Expert is deleted"
        ]);
    }

    //To Update Experts
    public function UpdateInfomationOfExpert(Request $request){
        $request->validate([
            "idOfExpert",
            'name'=>"required",
            'location'=>"required",
            'description'=>"required",
            // 'photo'=>"required",
            'language'=>"required",
            'Eduction'=>"required",
            'Rate'=>"required",
            'Experience'=>"required",
            'CountryName'=>"required",
        ]);
        // $photo = $request->file('photo');
        // $fileName = uniqid().'.'. $photo->getClientOriginalExtension();
        // Storage::disk('public')->put($fileName, file_get_contents( $photo));
        // $photo=Storage::url($fileName);

        $contry=Contrey::where('name',$request->CountryName)->first();

        if(!$contry){
            return response()->json([
                "status"=>"200",
                "message"=>"the country not found please check the name of country "
        ]);
        }
        $contry_id=$contry->id;
        Expert::where('id',$request->idOfExpert)->update([
            'name'=>$request->name,
            'location'=>$request->location,
            'descreption'=>$request->description,
            'language'=> $request->language,
            'Experience'=> $request->Experience,
            'Eduction'=> $request->Eduction,
            // 'photo'=>  $photo,
            'Rate'=>$request->Rate,
            'Country_id'=>$contry->id,
        ]);
        return response()->json([
            "status"=>"200",
            "message"=>"the information of Expert  Udpated "
        ]);
    }

}