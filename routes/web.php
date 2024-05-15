<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\RedirectToHomeIfLogin;
use App\Http\Middleware\RedirectToLoginIfNotLogin;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::controller(AuthController::class)->group(function () {
    Route::get("/login", "login")->name('login')->middleware(RedirectToHomeIfLogin::class);
    Route::post("/login", "authenticate")->name('authenticate')->middleware(RedirectToHomeIfLogin::class);
    Route::post("/logout", "logout")->name('logout')->middleware(RedirectToLoginIfNotLogin::class);
});

Route::middleware(RedirectToLoginIfNotLogin::class)->group(function () {

    Route::get('/', function () {
        return redirect()->route('home');
    });

    Route::get('/home', function () {
        return Inertia::render('Home');
    })->name("home");
});

