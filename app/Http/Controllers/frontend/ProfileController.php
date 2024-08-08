<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfilePasswordUpdateRequest;
use App\Http\Requests\Frontend\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\FileUploadTrait;


class ProfileController extends Controller
{
    use FileUploadTrait;
    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        toastr('User Updated Successfully','success');
        return redirect()->back();
    }

    public function updatePassword(ProfilePasswordUpdateRequest $request)
    {
        $user = Auth::user();
        $user->update([
            'password' => $request->password
        ]);
        toastr('Password Updated Successfully', 'success');

        return redirect()->back();
    }

    public function updateAvatar(Request $request)
    {
        $imagePath = $this->uploadImage($request, 'avatar');

        $user = Auth::user();
        if ($imagePath!=null){
            $imagePath;
        }else{
            $imagePath = $user->avatar;
        }
        $user->update([
            'avatar' => $imagePath
        ]);

        return response(['status' => 'success', 'message' => 'Image Uploaded Successfully']);
    }
}
