<?php

use App\Http\Controllers\IdeasController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'ideas.', 'controller' => IdeasController::class], function () {
    Route::get('/', 'index')->name('ideas');
    Route::get('idea/{slug}', 'show')->name('show');
});

// Socialite
Route::group(['controller' => SocialiteController::class], function () {
    Route::get('/auth/{provaider}', 'redirectToProvider')->name('auth.provider');
    Route::get('/auth/{provaider}/callback', 'handleProviderCallback')->name('auth.callback');
});

// Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
//     Route::get('/dashboard/a', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
