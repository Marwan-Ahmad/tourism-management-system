<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class profilecontroller extends Controller
{
    //The Profile Of The User
    public function Profile(){
        $user=auth()->user();
        if($user){
        return response()->json([
            "data"=>auth()->user(),
            "message"=>"THis Is The Profile Of The User",
            'status'=>200
        ]);
    }else{
        return response()->json([
            "data"=>[],
            "message"=>"The User Not Found",
            'status'=>404
        ]);
    }
}

    public function updateclientprofile(Request $request){
        $request->validate([
                'Firstname'=>'nullable',
                'Lastname'=>'nullable',
                'visaphoto'=>'nullable',
                'phone'=>'nullable',
                'Nationalty'=>'nullable',
                'email'=>'nullable',
                'password'=>'nullable'
        ]);
        $userinfo=auth()->user();
        if($userinfo){
            if ($request->hasFile('photo')) {
                $oldPhotoPath = str_replace('/storage', '', $userinfo->visaphoto);
                if (Storage::disk('public')->exists($oldPhotoPath)) {
                    Storage::disk('public')->delete($oldPhotoPath);
                }

                $image = $request->file('photo');
                $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->put($fileName, file_get_contents($image));
                $photoPath = Storage::url($fileName);
            } else {

                $photoPath = $userinfo->visaphoto;
            }
                    if(User::query()->where('email',$request->email)->where('id','!=',$userinfo->id)->first()){
                        return response()->json([
                            "data"=>[],
                            "message"=>"the email is used try another email",
                            'status'=>400
                        ]);
                    }
                    if(User::query()->where('phone',$request->phone)->where('id','!=',$userinfo->id)->first()){
                        return response()->json([
                            "data"=>[],
                            "message"=>"the phone is used try another  phone",
                            'status'=>400
                        ]);
                    }

                 User::query()->where('id',$userinfo->id)->update([
                'Firstname'=>$request->Firstname??$userinfo->Firstname,
                'Lastname'=>$request->Lastname??$userinfo->Lastname,
                'visaphoto'=>$photoPath,
                'phone'=>$request->phone??$userinfo->phone,
                'Nationalty'=>$request->Nationalty??$userinfo->Nationalty,
                'email'=>$request->email??$userinfo->email,
                'password'=>bcrypt($request->password??$userinfo->password)
            ]);
            $userupdated=auth()->user();

            return response()->json([
                "data"=>$userupdated,
                "message"=>"updated successfuly",
                'status'=>200
            ]);
        }
        else{
            return response()->json([
                "data"=>[],
                "message"=>"The User Not Found",
                'status'=>404
            ]);
        }
    }
}