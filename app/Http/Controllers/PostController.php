<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\FlairPost;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Subreddit;
use Illuminate\Support\Facades\Auth;
use Psy\Command\WhereamiCommand;

class PostController extends Controller
{
    // List of all posts
    public function index(Request $request)
    {
        $data = $request->all();
        // info($data['subreddit_id']);
        $posts = Post::where('subreddit_id', $data['subreddit_id']);

        /*if (isset($data['filter_text'])) {
            $posts->where('title', 'like', '%' . $data['filter_text'] . '%')
                ->orWhere('body', 'like', '%' . $data['filter_text'] . '%');
        }*/

        if (isset($data['filter_text'])) {
            $posts->where(function ($query) use ($data) {
                $query->where('title', 'like', '%' . $data['filter_text'] . '%')
                    ->orWhere('body', 'like', '%' . $data['filter_text'] . '%');
            });
        }

        if (isset($data['flair_id'])) {
            $posts->whereHas('flair_post', function ($q) use ($data) {
                $q->whereIn('flair_id', $data['flair_id']);
            });
        }

        $perPage = $request->input('per_page', 2);
        $currentPage = $request->input('current_page', 1);

        $posts = $posts
            ->with('flair_post')
            ->with('likes')->withCount('likes');

        if (isset($data['sort_by']) && $data['sort_by'] === 'likes') {
            $posts->orderBy('likes_count', 'desc');
        } else {
            $posts->orderBy('created_at', 'desc');
        }

        // $posts->paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json([
            'status' => 'success',
            'posts' => $posts->paginate($perPage, ['*'], 'page', $currentPage),
        ], 200);
    }

    // Stores a new post
    public function store(Request $request)
    {

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $flairIDs = $data['flairs_id'];
        unset($data['flairs_id']);

        // per aggiungere informazioni a ciò che si riceve
        // $data['like_id'] = $like_id;

        // per eliminare qualcosa dai dati che riceviamo
        // unset($data['like_id']);

        $post = Post::create($data);

        if (isset($flairIDs)) {

            $this->createFlairPost($post->id, $flairIDs, $data['subreddit_id']);
        }

        return response()->json([
            'message' => 'Il post è stato creato con successo',
            'post' => Post::where('id', $post->id)->with('flair_post.flair')->first(),
        ]);
    }

    public static function createFlairPost($post_id, $flairs_id, $subreddit_id)
    {
        info($flairs_id);
        foreach ($flairs_id as $flair_id) {
            $subredCheck = FlairPost::whereHas('flair', function ($q) use ($flair_id, $subreddit_id) {
                $q->where([['id', $flair_id], ['subreddit_id', $subreddit_id]]);
            })->first();
            if ($subredCheck !== null) {
                FlairPost::create([
                    'post_id' => $post_id,
                    'flair_id' => $flair_id,
                ]);
            }
        }
    }

    // Shows a specific post
    public function show($id)
    {
        $data = request()->all();

        //return Subreddit::with('ordered_posts')->get();

        // if (isset($data['order_by']) && $data['order_by'] === 'likes') {
        //     $post = Comment::with('child_by_likes')->find($id);
        // } else if (isset($data['order_by']) && $data['order_by'] === 'date') {
        //     $post = Comment::with('child_by_date')->find($id);
        // } else {
        //     $post = Comment::with('child')->find($id);
        // }

        $post = Post::with(['comments'  => function ($q) use ($data) {
            if (isset($data['order_by']) && $data['order_by'] === 'likes') {
                $q->orderBy('likes_count', 'desc');
            } else {
                $q->orderBy('created_at', 'asc');
            }
        }, 'comments.child'])->find($id);

        // info($data['order_by']);


        // mostra un post con i suoi commenti e i like dei commenti
        /*$post = Post::with('comments.likes', 'comments.parent')->find($id);

*/
        if ($post === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found',
            ]);
        }


        return response()->json([
            'status' => 'success',
            'post' => $post,
        ], 200);

        /* ricorsività
        if ($id != 10) {
            $id = $id + 1;
            $id = $this->show($id);
        }

        return $id;
        */
    }

    // Updates a specific post
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $selected_post = Post::find($id);

        if ($selected_post === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found',
            ]);
        }

        $selected_post->update($data);

        return response()->json([
            'status' => 'success',
            'post' => $selected_post,
        ]);
    }

    // Deletes a specific post
    public function destroy($id)
    {
        $post = Post::find($id);

        if ($post === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found',
            ]);
        }

        $post->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted',
        ]);
    }

    // Lista dei post con commenti
    public function indexWithComments()
    {
        return Post::with('comments')->get();
    }

    // Lista dei post con rispettivi flair
    public function indexWithFlair()
    {
        return Post::with('flair_post.flair')->get();
    }

    // Lista dei post con uno specifico flair_id
    public function showByFlairID($flair_id)
    {
        $posts = Post::with('flair_post')
            ->whereHas('flair_post', function ($q) use ($flair_id) {
                $q->where('flair_id', $flair_id);
            })
            ->get();

        if ($posts->isEmpty()) {
            return response()->json([
                'status' => 'errore',
                'message' => 'Nessun post associato a questo flair',
            ], 400);
        }

        return response()->json([
            'status' => 'Post recuperati con successo',
            'posts' => $posts,
        ], 200);
    }
}
