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
            ['content' => $this->sanitizeHtml($request->content)]
        );

        return back()->with('success', 'Terms & Conditions updated successfully.');
    }

    private function sanitizeHtml($content)
    {
        if (!$content) return '';

        $content = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $content);
        $content = preg_replace('/<iframe\b[^>]*>(.*?)<\/iframe>/is', '', $content);
        $content = preg_replace('/<object\b[^>]*>(.*?)<\/object>/is', '', $content);
        $content = preg_replace('/<embed\b[^>]*>(.*?)<\/embed>/is', '', $content);
        $content = preg_replace('/on[a-z]+\s*=\s*(["\'])[^\1]*?\1/i', '', $content);
        $content = preg_replace('/on[a-z]+\s*=\s*[^"\'\s>]+/i', '', $content);
        $content = preg_replace('/href\s*=\s*(["\'])\s*javascript:[^\1]*?\1/i', 'href="#"', $content);

        return $content;
    }
}