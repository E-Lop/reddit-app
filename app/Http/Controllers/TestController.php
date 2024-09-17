<?php

namespace App\Http\Controllers;

use App\Models\Flair;
use App\Models\Post;
use App\Models\Subreddit;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        // return User::with('subreddit_user.subreddit')->get();

        // return User::whereHas('subreddit_user', function ($q) {
        //     $q->where('is_owner', false);
        // })->with('subreddit_user.subreddit')->get();

        // Un sub_reddit può contenere dei flair, che mi permettono di filtrare i sotto-argomenti del sub (i flair per sub, possono essere infiniti)
        return Flair::with('subreddit')->get();

        // Dentro un sub posso fare infiniti post a cui vanno assegnati uno o più flair per capire di cosa parla il post (i flair devono essere quelli del sub associato al post)
        // return Post::all();
    }

    // Posso creare un sub_reddit (i sub possono essere infiniti)
    // public function store(Request $request)
    // {
    //     return Post::create($request->all());
    // }
}
