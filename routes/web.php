<?php

use Illuminate\Support\Facades\Route;

// Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route to handle page reload in Vue except for api routes
Route::get('/{any?}', function () {
    return view('layouts.app');
})->where('any', '^(?!api\/)[\/\w\.-]*');
