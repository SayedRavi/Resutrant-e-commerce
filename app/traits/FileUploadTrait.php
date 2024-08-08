<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Scalar\String_;

trait FileUploadTrait{

//    if the image is not showing  must add a / in front of $path = '/uploads'
    function uploadImage(Request $request, $inputName, $oldPath=NULL, $path = 'uploads'){
        if ($request->hasFile($inputName)){

            $image = $request->{$inputName};
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_'.uniqid().'.'.$ext;

            $image->move(public_path($path), $imageName);
            if ($oldPath && File::exists(public_path($oldPath))){
                File::delete(public_path($oldPath));
            }

            return $path.'/'.$imageName;

        }
        return null;
    }

    public function removeImage($path)
    {
        if (File::exists(public_path($path))){
            File::delete(public_path($path));
        }
    }
}
