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
            ['content' => $this->sanitizeHtml($request->content)]
        );

        return back()->with('success', 'Privacy Policy updated successfully.');
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