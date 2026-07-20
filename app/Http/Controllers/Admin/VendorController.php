<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = User::where('role','vendor')
            ->latest()
            ->get();

        return view('admin.vendor.index',compact('vendors'));
    }

    public function create()
    {
        return view('admin.vendor.create');
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'vendor'
        ]);

        return redirect()
            ->route('admin.vendor.index')
            ->with('success','Vendor Created');
    }

    public function edit($id)
    {
        $vendor = User::findOrFail($id);

        return view('admin.vendor.edit',compact('vendor'));
    }

    public function update(Request $request,$id)
    {
        $vendor = User::findOrFail($id);

        $vendor->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect()
            ->route('admin.vendor.index')
            ->with('success','Vendor Updated');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return back()->with('success','Deleted');
    }
}