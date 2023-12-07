<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Comment;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function addComment(Request $request)
    {
        //validation
        $request->validate([
            "message" => "required"
        ]);

        Comment::insert([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);

        // invia notifica
        $notification = array(
            'message' => 'Comment Inserted Successfully, Admin Will Approve',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function comments()
    {
        $comments = Comment::latest()->get();

        return view('backend.comments.all_comments', compact('comments'));
    }

    public function updateStatus(Request $request)
    {
        $comment = Comment::findOrFail($request->comment_id);

        if ($comment->status == 0) {
            $comment->status = 1;
        } else {
            $comment->status = 0;
        }

        $comment->save();

        return response()->json(['message' => 'Comment Status Updated Successfully!']);
    }
}
