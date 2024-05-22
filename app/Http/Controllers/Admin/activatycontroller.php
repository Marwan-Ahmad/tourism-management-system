<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class activatycontroller extends Controller
{
    //To Input Activaty
    public function InputInformationOfActivity(Request $request){
        $request->validate([
            'photo'=>"required",
            'name'=>"required",
            'location'=>"required",
            'type'=>"required",
            'Rate'=>"required",
            'descreption'=>"required",
            'AirplanePhoto'=>"required",
            'AirplaneName'=>"required",
            'AirplaneLocation'=>"required",
            'AirplaneDescreption'=>"required",
            'AirplaneRate'=>"required",
            'AirplaneServiceFood'=>"required",
            'AirplaneServiceComfarts'=>"required",
            'AirplaneServiceSafe'=>"required",
            'AirplaneAnotherService'=>"required",
            'TripPlace'=>"required",
            'TripToWards'=>"required",
            'TripMonth'=>"required",
            'TripDay'=>"required",
            'TripHour'=>"required",
            'TripPrice'=>"required",
            'HotelPhoto'=>"required",
            'HotelName'=>"required",
            'HotelRate'=>"required",
            'HotelLocation'=>"required",
            'HotelDescreption'=>"required",
            'RoomPhoto1'=>"required",
            'RoomPhoto2'=>"required",
            'RoomPhoto3'=>"required",
            'HotelServiceFood'=>"required",
            'HotelServiceSafe'=>"required",
            'HotelServiceComforts'=>"required",
            'HotelAnotherService'=>"required",
            'HotelPrice'=>"required",
            'HotelFirstDay'=>"required",
            'HotelLastDay'=>"required",
            'TouristPlacePhoto'=>"required",
            'TouristPlaceName'=>"required",
            'TouristPlaceRate'=>"required",
            'TouristPlaceLocation'=>"required",
            'TouristPlaceBestTime'=>"required",
            'TouristPlaceDescreption'=>"required",
            'TouristPlaceUniqueStuff'=>"required",
            'TouristPlaceServiceFood'=>"required",
            'TouristPlaceServiceSafe'=>"required",
            'TouristPlaceServiceComforts'=>"required",
            'TouristPlaceAnotherService'=>"required",
            'ExpertPhoto'=>"required",
            'ExpertName'=>"required",
            'ExpertRate'=>"required",
            'ExpertLocation'=>"required",
            'ExpertEducation'=>"required",
            'ExpertDescreption'=>"required",
            'ExpertLanguage'=>"required",
            'ExpertExperience'=>"required",
            'ExpertFirstDay'=>"required",
            'ExpertLastDay'=>"required",
            'ExpertFirstTime'=>"required",
            'ExpertLastTime'=>"required",
            'ExpertPrice'=>"required",
        ]);##########activity photo
        $photo = $request->file('photo');
        $fileName = uniqid().'.'. $photo->getClientOriginalExtension();
        Storage::disk('public')->put($fileName, file_get_contents( $photo));
        $photo=Storage::url($fileName);
        ########################### AirplanePhoto
        $AirplanePhoto = $request->file('AirplanePhoto');
        $fileName = uniqid().'.'. $AirplanePhoto->getClientOriginalExtension();
        Storage::disk('public')->put($fileName, file_get_contents( $AirplanePhoto));
        $AirplanePhoto=Storage::url($fileName);
        ########################### HotelPhoto
        $HotelPhoto = $request->file('HotelPhoto');
        $fileName = uniqid().'.'. $HotelPhoto->getClientOriginalExtension();
        Storage::disk('public')->put($fileName, file_get_contents( $HotelPhoto));
        $HotelPhoto=Storage::url($fileName);
        ########################### RoomPhoto1
        $RoomPhoto1 = $request->file('RoomPhoto1');
        $fileName = uniqid().'.'. $RoomPhoto1->getClientOriginalExtension();
        Storage::disk('public')->put($fileName, file_get_contents( $RoomPhoto1));
        $RoomPhoto1=Storage::url($fileName);
        ########################### RoomPhoto2
        $RoomPhoto2 = $request->file('RoomPhoto2');
        $fileName = uniqid().'.'. $RoomPhoto2->getClientOriginalExtension();
        Storage::disk('public')->put($fileName, file_get_contents( $RoomPhoto2));
        $RoomPhoto2=Storage::url($fileName);
        ########################### RoomPhoto3
        $RoomPhoto3 = $request->file('RoomPhoto3');
        $fileName = uniqid().'.'. $RoomPhoto3->getClientOriginalExtension();
        Storage::disk('public')->put($fileName, file_get_contents( $RoomPhoto3));
        $RoomPhoto3=Storage::url($fileName);
        ########################### TouristPlacePhoto
        $TouristPlacePhoto = $request->file('TouristPlacePhoto');
        $fileName = uniqid().'.'. $TouristPlacePhoto->getClientOriginalExtension();
        Storage::disk('public')->put($fileName, file_get_contents( $TouristPlacePhoto));
        $TouristPlacePhoto=Storage::url($fileName);
        ########################### ExpertPhoto
        $ExpertPhoto = $request->file('ExpertPhoto');
        $fileName = uniqid().'.'. $ExpertPhoto->getClientOriginalExtension();
        Storage::disk('public')->put($fileName, file_get_contents( $ExpertPhoto));
        $ExpertPhoto=Storage::url($fileName);
        ####################Save Information
       $activity = new Activity();
       $activity->name=$request->name;
       $activity->photo= $photo;
       $activity->location=$request->location;
       $activity->type=$request->type;
       $activity->Rate=$request->Rate;
       $activity->descreption=$request->descreption;
       $activity->AirplanePhoto=$AirplanePhoto;
       $activity->AirplaneName=$request->AirplaneName;
       $activity->AirplaneRate=$request->AirplaneRate;
       $activity->AirplaneDescreption=$request->AirplaneDescreption;
       $activity->AirplaneServiceFood=$request->AirplaneServiceFood;
       $activity->AirplaneLocation=$request->AirplaneLocation;
       $activity->AirplaneServiceComfarts=$request->AirplaneServiceComfarts;
       $activity->AirplaneAnotherService=$request->AirplaneAnotherService;
       $activity->AirplaneServiceSafe=$request->AirplaneServiceSafe;
       $activity->TripPlace=$request->TripPlace;
       $activity->TripToWards=$request->TripToWards;
       $activity->TripDay=$request->TripDay;
       $activity->TripMonth=$request->TripMonth;
       $activity->TripHour=$request->TripHour;
       $activity->TripPrice=$request->TripPrice;
       $activity->HotelPhoto=$HotelPhoto;
       $activity->HotelName=$request->HotelName;
       $activity->HotelRate=$request->HotelRate;
       $activity->HotelLocation=$request->HotelLocation;
       $activity->HotelDescreption=$request->HotelDescreption;
       $activity->RoomPhoto1=$RoomPhoto1;
       $activity->RoomPhoto2=$RoomPhoto2;
       $activity->RoomPhoto3=$RoomPhoto3;
       $activity->HotelServiceFood=$request->HotelServiceFood;
       $activity->HotelServiceComforts=$request->HotelServiceComforts;
       $activity->HotelServiceSafe=$request->HotelServiceSafe;
       $activity->HotelAnotherService=$request->HotelAnotherService;
       $activity->HotelPrice=$request->HotelPrice;
       $activity->HotelFirstDay=$request->HotelFirstDay;
       $activity->HotelLastDay=$request->HotelLastDay;
       $activity->TouristPlacePhoto=$TouristPlacePhoto;
       $activity->TouristPlaceName=$request->TouristPlaceName;
       $activity->TouristPlaceRate=$request->TouristPlaceRate;
       $activity->TouristPlaceLocation=$request->TouristPlaceLocation;
       $activity->TouristPlaceBestTime=$request->TouristPlaceBestTime;
       $activity->TouristPlaceDescreption=$request->TouristPlaceDescreption;
       $activity->TouristPlaceUniqueStuff=$request->TouristPlaceUniqueStuff;
       $activity->TouristPlaceServiceFood=$request->TouristPlaceServiceFood;
       $activity->TouristPlaceServiceSafe=$request->TouristPlaceServiceSafe;
       $activity->TouristPlaceServiceComforts=$request->TouristPlaceServiceComforts;
       $activity->TouristPlaceAnotherService=$request->TouristPlaceAnotherService;
       $activity->ExpertPhoto=$ExpertPhoto;
       $activity->ExpertName=$request->ExpertName;
       $activity->ExpertRate=$request->ExpertRate;
       $activity->ExpertLocation=$request->ExpertLocation;
       $activity->ExpertEducation=$request->ExpertEducation;
       $activity->ExpertDescreption=$request->ExpertDescreption;
       $activity->ExpertLanguage=$request->ExpertLanguage;
       $activity->ExpertExperience=$request->ExpertExperience;
       $activity->ExpertLastDay=$request->ExpertLastDay;
       $activity->ExpertFirstDay=$request->ExpertFirstDay;
       $activity->ExpertFirstTime=$request->ExpertDescreption;
       $activity->ExpertLastTime=$request->ExpertLastTime;
       $activity->ExpertPrice=$request->ExpertPrice;
       $activity->save();
       return response()->json([
            "status"=>"200",
            "message"=>"the information of Activtiy Place saved  "
        ]);
    }

    //To Delete Activaty
    public function DropActivtiy(Request $request){
        $request->validate([
            "IdOfActivity"=>"required"
        ]);
        $Activty=Activity::where('id',$request->IdOfActivity)->first();
        if(!$Activty){
            return response()->json([
                "status"=>"200",
                "messgae"=>"the Expert not found "
            ]);}
            Activity::where('id',$request->IdOfActivity)->delete();
        return response()->json([
            "status"=>"200",
            "messgae"=>"the Activity is deleted"
        ]);
    }

    //To Update Activaty
    public function UpdateInformationActivity(Request $request){
        $request->validate([
            "IdOfActivity"=>"required",
            // 'photo'=>"required",
            'name'=>"required",
            'location'=>"required",
            'type'=>"required",
            'Rate'=>"required",
            'descreption'=>"required",
            // 'AirplanePhoto'=>"required",
            'AirplaneName'=>"required",
            'AirplaneLocation'=>"required",
            'AirplaneRate'=>"required",
            'AirplaneDescreption'=>"required",
            'AirplaneServiceFood'=>"required",
            'AirplaneServiceComfarts'=>"required",
            'AirplaneServiceSafe'=>"required",
            'AirplaneAnotherService'=>"required",
            'TripPlace'=>"required",
            'TripToWards'=>"required",
            'TripMonth'=>"required",
            'TripDay'=>"required",
            'TripHour'=>"required",
            'TripPrice'=>"required",
            // 'HotelPhoto'=>"required",
            'HotelName'=>"required",
            'HotelRate'=>"required",
            'HotelLocation'=>"required",
            'HotelDescreption'=>"required",
            // 'RoomPhoto1'=>"required",
            // 'RoomPhoto2'=>"required",
            // 'RoomPhoto3'=>"required",
            'HotelServiceFood'=>"required",
            'HotelServiceSafe'=>"required",
            'HotelServiceComforts'=>"required",
            'HotelAnotherService'=>"required",
            'HotelPrice'=>"required",
            'HotelFirstDay'=>"required",
            'HotelLastDay'=>"required",
            // 'TouristPlacePhoto'=>"required",
            'TouristPlaceName'=>"required",
            'TouristPlaceRate'=>"required",
            'TouristPlaceLocation'=>"required",
            'TouristPlaceBestTime'=>"required",
            'TouristPlaceDescreption'=>"required",
            'TouristPlaceUniqueStuff'=>"required",
            'TouristPlaceServiceFood'=>"required",
            'TouristPlaceServiceSafe'=>"required",
            'TouristPlaceServiceComforts'=>"required",
            'TouristPlaceAnotherService'=>"required",
            // 'ExpertPhoto'=>"required",
            'ExpertName'=>"required",
            'ExpertRate'=>"required",
            'ExpertLocation'=>"required",
            'ExpertEducation'=>"required",
            'ExpertDescreption'=>"required",
            'ExpertLanguage'=>"required",
            'ExpertExperience'=>"required",
            'ExpertFirstDay'=>"required",
            'ExpertLastDay'=>"required",
            'ExpertFirstTime'=>"required",
            'ExpertLastTime'=>"required",
            'ExpertPrice'=>"required",
        ]);##########activity photo
        // $photo = $request->file('photo');
        // $fileName = uniqid().'.'. $photo->getClientOriginalExtension();
        // Storage::disk('public')->put($fileName, file_get_contents( $photo));
        // $photo=Storage::url($fileName);
        // ########################### AirplanePhoto
        // $AirplanePhoto = $request->file('photo');
        // $fileName = uniqid().'.'. $AirplanePhoto->getClientOriginalExtension();
        // Storage::disk('public')->put($fileName, file_get_contents( $AirplanePhoto));
        // $AirplanePhoto=Storage::url($fileName);
        // ########################### HotelPhoto
        // $HotelPhoto = $request->file('photo');
        // $fileName = uniqid().'.'. $HotelPhoto->getClientOriginalExtension();
        // Storage::disk('public')->put($fileName, file_get_contents( $HotelPhoto));
        // $HotelPhoto=Storage::url($fileName);
        // ########################### RoomPhoto1
        // $RoomPhoto1 = $request->file('photo');
        // $fileName = uniqid().'.'. $RoomPhoto1->getClientOriginalExtension();
        // Storage::disk('public')->put($fileName, file_get_contents( $RoomPhoto1));
        // $RoomPhoto1=Storage::url($fileName);
        // ########################### RoomPhoto2
        // $RoomPhoto2 = $request->file('photo');
        // $fileName = uniqid().'.'. $RoomPhoto2->getClientOriginalExtension();
        // Storage::disk('public')->put($fileName, file_get_contents( $RoomPhoto2));
        // $RoomPhoto2=Storage::url($fileName);
        // ########################### RoomPhoto3
        // $RoomPhoto3 = $request->file('photo');
        // $fileName = uniqid().'.'. $RoomPhoto3->getClientOriginalExtension();
        // Storage::disk('public')->put($fileName, file_get_contents( $RoomPhoto3));
        // $RoomPhoto3=Storage::url($fileName);
        // ########################### TouristPlacePhoto
        // $TouristPlacePhoto = $request->file('photo');
        // $fileName = uniqid().'.'. $TouristPlacePhoto->getClientOriginalExtension();
        // Storage::disk('public')->put($fileName, file_get_contents( $TouristPlacePhoto));
        // $TouristPlacePhoto=Storage::url($fileName);
        // ########################### ExpertPhoto
        // $ExpertPhoto = $request->file('photo');
        // $fileName = uniqid().'.'. $ExpertPhoto->getClientOriginalExtension();
        // Storage::disk('public')->put($fileName, file_get_contents( $ExpertPhoto));
        // $ExpertPhoto=Storage::url($fileName);
        ###############################update######################
        Activity::where('id',$request->IdOfActivity)->update([
            'name'=>$request->name,
            'location'=>$request->location,
            'descreption'=>$request->descreption,
            'type'=> $request->type,
            'Rate'=> $request->Rate,
            // 'photo'=>$photo,
            // 'AirplanePhoto'=> $AirplanePhoto,
            'AirplaneName'=> $request->AirplaneName,
            'AirplaneLocation'=> $request->AirplaneLocation,
            'AirplaneDescreption'=> $request->AirplaneDescreption,
            'AirplaneServiceFood'=> $request->AirplaneServiceFood,
            'AirplaneServiceComfarts'=> $request->AirplaneServiceComfarts,
            'AirplaneServiceSafe'=> $request->AirplaneServiceSafe,
            'AirplaneAnotherService'=> $request->AirplaneAnotherService,
            'AirplaneRate'=> $request->AirplaneRate,
            'TripPlace'=> $request->TripPlace,
            'TripToWards'=> $request->TripToWards,
            'TripMonth'=> $request->TripMonth,
            'TripDay'=> $request->TripDay,
            'TripHour'=> $request->TripHour,
            'TripPrice'=> $request->TripPrice,
            // 'HotelPhoto'=> $HotelPhoto,
            'HotelName'=> $request->HotelName,
            'HotelRate'=> $request->HotelRate,
            'HotelLocation'=> $request->HotelLocation,
            'HotelDescreption'=> $request->TripHour,
            // 'RoomPhoto1'=>  $RoomPhoto1,
            // 'RoomPhoto2'=>  $RoomPhoto2,
            // 'RoomPhoto2'=>  $RoomPhoto3,
            'HotelServiceFood'=> $request->HotelServiceFood,
            'HotelServiceSafe'=> $request->HotelServiceSafe,
            'HotelServiceComforts'=> $request->HotelServiceComforts,
            'HotelAnotherService'=> $request->HotelAnotherService,
            'HotelPrice'=> $request->HotelPrice,
            'HotelFirstDay'=> $request->HotelFirstDay,
            'HotelLastDay'=> $request->HotelLastDay,
            // 'TouristPlacePhoto'=>$TouristPlacePhoto,
            'TouristPlaceName'=> $request->TouristPlaceName,
            'TouristPlaceRate'=> $request->TouristPlaceRate,
            'TouristPlaceLocation'=> $request->TouristPlaceLocation,
            'TouristPlaceBestTime'=> $request->TouristPlaceBestTime,
            'TouristPlaceDescreption'=> $request->TouristPlaceDescreption,
            'TouristPlaceUniqueStuff'=> $request->TouristPlaceUniqueStuff,
            'TouristPlaceServiceFood'=> $request->TouristPlaceServiceFood,
            'TouristPlaceServiceSafe'=> $request->TouristPlaceServiceSafe,
            'TouristPlaceServiceComforts'=> $request->TouristPlaceServiceComforts,
            'TouristPlaceAnotherService'=> $request->TouristPlaceAnotherService,
            // 'ExpertPhoto'=> $ExpertPhoto,
            'ExpertName'=> $request->ExpertName,
            'ExpertRate'=> $request->ExpertRate,
            'ExpertLocation'=> $request->ExpertLocation,
            'ExpertEducation'=> $request->ExpertEducation,
            'ExpertDescreption'=> $request->ExpertDescreption,
            'ExpertLanguage'=> $request->ExpertLanguage,
            'ExpertExperience'=> $request->ExpertExperience,
            'ExpertFirstDay'=> $request->ExpertFirstDay,
            'ExpertLastDay'=> $request->ExpertLastDay,
            'ExpertFirstTime'=> $request->ExpertFirstTime,
            'ExpertLastTime'=> $request->ExpertLastTime,
            'ExpertPrice'=> $request->ExpertPrice,
        ]);
        return response()->json([
            "status"=>"200",
            "message"=>"the information of Activity  Udpated "
        ]);
    }
}