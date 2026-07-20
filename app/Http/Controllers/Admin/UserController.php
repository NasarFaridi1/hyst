<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // public function index()
    // {
    //     $users = User::where('role','user')
    //         ->latest()
    //         ->get();

    //     return view('admin.users.index',
    //         compact('users'));
    // }
    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::with('restaurant')
            ->where('role', 'user')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact(
            'users',
            'search'
        ));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return back()->with(
            'success',
            'User Deleted Successfully'
        );
    }
}