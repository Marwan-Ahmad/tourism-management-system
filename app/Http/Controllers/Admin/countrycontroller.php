<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contrey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Empty_;

use function PHPUnit\Framework\isNull;

class countrycontroller extends Controller
{
    //return country
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

    // To input Country In The App

    public function InputCountry(Request $request){
        $request->validate([
            'name'=>'required|unique:country',
            'Rate'=>'required',
            'photo'=>'required'
        ]);
        $image = $request->file('photo');
        $fileName = uniqid().'.'.$image->getClientOriginalExtension();
        Storage::disk('public')->put($fileName, file_get_contents($image));

        $countrey=new Contrey();
        $countrey->name=$request->name;
        $countrey->Rate=$request->Rate;
        $countrey->photo=Storage::url($fileName);
        $countrey->save();

        $countrey=Contrey::query()->where('name',$request->name)->first();
        if($countrey){
        return response()->json([
            'Data'=>$countrey,
            "message"=>"the information of country is seved",
            "status"=>200,
        ]);
    }
}

    //To Delete Country From The App
    public function DropCountry(Request $request){
        $request->validate([
            "id"=>"nullable"
        ]);
        $countrey=Contrey::where('id',$request->id)->first();
        if(!$countrey){
            return response()->json([
                'Data'=>[],
                "message"=>"the Countrey is not exist",
                "status"=>404,
            ]);
        }
        else{
        $country=Contrey::query()->where('id',$request->id)->first();

        $oldPhotoPath = str_replace('/storage', '', $country->photo);
        if (Storage::disk('public')->exists($oldPhotoPath)) {
            Storage::disk('public')->delete($oldPhotoPath);
        }
        Contrey::query()->where('id',$request->id)->delete();
        return response()->json([
            'Data'=>$country,
            "message"=>"the Countrey deleted",
            "status"=>200,
        ]);
     }
    }

    //To Update The Information Of The country
    public function UpdateInformationContrey(Request $request){
        $request->validate([
            'idOldName'=>'nullable',
            'NewName'=>'nullable',
            'Rate'=>'nullable',
            'photo'=>'nullable',
        ]);


        $countryexist=Contrey::query()->where('id',$request->idOldName)->first();
        if($countryexist){

            if(Contrey::query()->where('name',$request->NewName)->where('id','!=',$countryexist->id)->first()){
                return response()->json([
                    'Data'=>[],
                    "message"=>"the name of country you use it is exists before",
                    "satuts"=>400,
                ],400);
            }
            if ($request->hasFile('photo')) {
                $oldPhotoPath = str_replace('/storage', '', $countryexist->photo);
                if (Storage::disk('public')->exists($oldPhotoPath)) {
                    Storage::disk('public')->delete($oldPhotoPath);
                }

                $image = $request->file('photo');
                $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->put($fileName, file_get_contents($image));
                $photoPath = Storage::url($fileName);
            } else {

                $photoPath = $countryexist->photo;
            }
        Contrey::where('id',$request->idOldName)->update([
            'name'=>$request->NewName ?? $countryexist->name,
            'Rate'=>$request->Rate??$countryexist->Rate,
            'photo'=> $photoPath
        ]);
        $newcountry=Contrey::query()->where('name',$request->NewName??$countryexist->name)->first();
        return response()->json([
            'Data'=>$newcountry,
            "message"=>"updated is finished",
            "satuts"=>200,
        ]);
    }else{
        return response()->json([
            'Data'=>[],
            "message"=>"The country you try to update not exist please just enter a old name if you do not need to update any things",
            "satuts"=>404,
        ]);
    }
 }
}
