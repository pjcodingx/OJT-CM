<?php

namespace App\Http\Controllers\faculty;

use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FacultyProfileController extends Controller
{
    public function show(){
        $faculty = Auth::guard('faculty')->user();

        return view('faculty.profile', compact('faculty'));
    }

    public function updatePhoto(Request $request, $id){
        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);

        $faculty = Faculty::findOrFail($id);

         if ($request->hasFile('photo')) {
            $filename = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads/faculty_photos'), $filename);
            $faculty->photo = $filename;
            $faculty->save();
        }

        return back()->with('success', 'Profile photo updated successfully.');
    }

    public function changePassword(){
        $faculty = Auth::guard('faculty')->user();


        return view('faculty.change-password', compact('faculty'));
    }

     public function updatePassword(Request $request){
        $faculty = Auth::guard('faculty')->user();

        $validated = $request->validate([
            'password' => 'required|min:8|confirmed',

        ]);


    Faculty::where('id', $faculty->id)
        ->update(['password' => Hash::make($validated['password'])]);

        return redirect()->back()->with('success', 'Password Successfuly Changed!');

    }
}
