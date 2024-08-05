<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function addComment(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
            'student_id' => 'required|integer'
        ]);

        Comment::create([
            'comment' => $request->comment,
            'student_id' => $request->student_id,
            'user_id' => Auth::user()->id,
        ]);
    }
}
