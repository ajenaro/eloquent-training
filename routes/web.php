<?php

use App\User;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/has-one', function () {

    $user = App\User::first();

    return $user->profile;
});

Route::get('/has-many', function () {

    $user = App\User::first();

    return $user->posts;
});

Route::get('filter-query', function () {

    $user = User::first();

    return $user->posts()
        ->where('featured', true)
        ->where('published_at', '<=', now())
        ->get();
});

Route::get('filter-collection', function () {

    $user = User::first();

    return $user->posts
        ->where('featured', true)
        ->where('published_at', '<=', now());
});
