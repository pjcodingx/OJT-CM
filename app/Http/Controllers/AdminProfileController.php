<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    //!THIS IS THE ADMIN PROFILE CONTROLLER WHERE MANAGING OF ADMIN PROFILE IS DONE

    public function update(Request $request){



    $admin = Admin::find(Auth::guard('admin')->id());

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/admin_photos'), $filename);
            $admin->photo = 'uploads/admin_photos/' . $filename;
        }

        $admin->save();

        return redirect()->route('admin.dashboard')->with('success', 'Profile updated successfully!');


    }

    public function edit()
    {
        return view('admin.profile.edit');
    }



}
