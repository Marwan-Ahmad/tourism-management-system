<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class profilecontroller extends Controller
{
    //The Profile Of The User
    public function adminProfile(){
        $Admin=auth()->user();
        if($Admin){

            $Admin->visaphoto=url($Admin->visaphoto);
        return response()->json([
            "data"=>auth()->user(),
            "message"=>"THis Is The Profile Of The Admin",
            'status'=>200
        ]);
    }else{
        return response()->json([
            "data"=>[],
            "message"=>"The Admin Not Found",
            'status'=>404
        ]);
    }
}

    public function updateadminprofile(Request $request){
        $request->validate([
                'Firstname'=>'nullable',
                'Lastname'=>'nullable',
                'visaphoto'=>'nullable',
                'phone'=>'nullable',
                'Nationalty'=>'nullable',
                'email'=>'nullable',
                'password'=>'nullable'
        ]);
        $Admininfo=auth()->user();
        if($Admininfo){
            if ($request->hasFile('photo')) {
                $oldPhotoPath = str_replace('/storage', '', $Admininfo->visaphoto);
                if (Storage::disk('public')->exists($oldPhotoPath)) {
                    Storage::disk('public')->delete($oldPhotoPath);
                }

                $image = $request->file('photo');
                $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->put($fileName, file_get_contents($image));
                $photoPath = Storage::url($fileName);
            } else {

                $photoPath = $Admininfo->visaphoto;
            }
                    if(User::query()->where('email',$request->email)->where('id','!=',$Admininfo->id)->first()){
                        return response()->json([
                            "data"=>[],
                            "message"=>"the email is used try another email",
                            'status'=>400
                        ]);
                    }
                    if(User::query()->where('phone',$request->phone)->where('id','!=',$Admininfo->id)->first()){
                        return response()->json([
                            "data"=>[],
                            "message"=>"the phone is used try another  phone",
                            'status'=>400
                        ]);
                    }

              User::query()->where('id',$Admininfo->id)->update([
                'Firstname'=>$request->Firstname??$Admininfo->Firstname,
                'Lastname'=>$request->Lastname??$Admininfo->Lastname,
                'visaphoto'=>$photoPath,
                'phone'=>$request->phone??$Admininfo->phone,
                'Nationalty'=>$request->Nationalty??$Admininfo->Nationalty,
                'email'=>$request->email??$Admininfo->email,
                'password'=>bcrypt($request->password??$Admininfo->password)
            ]);

            $AdminNew = User::query()->where('id',$Admininfo->id)->first();


            return response()->json([
                "data"=>$AdminNew,
                "message"=>"updated successfuly",
                'status'=>200
            ]);
        }
        else{
            return response()->json([
                "data"=>[],
                "message"=>"The Admin Not Found",
                'status'=>404
            ]);
        }
    }
}
