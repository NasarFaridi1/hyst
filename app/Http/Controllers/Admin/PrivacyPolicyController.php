<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function privacy()
    {
        $privacy = PrivacyPolicy::first();

        return view('front.privacy', compact('privacy'));
    }
    public function edit()
    {
        $privacy = PrivacyPolicy::first();

        return view('admin.privacy.edit', compact('privacy'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        PrivacyPolicy::updateOrCreate(
            ['id' => 1],
            ['content' => $request->content]
        );

        return back()->with('success', 'Privacy Policy updated successfully.');
    }
}