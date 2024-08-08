<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppDownloadSectionCreateRequest;
use App\Models\AppDownloadSection;
use App\Traits\FileUploadTrait;
use Hamcrest\Thingy;
use Illuminate\Http\Request;

class AppDownloadSectionController extends Controller
{
    use FileUploadTrait;
    public function index()
    {
        $appSection = AppDownloadSection::first();
        return view('admin.app-download.index', compact('appSection'));
    }

    public function store(AppDownloadSectionCreateRequest $request)
    {
        $imagePath = $this->uploadImage($request, 'image', $request->old_image);
        $backgroundPath = $this->uploadImage($request, 'background', $request->old_background);
        AppDownloadSection::updateOrCreate(
            ['id' => 1],
            [
                'image' => !empty($imagePath) ? $imagePath : $request->old_image,
                'background' => !empty($backgroundPath) ? $backgroundPath : $request->old_background,
                'title' => $request->title,
                'short_description' => $request->short_description,
                'play_store_link' => $request->play_store_link,
                'app_store_link' => $request->app_store_link,
            ]
        );
        toastr()->success('App Download Section created successfully.');
        return redirect()->route('admin.app-download.index');
    }
}
