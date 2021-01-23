<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LobbyController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/home', '/', 301);
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/how-to-play', [HomeController::class, 'howToPlay'])->name('how_to_play');

// --- Authenticated Customer --- //
Route::middleware('players')->group(function () {

    // ---> GAME
    Route::prefix('play')->group(function () {
        Route::get('/', [LobbyController::class, 'index'])->name('find.game');
        Route::post('/join', [LobbyController::class, 'joinPrivateGame'])->name('join.game');
        Route::get('/lobby/{session_id}', [LobbyController::class, 'lobby'])->name('game.lobby');
        Route::get('/game/{session_id}', [LobbyController::class, 'play'])->name('play.game');
    });

    Route::post('create/game', [LobbyController::class, 'createGame'])->name('create.game');

    // ---> PROFILE
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('user.profile');
    });
});

Auth::routes();
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout');
