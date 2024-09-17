<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subreddit;
use App\Models\SubredditUser;
use Illuminate\Support\Facades\Auth;

class SubredditController extends Controller
{
    /**
     * List of all subreddits
     */
    public function index(Request $request)
    {
        $subreddit = Subreddit::query();
        $data = $request->all();

        if (isset($data['flair_id'])) {
            $subreddit->with('flairs')
                ->whereHas('flairs', function ($q) use ($data) {
                    $q->where('id', $data['flair_id']);
                });
        }

        // ricerca per testo in nome o descrizione
        if (isset($data['filter_text'])) {
            $subreddit->where('name', 'like', '%' . $data['filter_text'] . '%')
                ->orWhere('description', 'like', '%' . $data['filter_text'] . '%');
        }
        $subreddit = $subreddit->get();

        if ($subreddit->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nessun subreddit corrisponde al criterio di ricerca',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'subreddit' => $subreddit,
        ], 200);
    }

    /**
     * Stores a new subreddit
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $subreddit = Subreddit::create($data);
        $this->createSubredditUser(Auth::user()->id, $subreddit->id);

        return response()->json([
            'status' => 'success',
            'subreddit' => $subreddit,
        ]);
    }

    public static function createSubredditUser($user_id, $subreddit_id)
    {
        $data = [
            'user_id' => $user_id,
            'subreddit_id' => $subreddit_id,
            'is_owner' => true,
        ];

        SubredditUser::create($data);
    }

    /**
     * Shows a specific subreddit
     */
    public function show($id)
    {
        $subreddit = Subreddit::find($id);

        if ($subreddit === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subreddit not found',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'subreddit' => $subreddit,
        ]);
    }

    /**
     * Updates a specific subreddit
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $selected_subreddit = Subreddit::find($id);

        if ($selected_subreddit === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subreddit not found',
            ]);
        }

        $selected_subreddit->update($data);

        return response()->json([
            'status' => 'success',
            'subreddit' => $selected_subreddit,
        ]);
    }

    /**
     * Deletes a specific subreddit
     */
    public function destroy($id)
    {
        $subreddit = Subreddit::find($id);

        if ($subreddit === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subreddit not found',
            ]);
        }

        $subreddit->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Subreddit deleted',
        ]);
    }

    // lista subreddits con flair
    public function indexWithFlair()
    {
        return Subreddit::with('flairs')->get();
    }

    // lista subreddits con user iscritti
    public function indexWithUser()
    {
        return Subreddit::with('subreddit_user')->get();
    }

    // lista subreddit con flair ${id}
    public function showByFlairID($flair_id)
    {
        $subreddit = Subreddit::with('flairs')
            ->whereHas('flairs', function ($q) use ($flair_id) {
                $q->where('id', $flair_id);
            })
            ->get();

        if ($subreddit->isEmpty()) {
            return response()->json([
                'status' => 'errore',
                'message' => 'Nessun subreddit associato a questo flair',
            ], 400);
        }

        return response()->json([
            'status' => 'Subreddit recuperati con successo',
            'subreddit' => $subreddit,
        ], 200);
    }

    public function subWithPosts($id)
    {
        return Subreddit::with('posts')->find($id);
    }
}
