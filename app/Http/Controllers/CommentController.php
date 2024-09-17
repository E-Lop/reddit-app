<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    // List of all comments
    public function index()
    {
        return Comment::all();
    }

    // Stores a new comment
    public function store(Request $request)
    {
        $data = $request->all();
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
    public function update(Request $request, $id)
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
}
