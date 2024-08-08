<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        $privacy = PrivacyPolicy::first();
        return view('admin.privacy-policy.index', compact('privacy'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'content' => 'required',
        ]);

        PrivacyPolicy::updateOrCreate(
            ['id' => 1],
            [
                'content' => $data['content'],
            ]
        );

        toastr()->success('Created Successfully');
        return redirect()->route('admin.privacy-policy.index');
    }
}
