<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.setting.index');
    }

    public function updateGeneralSetting(Request $request)
    {
        $data = $request->validate([
            'site_name' => ['required','max:255'],
            'site_default_currency' => ['required', 'max:4'],
            'site_currency_icon' => ['required', 'max:4'],
            'site_currency_position' => ['required', 'max:6']
        ]);

        foreach ($data as $key => $value){
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        $settings = app(SettingService::class);
        $settings->clearCachedSettings();
        toastr('Created Successfully', 'success');

        return redirect()->back();
    }

    function updatePusherSetting(Request $request)
    {
        $data = $request->validate([
            'pusher_app_id' => ['required'],
            'pusher_key' => ['required'],
            'pusher_secret' => ['required'],
            'pusher_cluster' => ['required']
        ]);

        foreach ($data as $key => $value){
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        $settings = app(SettingService::class);
        $settings->clearCachedSettings();
        toastr('Created Successfully', 'success');

        return redirect()->back();
    }

    public function updateMailSetting(Request $request)
    {
        $data = $request->validate([
            'mail_driver' => ['required'],
            'mail_host' => ['required'],
            'mail_port' => ['required'],
            'mail_user_name' => ['required'],
            'mail_password' => ['required'],
            'mail_encryption' => ['required'],
            'app_email' => ['required'],
            'customer_email' => ['required']
        ]);

        foreach ($data as $key => $value){
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        $settings = app(SettingService::class);
        $settings->clearCachedSettings();
        Cache::forget('mail_settings');
        toastr('Created Successfully', 'success');

        return redirect()->back();
    }
}
