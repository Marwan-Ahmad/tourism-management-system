<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contrey;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class hotelcontroller extends Controller
{

    public function gethotels(){
        $allhotels=Hotel::query()->with(['contrey'])->get();
        if($allhotels->count()<=0){
            return response()->json([
                'data'=>[],
                'message'=>'no hotels',
                'status'=>404,
            ]);
        }else{

            return response()->json([
                'data'=>$allhotels,
                'message'=>'this is the hotels in your app',
                'status'=>200,
            ]);
        }

    }

    public function SearchAboutHoteladmin(Request $request){
        $request->validate([
            "nameOfCountrey"=>"required",
            "nameOfHotel"=>"required"
        ]);
         $idcountry=Contrey::query()->where('name',$request->nameOfCountrey)->first();
         if(!$idcountry){
            return response()->json([
                "data"=>[],
                'message'=>"not found any country realeted with this name",
                "status"=>404,
            ],404);
         }
        $hotelsearch=Hotel::query()->where('Country_id',$idcountry->id)->where('name',$request->nameOfHotel)->get();
        if($hotelsearch->count()<=0){
            return response()->json([
                "data"=>[],
                'message'=>"not found any hotel with this name",
                "status"=>404,
            ],404);
        }

        $formatedresponse=$hotelsearch->map(function($hotelsearch){
            return [
                'id'=>$hotelsearch->id,
                'name'=>$hotelsearch->name,
                'location'=>$hotelsearch->location,
                'description'=>$hotelsearch->description,
                'Basicphoto' =>$hotelsearch->Basicphoto,
                "Roomphoto1" => $hotelsearch->Roomphoto1,
                "Roomphoto2" => $hotelsearch->Roomphoto2,
                "Roomphoto3" => $hotelsearch->Roomphoto3,
                "food"=>$hotelsearch->food,
                "service"=>$hotelsearch->service,
                "comforts"=>$hotelsearch->comforts,
                "safe"=>$hotelsearch->safe,
                "Rate"=>$hotelsearch->Rate,
               // 'contreyid'=>$allhotels->contrey->id,
                'contreyname'=>$hotelsearch->contrey->name,
                'contreyphoto' => $hotelsearch->contrey->photo,
                'contreyRate'=>$hotelsearch->contrey->Rate,
            ];
        });

        return response()->json([
            "data"=>$formatedresponse,
            'message'=>'this the hotel with this search',
            "status"=>200,
        ]);
    }


    //To Input Hotell
    public function inputHotelInformation(Request $request){

        $request->validate([
            "name"=>"required",
            "location"=>"required",
            "nameOfCountry"=>"required",
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
            "x"=>"required",
            "y"=>"required",
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

        $contry=Contrey::query()->where('name',$request->nameOfCountry)->first();


        if(!$contry){
            return response()->json([
                'data'=>[],
                "message"=>"the country not found please check the name of country",
                "status"=>200,
          ]);
        }
        $contry_id=$contry->id;

        $hotelexist=Hotel::query()->where('name',$request->name)
        ->where('location',$request->location)
        ->where('Country_id',$contry_id)->first();
        if($hotelexist){
            return response()->json([
                'data'=>[],
                "message"=>"the hotel is exist before at the same place",
                "status"=>200,
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
        $CompanyInformation->x=$request->x;
        $CompanyInformation->y=$request->y;
        $CompanyInformation->save();

        return response()->json([
            'data'=>$CompanyInformation,
            "message"=>"the information of Hotel added successfuly",
            "status"=>"200",
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
                'data'=>[],
                "messgae"=>"the Hotel not found",
                "status"=>404,
            ]);
        }

        $oldPhotoPathbasic = str_replace('/storage', '', $Hotel->Basicphoto);
        if (Storage::disk('public')->exists($oldPhotoPathbasic)) {
            Storage::disk('public')->delete($oldPhotoPathbasic);
        }
        $oldPhotoPath1 = str_replace('/storage', '', $Hotel->Roomphoto1);
        if (Storage::disk('public')->exists($oldPhotoPath1)) {
            Storage::disk('public')->delete($oldPhotoPath1);
        }
        $oldPhotoPath2 = str_replace('/storage', '', $Hotel->Roomphoto2);
        if (Storage::disk('public')->exists($oldPhotoPath2)) {
            Storage::disk('public')->delete($oldPhotoPath2);
        }
        $oldPhotoPath3 = str_replace('/storage', '', $Hotel->Roomphoto3);
        if (Storage::disk('public')->exists($oldPhotoPath3)) {
            Storage::disk('public')->delete($oldPhotoPath3);
        }
        hotel::where('id',$request->IdHotel)->delete();
        return response()->json([
            'data'=>$Hotel,
            "messgae"=>"the Hotel is deleted",
            "status"=>200,
        ]);

    }
    //To Update Hotell Inormtion
    public function updateHotel(Request $request){
        $request->validate([
            "IdOfHotel"=>"required",
            "name"=>"nullable",
            "location"=>"nullable",
            'nameOfCountry'=>'nullable',
            "description"=>"nullable",
            "Comforts"=>"nullable",
            "Basicphoto"=>"nullable",
            "Roomphoto1"=>"nullable",
            "Roomphoto2"=>"nullable",
            "Roomphoto3"=>"nullable",
            "food"=>"nullable",
            "comforts"=>"nullable",
            "safe"=>"nullable",
            "Rate"=>"nullable",
            "service"=>"nullable",
            "x"=>"nullable",
            "y"=>"nullable",
        ]);
        $Hotel=hotel::where('id',$request->IdOfHotel)->first();


         if(!$Hotel){
            return response()->json([
                'data'=>[],
                "messgae"=>"the hotel not found ",
                "status"=>404,
            ]);
        }
        $countryinfo=Contrey::query()->where('id',$Hotel->Country_id)->first();
        $contry_id=Contrey::query()->where('name',$request->nameOfCountry??$countryinfo->name)->first();

        if(!$contry_id){
            return response()->json([
                'data'=>[],
                "message"=>"the country not found",
                "status"=>404,
          ]);
        }


        $hotelexist=Hotel::query()->where('name',$request->name)
        ->where('location',$request->location)
        ->where('Country_id',$contry_id->id)
        ->first();
        if($hotelexist){
            return response()->json([
                'data'=>[],
                "message"=>"the hotel is exist before at the same place",
                "status"=>200,
          ]);
        }

        if ($request->hasFile('Basicphoto')) {
            $oldPhotoPathbasic = str_replace('/storage', '', $Hotel->Basicphoto);
            if (Storage::disk('public')->exists($oldPhotoPathbasic)) {
                Storage::disk('public')->delete($oldPhotoPathbasic);
            }

            $image = $request->file('Basicphoto');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk('public')->put($fileName, file_get_contents($image));
            $photoPathbsic = Storage::url($fileName);
        } else {

            $photoPathbsic = $Hotel->Basicphoto;
        }

        if ($request->hasFile('Roomphoto1')) {
            $oldPhotoPath1 = str_replace('/storage', '', $Hotel->Roomphoto1);
            if (Storage::disk('public')->exists($oldPhotoPath1)) {
                Storage::disk('public')->delete($oldPhotoPath1);
            }

            $image = $request->file('Roomphoto1');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk('public')->put($fileName, file_get_contents($image));
            $photoPath1 = Storage::url($fileName);
        } else {

            $photoPath1 = $Hotel->Roomphoto1;
        }
        if ($request->hasFile('Roomphoto2')) {
            $oldPhotoPath2 = str_replace('/storage', '', $Hotel->Roomphoto2);
            if (Storage::disk('public')->exists($oldPhotoPath2)) {
                Storage::disk('public')->delete($oldPhotoPath2);
            }

            $image = $request->file('Roomphoto2');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk('public')->put($fileName, file_get_contents($image));
            $photoPath2 = Storage::url($fileName);
        } else {

            $photoPath2 = $Hotel->Roomphoto2;
        }
        if ($request->hasFile('Roomphoto3')) {
            $oldPhotoPath3 = str_replace('/storage', '', $Hotel->Roomphoto3);
            if (Storage::disk('public')->exists($oldPhotoPath3)) {
                Storage::disk('public')->delete($oldPhotoPath3);
            }

            $image = $request->file('Roomphoto3');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk('public')->put($fileName, file_get_contents($image));
            $photoPath3 = Storage::url($fileName);
        } else {

            $photoPath3 = $Hotel->Roomphoto3;
        }

        hotel::where('id',$request->IdOfHotel)->
        update([
            'name'=>$request->name??$Hotel->name,
            'location'=>$request->location??$Hotel->location,
            'Country_id'=>$contry_id->id??$Hotel->Country_id,
            'description'=>$request->description??$Hotel->description,
            'comforts'=>$request->Comforts??$Hotel->comforts,
            'food'=>$request->food??$Hotel->food,
            'safe'=>$request->safe??$Hotel->safe,
            'Rate'=>$request->Rate??$Hotel->Rate,
            'Basicphoto'=>$photoPathbsic,
            'Roomphoto1'=>$photoPath1,
            'Roomphoto2'=>$photoPath2,
            'Roomphoto3'=>$photoPath3,
            'service'=>$request->service??$Hotel->service,
            'x'=>$request->x??$Hotel->x,
            'y'=>$request->y??$Hotel->y,
        ]) ;

        $hotelinfo=hotel::query()->where('id',$request->IdOfHotel)->with(['contrey'])->first();

        return response()->json([
            'data'=>$hotelinfo,
            "messgae"=>"the hotel Informatino is Update",
            "status"=>200,
        ]);
    }
}