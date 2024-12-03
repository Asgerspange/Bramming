<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function addComment(Request $request)
    {
        if (Comment::where('student_id', $request->student_id)->where('user_id', Auth::user()->id)->exists()) {
            return response()->json(['message' => 'You have already commented on this student'], 208);
        }

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

    public function deleteComment(Request $request)
    {
        $request->validate([
            'student_id' => 'required|integer'
        ]);

        $comment = Comment::where('student_id', $request->student_id)->where('user_id', Auth::user()->id)->first();

        if (!$comment) {
            return response()->json(['message' => 'You have not commented on this student yet'], 404);
        }

        $comment->delete();
    }
}
