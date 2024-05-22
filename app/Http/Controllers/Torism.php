<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Contrey;
use App\Models\FightCompany;
use App\Models\Trip;
use App\Models\reserveTrip;
use App\Models\User;
use App\Models\hotel;
use App\Models\Room;
use App\Models\Expert;
use App\Models\reserveExpert;
use App\Models\touristPlace;
use App\Models\ActivtiyReserve;
use App\Models\Activity;
use  App\Traits\UploadImage;
class Torism extends Controller
{
    use UploadImage;
    ########## To Rubish ##############
    // public function reserveTouristPlace(Request $request){
    //     $request->validate([
    //         'FatherName'=>"required",
    //         'MotherName'=>"required",
    //         'Gendor'=>"required",
    //         'NumberOfPeople'=>"required",
    //         'NumberOfRoom'=>"required",
    //         'TypeRoom'=>"required",
    //         'Meal'=>"required",
    //         'FirstDay'=>"required",
    //         'LastDay'=>"required",
    //         'hotel_id'=>"required",
    //         'email'=>"required",
    //     ]);
    //     $User=User::where('email',$request->email)->first();
    //     if(!$User){
    //         return response()->json([
    //             "sattus"=>"200",
    //             "Message"=>"not found this email"
    //         ]);
    //     }
    //     $UserId=$User->id;
    // }
    ###########################################################3##
    // public function getHotelWithRooms(Request $request){
    //     $request->validate([
    //         "NameOfHotel"=>"required"
    //     ]);
    //     $HotelWithRooms=new Hotel();
    //     $HotelWithRooms=Hotel::with('Rooms')->where('name',$request->NameOfHotel)
    //     ->select('name','id')->get();
    //     return response()->json([
    //         "sattus"=>"200",
    //         "company"=>$HotelWithRooms
    //     ]);
    // }
    ####################### Finshed#######################
   public function getTouristPlaceFamilier(){

    $tourist_place=touristPlace:: where('familier',true)->get();
    return response()->json([
        "status"=>"200",
        'TouristPlaces'=>$tourist_place
        ]);
   }
   public function inputTouristPlace(Request $request){
    $image = $request->file('photo');
    // توليد اسم عشوائي للصورة
    $fileName = uniqid().'.'.$image->getClientOriginalExtension();

        // حفظ الصورة في مجلد التخزين (Storage) الذي تحدده
        Storage::disk('public')->put($fileName, file_get_contents($image));
        $request->validate([
            "name"=>"required",
            "location"=>"required",
            "description"=>"required",
            "Comforts"=>"required",
            "photo"=>"required",
            "food"=>"required",
            "BestTime"=>"required",
            "food"=>"required",
            "uniqueStuff"=>"required",
            "service"=>"required",
            "familier"=>"required",
        ]);
        $PlaceInformation=new touristPlace();
        $PlaceInformation->name=$request->name;
        $PlaceInformation->location=$request->location;
        $PlaceInformation->description=$request->description;
        $PlaceInformation->Comforts=$request->Comforts;
        $PlaceInformation->BestTime=$request->BestTime;
        $PlaceInformation->uniqueStuff=$request->uniqueStuff;
        $PlaceInformation->food=$request->food;
        $PlaceInformation->safe=$request->safe;
        $PlaceInformation->service=$request->service;
        $PlaceInformation->photo=Storage::url($fileName);
        $PlaceInformation->familier=$request->familier;
    $PlaceInformation->save();
    return response()->json([
        "status"=>"200",
        "message"=>"the information of Tourist Place saved"
    ]);
   }
   public function GetAllTouristPlaces(){
    $tourist_place =new touristPlace();
    $tourist_place = touristPlace ::get();
    return response()->json([
        "status"=>"200",
        "TouistPlaces"=>$tourist_place
    ]);
   }
   public function getCompanyFightFamilier (){

    $torism=FightCompany:: where('familier',true)->get();
    return response()->json([
        "status"=>"200",
        'FightCompanies'=>$torism
        ]);
   }
   public function GetFightTrip(){
        $Trips=FightCompany::with('Trips')->get();
    // $fight=Trip::with('Fight')->get();
        return response()->json([
            "stauts"=>"200",
        "fight and its trips"=>$Trips,
        //"fight and its trips"=>$fight
        ]);
   }
   public function getHotelFamilier(){
    $Data=hotel::with('RoomsPhoto')->where('familier',true)->get();
    return response()->json([
        "message"=>"true",
        "Data"=>$Data
    ]);
   }
//    public function inputHotelInformation(Request $request){
//                 $request->validate([
//                     "name"=>"required",
//                     "location"=>"required",
//                     "description"=>"required",
//                     "Comforts"=>"required",
//                     "food"=>"required",
//                     "safe"=>"required",
//                     "service"=>"required",
//                     "familier"=>"required",
//                 ]);
//                 $CompanyInformation=new hotel();
//                 $CompanyInformation->name=$request->name;
//                 $CompanyInformation->location=$request->location;
//                 $CompanyInformation->description=$request->description;
//                 $CompanyInformation->Comforts=$request->Comforts;
//                 $CompanyInformation->food=$request->food;
//                 $CompanyInformation->safe=$request->safe;
//                 $CompanyInformation->service=$request->service;
//                 $CompanyInformation->photo=Storage::url($fileName);
//                 $CompanyInformation->familier=$request->familier;
//             $CompanyInformation->save();
//             $HotelInoformation=hotel::where('name',$request->nameOfHotel )->where("location","Damascus")->first();
//             $HotelId= $HotelInoformation->id;
//             return response()->json([
//                 "status"=>"200",
//                 "message"=>"the information of Hotel saved and "
//             ]);
//    }
   public function getHotel(){
    $Hotels=hotel::with('RoomsPhoto')->get();
    return response()->json([
        "message"=>"the informations of Hotels ",
        "Data"=>$Hotels
    ]);
   }
   public function SearchAboutHotel12(Request $request){
    $request->validate([
        "name"=>"required"
    ]);
    $Hotle=hotel::where('name',$request->name)->get();
    if($Hotle){
        return response()->json([
            "status"=>"200",
            "data"=>"not found any Hotel with this name"
        ]);
    }
    return response()->json([
        "message"=>"the Hotel Founded",
        "data"=>$Hotle
    ]);
   }
   #########################  End  Finshed Function     #######################
   public function ReserveTrip(Request $request){
    $request->validate([
        "Userid"=>"required",
        "Tripid"=>"required",
        "wight"=>"required",

    ]);
    $TripResrve= new ReserveTrip();
    $TripResrve->user_id=$request->Userid;
    $TripResrve->fightCompanyID=$request->Tripid;
    $TripResrve->VisaPhoto=$request->VisaPhoto;
    $TripResrve->Wight=$request->wight;
    $TripResrve->save();

    return response()->json([
        "status"=>"true",
        "message"=>"ok"
    ]);
   }
   public function getActivtyFamilier(){
    $data=activity::where("familier",true)->get();
    return response()->json([
        "status"=>"true",
        "data"=>$data
    ]);
   }
   public function getActivty(){
    $data=activity::get();
    return response()->json([
        "status"=>"true",
        "data"=>$data
    ]);
   }
   public function searchAboutActivity(Request $request){
    $request->validate([
        "nameOfActivity"=>"required"
    ]);
    $nameOfActivity=activity::where('name',$request->name)->first();
    return response()->json([
        "status"=>"OK",
        "data"=>$nameOfActivity
    ]);
   }
   public function getExpert(){
    $Expert=Expert::get();
    return response()->json([
        "status"=>"true",
        "data"=>$Expert
    ]);
   }
   public function SeacrhAboutExpert(Request $request){
    $request->validate([
        "nameOfExpert"=>"required"
    ]);
    $dataOfExpert=Expert::where('name',$request->nameOfExpert)->first();
    return response()->json([
        "status"=>"true",
        "data"=>$dataOfExpert
    ]);
   }
   public function ResevrExpert(Request $requst){
    $requst->validate([
        "iduser"=>"required",
        "nameOfExpert"=>"required",
        "Location"=>"required",
        "DataIn"=>"required",
        "DataOut"=>"required",
    ]);
    $info=new ReserveExpert();
    $info->user_id=$requst->iduser;
    $info->Expert_id=$requst->nameOfExpert;
    $info->DataIn=$requst->DataIn;
    $info->DataOut=$requst->DataOut;
    $info->save();
   }
    public function ImageTest(Request $request){
         return response()->json([
        "status"=>"200",
        "photo"=>"/storage/64d37e8490038.png"
        ]);
    }
}
