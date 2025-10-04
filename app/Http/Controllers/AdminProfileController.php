<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    //!THIS IS THE ADMIN PROFILE CONTROLLER WHERE MANAGING OF ADMIN PROFILE IS DONE

   public function profile()
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request, $id)
{
    $admin = Admin::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'password' => 'nullable|string|min:6|confirmed',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $admin->name = $request->name;

    if ($request->password) {
        $admin->password = bcrypt($request->password);
    }

    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/admin_photos'), $filename);
        $admin->photo = $filename;
    }

    $admin->save();

    return redirect()->back()->with('success', 'Profile updated successfully!');
}



}
