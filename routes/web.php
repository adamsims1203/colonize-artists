<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return redirect(route('dashboard'));
});

Route::group(['middleware' => [
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
]], function() {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get("/dashboard/add", function() {
        return Inertia::render('AddArtist');
    })->name('dashboard_add');

    Route::get("/view/{artist}", function($artist) {
        $artist = \App\Models\Artist::findOrFail($artist);

        return Inertia::render('Artist', [
            'artist' => $artist
        ]);
    })->name('view');
});
