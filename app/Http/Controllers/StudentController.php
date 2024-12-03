<?php

namespace App\Http\Controllers;

use App\Models\{
    Student,
    ProfilePicture
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unilogin_user' => 'required|string|max:255|unique:students',
            'password' => 'required|string|min:8',
        ]);

        Student::create([
            'name' => $request->name,
            'unilogin_user' => $request->unilogin_user,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'User registered successfully!');
    }

    public function login(Request $request)
    {
        $request->validate([
            'unilogin_user' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        $student = Student::where('unilogin_user', $request->unilogin_user)->with('comments')->with('commentedOn')->first();

        if (!$student || !Hash::check($request->password, $student->password)) {
            return redirect()->back()->with('error', 'Invalid credentials!');
        }

        Auth::login($student);

        return redirect('/');
    }

    public function studentImage(Request $request)
    {
        $student = Auth::user();
        ProfilePicture::updateOrCreate(
            ['unilogin' => $student->unilogin_user],
            ['picture' => $request->image]
        );


        return redirect()->back()->with('success', 'Profile picture uploaded successfully!');
    }
}
