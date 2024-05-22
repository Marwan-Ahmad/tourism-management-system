<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait UploadImage
{
    public function StoreImage(Request $request){
        $photo = $request->file('Basicphoto');
        $fileName = uniqid().'.'.$photo->getClientOriginalExtension();
        Storage::disk('public')->put($fileName, file_get_contents($photo));
        $photo=Storage::url($fileName);
        return $photo;
    }
}
