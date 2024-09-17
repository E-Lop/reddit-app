<?php

use App\Http\Controllers\SubredditController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FlairController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(TestController::class)->prefix('tests')->group(function () {
    Route::get('index2', 'index');
});

// Rotte per l'autenticazione
Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('login', 'login')->withoutMiddleware('auth');
    Route::post('register', 'register')->withoutMiddleware('auth');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

// Rotte per gli user
Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::get('index', 'index');
    Route::get('{user_id}/show', 'show');
    Route::put('{user_id}/update', 'update');
    Route::post('store', 'store');
    Route::delete('{user_id}/destroy', 'destroy');
});

// Rotte per i subreddits
Route::controller(SubredditController::class)->prefix('subreddits')->group(function () {
    Route::get('index', 'index');
    Route::get('{subreddit_id}/show', 'show');
    Route::put('{subreddit_id}/update', 'update');
    Route::post('store', 'store');
    Route::delete('{subreddit_id}/destroy', 'destroy');
    Route::get('indexWithFlair', 'indexWithFlair'); // lista di subreddit con i flair associati
    Route::get('indexWithUser', 'indexWithUser'); // lista di subreddit con gli utenti iscritti
    Route::get('{flair_id}/showByFlairID', 'showByFlairID'); // lista di subreddit con uno specifico flair_id
    Route::get('{subreddit_id}/subWithPosts', 'subWithPosts');
});

// Rotte per i flair
Route::controller(FlairController::class)->prefix('flairs')->group(function () {
    Route::get('index', 'index');
    Route::get('{flair_id}/show', 'show');
    Route::put('{flair_id}/update', 'update');
    Route::post('store', 'store');
    Route::delete('{flair_id}/destroy', 'destroy');
});

// Rotte per i post
Route::controller(PostController::class)->prefix('posts')->group(function () {
    Route::get('index', 'index');
    Route::get('{post_id}/show', 'show');
    Route::put('{post_id}/update', 'update');
    Route::post('store', 'store');
    Route::delete('{post_id}/destroy', 'destroy');
    Route::get('indexWithComments', 'indexWithComments'); // lista di post con i commenti associati
    Route::get('indexWithFlair', 'indexWithFlair'); // lista di post con i flair associati
    Route::get('{flair_id}/showByFlairID', 'showByFlairID'); // lista di post con uno specifico flair_id
});

// Rotte per i commenti
Route::controller(CommentController::class)->prefix('comments')->group(function () {
    Route::get('index', 'index');
    Route::get('{comment_id}/show', 'show');
    Route::put('{comment_id}/update', 'update');
    Route::post('store', 'store');
    Route::delete('{comment_id}/destroy', 'destroy');
    Route::get('indexOfCommentsWithComments', 'indexOfCommentsWithComments'); // lista di commenti a commenti
    Route::get('indexOfCommentsWithChildren', 'indexOfCommentsWithChildren'); // lista dei commenti con i loro commenti
});

// Rotte per i like
Route::controller(LikeController::class)->prefix('likes')->group(function () {
    Route::get('index', 'index');
    Route::get('{like_id}/show', 'show');
    Route::put('{like_id}/update', 'update');
    Route::post('store', 'store');
    Route::delete('{like_id}/destroy', 'destroy');
});
