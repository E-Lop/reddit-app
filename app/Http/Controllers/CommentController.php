<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // List of all comments
    public function index()
    {
        return Comment::all();
    }

    // Stores a new comment
    public function store(CommentRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $comment = Comment::create($data);

        return response()->json([
            'status' => 'success',
            'comment' => $comment,
        ]);
    }

    // Shows a specific comment
    public function show($id)
    {
        $comment = Comment::find($id);

        if ($comment === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Comment not found',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'comment' => $comment,
        ]);
    }

    // Updates a specific comment
    public function update(CommentRequest $request, $id)
    {
        $data = $request->all();
        $selected_comment = Comment::find($id);

        if ($selected_comment === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Comment not found',
            ]);
        }

        $selected_comment->update($data);

        return response()->json([
            'status' => 'success',
            'comment' => $selected_comment,
        ]);
    }

    // Deletes a specific comment
    public function destroy($id)
    {
        $comment = Comment::find($id);

        if ($comment === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Comment not found',
            ]);
        }

        $comment->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Comment deleted',
        ]);
    }

    // Lista dei commenti con parent_id
    public function indexOfCommentsWithComments()
    {
        return Comment::whereNotNull('parent_id')->get();
    }

    // Lista dei commenti a un post con i loro figli
    public function indexOfCommentsWithChildren()
    {
        return Comment::whereNull('parent_id')->with('child')->get();
    }

    // Lista dei commenti a cui l'utente ha messo like
    public function commentsLikedByUser()
    {
        return Comment::with('likes')->whereHas('likes', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->get();
    }
}
