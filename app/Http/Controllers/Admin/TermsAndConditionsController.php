<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use App\Models\TermsAndConditions;
use Illuminate\Http\Request;

class TermsAndConditionsController extends Controller
{
    public function index()
    {
        $terms = TermsAndConditions::first();
        return view('admin.terms-and-conditions.index', compact('terms'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'content' => 'required',
        ]);

        TermsAndConditions::updateOrCreate(
            ['id' => 1],
            [
                'content' => $data['content'],
            ]
        );

        toastr()->success('Created Successfully');
        return redirect()->route('admin.terms-and-conditions.index');
    }
}
