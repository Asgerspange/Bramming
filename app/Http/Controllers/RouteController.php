<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RouteController extends Controller
{
    public function students()
    {
        $students = Student::with('comments')->with('commentedOn')->get();
        // $student = Student::with('comments')->with('commentedOn')->find(Auth::id());

        foreach ($students as $d) {
            foreach ($d->comments as $comment) {
                $comment->author = Student::find($comment->user_id);
            }
        }

        return Inertia::render('Students', ['students' => $students]);
    }

    public function student(Request $request)
    {
        $student = Student::with('comments')->with('commentedOn')->where('unilogin_user', $request->unilogin)->first();
        
        foreach ($student->comments as &$comment) {
            $comment->author = Student::find($comment->user_id);
        }

        return Inertia::render('Student/Student', ['student' => $student]);
    }
}
