<?php

namespace App\Http\Controllers\SystemAdmin;

use App\Http\Controllers\Controller;
use App\Models\ProductCharge;
use Illuminate\Http\Request;

class ProductChargeController extends Controller
{
    public function index()
    {
        $charge = ProductCharge::firstOrNew([], [
            'title' => 'HYST Additional Charge',
            'percentage' => 0.00,
            'is_active' => true,
        ]);

        return view('system_admin.product_charges.index', compact('charge'));
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'percentage' => 'required|numeric|min:0|max:100',
            'title'      => 'nullable|string|max:255',
            'is_active'  => 'nullable|boolean',
        ]);

        $charge = ProductCharge::first();

        if (!$charge) {
            $charge = new ProductCharge();
        }

        $charge->title = $request->input('title', 'HYST Additional Charge');
        $charge->percentage = (float) $request->input('percentage', 0);
        $charge->is_active = $request->has('is_active') ? (bool) $request->input('is_active') : true;
        $charge->save();

        return redirect()->back()->with('success', 'Product HYST Additional Charge percentage updated successfully!');
    }
}
