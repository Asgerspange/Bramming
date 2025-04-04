<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\ProfilePicture;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RouteController extends Controller
{
    public function students()
    {
        $students = Student::with('profilePicture')->whereNot('id', Auth::id())->get();

        return Inertia::render('Students', ['students' => $students]);
    }

    public function admin()
    {
        return Inertia::render('Admin');
    }

    public function student(Student $student)
    {
        $student = $student->load('profilePicture');
        $comment = Comment::where('student_id', $student->id)->where('user_id', Auth::id())->first();

        return Inertia::render('Student/Student', ['student' => $student, 'comment' => $comment]);
    }

    public function profile()
    {
        $student = Student::with('commentedOn')->with('profilePicture')->find(Auth::id());
        $students = $student->usersNotCommentedOn();

        $totalStudents = Student::count() - 1;
        $totalComments = $totalStudents - $students->count();

        return Inertia::render('Profile', ['student' => $student, 'students' => $students, 'totalComments' => $totalComments, 'totalStudents' => $totalStudents, 'downloadVisible' => config('admin.downloadVisible')]);
    }

    public function users()
    {
        $students = Student::with('profilePicture')->get();

        return Inertia::render('Admin/Users', ['users' => $students]);
    }

    public function actions()
    {
        return Inertia::render('Admin/Actions', ['downloadVisible' => config('admin.downloadVisible')]);
    }
}
