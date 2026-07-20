<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;

class TermsAndConditionController extends Controller
{
    

    public function termsAndConditions()
    {
        $terms = TermsAndCondition::first();

        return view('front.terms-and-conditions', compact('terms'));
    }
    public function edit()
    {
        $terms = TermsAndCondition::first();

        return view('admin.terms.edit', compact('terms'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        TermsAndCondition::updateOrCreate(
            ['id' => 1],
            ['content' => $request->content]
        );

        return back()->with('success', 'Terms & Conditions updated successfully.');
    }
}