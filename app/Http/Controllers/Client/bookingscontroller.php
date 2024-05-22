<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\ActivtiyReserve;
use App\Models\reserveExpert;
use App\Models\reserveTrip;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class bookingscontroller extends Controller
{
    // Check Booking Expert
    public function CheckBookingExpert(Request $request){
        $request->validate([
            "email"=>"required"
        ]);
        $User=User::where('email',$request->email)->first();
        if(!$User){
            return response()->json([
                "sattus"=>"200",
                "Message"=>"not found this email"
            ]);
        }
        $UserId=$User->id;
        $user1=reserveExpert::where('users_id', $UserId)->get();
        if( count($user1) === 0){
            return response()->json([
                "message"=>"ok",
                "RserveExperts"=>  "you are not booking any Expert"
            ]);
        }
        $RserveExperts=User::with(['RserveExperts'=>function($q){
            $q->select(['name','location','descreption','photo','Experience','language',
            'Eduction','Experience','Rate',])->get();
        }])->where('id',$UserId)->select('id')->get();
        return response()->json([
            "message"=>"ok",
            "RserveExperts"=> $RserveExperts
        ]);
    }

    //Check Booking Hotel
    public function CheckBookingHotels(Request $request){
        $request->validate([
            "email"=>"required"
        ]);
        $User=User::where('email',$request->email)->first();
        if(!$User){
            return response()->json([
                "sattus"=>"200",
                "Message"=>"not found this email"
            ]);
        }
        $UserId=$User->id;
        $user1=Room::where('users_id', $UserId)->get();
        if( count($user1) === 0){
            return response()->json([
                "message"=>"200",
                "RserveExperts"=>  "you are not booking any Filght Trip"
            ]);
        }
        $RserveTrips=User::with('RserveHotels')->where('id',$UserId)->get();
        return response()->json([
            "message"=>"200",
            "RserveTrips"=>$RserveTrips
        ]);
    }

    //Check Booking Activity
    public function CheckBookingActivity(Request $request){
        $request->validate([
            "email"=>"required"
        ]);
        $User=User::where('email',$request->email)->first();
        if(!$User){
            return response()->json([
                "sattus"=>"200",
                "Message"=>"not found this email"
            ]);
        }
        $UserId=$User->id;
        $user1=ActivtiyReserve::where('users_id', $UserId)->get();
        if( count($user1) === 0){
            return response()->json([
                "message"=>"200",
                "RserveExperts"=>  "you are not booking any Filght Trip"
            ]);
        }
        $Rserveactivity=User::with('Rserveactivity')->where('id',$UserId)->get();
        return response()->json([
            "message"=>"200",
            "RserveTrips"=>$Rserveactivity
        ]);
    }

    //Check Booking Trips
    public function CheckBookingTrips(Request $request){
        $request->validate([
            "email"=>"required"
        ]);
        $User=User::where('email',$request->email)->first();
        if(!$User){
            return response()->json([
                "sattus"=>"200",
                "Message"=>"not found this email"
            ]);
        }
        $UserId=$User->id;
        $user1=reserveTrip::where('users_id', $UserId)->get();
        if( count($user1) === 0){
            return response()->json([
                "message"=>"200",
                "RserveExperts"=>  "you are not booking any Filght Trip"
            ]);
        }
        $RserveTrips=User::with('RserveTrips')->where('id',$UserId)->get();
        return response()->json([
            "message"=>"200",
            "RserveTrips"=>$RserveTrips
        ]);
    }
}
