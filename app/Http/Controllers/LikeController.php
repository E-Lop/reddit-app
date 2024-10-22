<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // List of all likes
    public function index()
    {
        return Like::all();
    }

    // Stores a new like
    public function store(Request $request)
    {
        $data = $request->all();
        if ($data['category'] == 'post') {
            $category = 'App\Models\Post';
        } else {
            $category = 'App\Models\Comment';
        }
        info($data);

        $existing_like = Like::where('likeable_id', $data['likeable_id'])
            ->where('likeable_type', $category)
            ->where('user_id', auth()->id())
            ->first();
        if ($existing_like !== null && $existing_like->is_upvoted == $data['is_upvoted']) {
            $existing_like->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Like rimosso',
            ]);
        }
        if ($existing_like !== null && $existing_like->is_upvoted != $data['is_upvoted']) {
            $existing_like->update(['is_upvoted' => $data['is_upvoted']]);
            return response()->json([
                'status' => 'success',
                'message' => 'Like aggiornato',
            ]);
        }


        $data = [
            'user_id' => auth()->id(),
            'likeable_id' => $data['likeable_id'],
            'likeable_type' => $category,
            'is_upvoted' => $data['is_upvoted'],
        ];
        $like = Like::create($data);

        info($like);

        return response()->json([
            'status' => 'success',
            'like' => $like,
        ]);
    }

    // Shows a specific like
    public function show($id)
    {
        $like = Like::find($id);

        if ($like === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Like not found',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'like' => $like,
        ]);
    }

    // Updates a specific like
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $selected_like = Like::find($id);

        if ($selected_like === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Like not found',
            ]);
        }

        $selected_like->update($data);

        return response()->json([
            'status' => 'success',
            'like' => $selected_like,
        ]);
    }

    // Deletes a specific like
    public function destroy($id)
    {
        $like = Like::find($id);

        if ($like === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Like not found',
            ]);
        }

        $like->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Like deleted',
        ]);
    }
}
