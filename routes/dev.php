<?php

use Illuminate\Support\Facades\Route;

Route::get('/login/{id}', function ($id) {
    \Illuminate\Support\Facades\Auth::loginUsingId($id);

    return redirect(route('home'));
})->name('dev.login');
