<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('posts.index'));

// 1 baris -> 7 route bernama: posts.index, create, store, show, edit, update, destroy
Route::resource('posts', PostController::class);
