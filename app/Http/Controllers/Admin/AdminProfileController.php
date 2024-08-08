<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfilePasswordUpdateRequest;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    use FileUploadTrait;
    public function index()
    {
        return view('admin.profile.index');
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = Auth::user();
        $imagePath = $this->uploadImage($request, 'avatar');
        if ($imagePath != null){
            $imagePath;
        }
        else{
            $imagePath = $user->avatar;
        };
         $user->update([
            'name' => $request->name,
            'email' =>$request->email,
            'avatar' => $imagePath
        ]);

        toastr('Updated Successfully','success');
        return redirect()->back();
    }

    public function updatePassword(ProfilePasswordUpdateRequest $request)
    {
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        toastr('Password Updated Successfully','success');

        return redirect()->back();
    }
}
