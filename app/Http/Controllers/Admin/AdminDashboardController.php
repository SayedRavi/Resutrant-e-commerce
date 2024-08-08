<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderPlacedNotifaction;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function clearNotification()
    {
        $notification = OrderPlacedNotifaction::query()->update(['seen' => 1]);

        toastr()->success('Notifications has been cleared!');
        return redirect()->back();
    }
}
