<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MatchdayCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MatchdayCampaignController extends Controller
{
    /**
     * Display a listing of campaigns.
     */
    public function index()
    {
        $campaigns = MatchdayCampaign::latest()->paginate(10);
        return view('admin.matchday.campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new campaign.
     */
    public function create()
    {
        return view('admin.matchday.campaigns.create');
    }

    /**
     * Store a newly created campaign.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'min_order_amount' => 'required|numeric|min:0',
            'choices_per_order' => 'required|integer|min:1|max:10',
            'entitlement_expiry_days' => 'required|integer|min:1|max:365',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'nullable|boolean',
        ]);

        MatchdayCampaign::create([
            'name' => trim($request->name),
            'slug' => Str::slug($request->name) . '-' . time(),
            'description' => $request->description,
            'min_order_amount' => $request->min_order_amount,
            'choices_per_order' => (int) $request->choices_per_order,
            'entitlement_expiry_days' => (int) $request->entitlement_expiry_days,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.matchday.campaigns.index')
            ->with('success', "Campaign \"{$request->name}\" created successfully!");
    }

    /**
     * Show the form for editing the specified campaign.
     */
    public function edit($id)
    {
        $campaign = MatchdayCampaign::findOrFail($id);
        return view('admin.matchday.campaigns.edit', compact('campaign'));
    }

    /**
     * Update the specified campaign.
     */
    public function update(Request $request, $id)
    {
        $campaign = MatchdayCampaign::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'min_order_amount' => 'required|numeric|min:0',
            'choices_per_order' => 'required|integer|min:1|max:10',
            'entitlement_expiry_days' => 'required|integer|min:1|max:365',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'nullable|boolean',
        ]);

        $campaign->update([
            'name' => trim($request->name),
            'description' => $request->description,
            'min_order_amount' => $request->min_order_amount,
            'choices_per_order' => (int) $request->choices_per_order,
            'entitlement_expiry_days' => (int) $request->entitlement_expiry_days,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.matchday.campaigns.index')
            ->with('success', "Campaign \"{$campaign->name}\" updated successfully!");
    }

    /**
     * Remove the specified campaign.
     */
    public function destroy($id)
    {
        $campaign = MatchdayCampaign::findOrFail($id);
        $name = $campaign->name;
        $campaign->delete();

        return redirect()->route('admin.matchday.campaigns.index')
            ->with('success', "Campaign \"{$name}\" deleted successfully.");
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus($id)
    {
        $campaign = MatchdayCampaign::findOrFail($id);
        $campaign->is_active = !$campaign->is_active;
        $campaign->save();

        $statusText = $campaign->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Campaign \"{$campaign->name}\" is now {$statusText}.");
    }
}
