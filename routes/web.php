<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkerController;
use App\Http\Middleware\RedirectToHomeIfLogin;
use App\Http\Middleware\RedirectToLoginIfNotLogin;
use App\Models\Department;
use App\Models\Position;
use App\Models\Worker;
use App\Models\Log;
use App\Models\User;
use App\Models\Product;
use App\Models\Material;
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
        return Inertia::render('Home', [
            "departments" => Department::count(),
            "positions" => Position::count(),
            "workers" => Worker::count(),
            "materials" => Material::count(),
            "products" => Product::count(),
            "users" => User::count(),
            "logs" => Log::count(),
        ]);
    })->name("home");

    Route::controller(DepartmentController::class)->group(function () {
        Route::get("/departments", "index")->name("departments.index");
        Route::post("/departments", "store")->name("departments.store");
        Route::put("/departments/{department}", "update")->name("departments.update");
        Route::delete("/departments/{department}", "destroy")->name("departments.destroy");
    });

    Route::controller(PositionController::class)->group(function () {
        Route::get("/positions", "index")->name("positions.index");
        Route::delete("/positions/{position}", "destroy")->name("positions.destroy");
        Route::put("/positions/{position}", "update")->name("positions.update");
        Route::post("/positions", "store")->name("positions.store");
    });

    Route::controller(WorkerController::class)->group(function () {
        Route::get("/workers", "index")->name("workers.index");
        Route::post("/workers", "store")->name("workers.store");
        Route::put("/workers/{worker}", "update")->name("workers.update");
        Route::get("/workers/csv", "downloadCSV")->name("workers.download");
        Route::delete("/workers/{worker}", "destroy")->name("workers.destroy");
    });

    Route::controller(LogController::class)->group(function () {
        Route::get("/logs", "index")->name("logs.index");
        Route::get("/logs/json", "downloadJSON")->name("logs.download");
    });

    Route::controller(MaterialController::class)->group(function () {
        Route::get("/materials", "index")->name("materials.index");
        Route::delete("/materials/{material}", "destroy")->name("materials.destroy");
        Route::post("/materials", "store")->name("materials.store");
        Route::put("/materials/{material}", "update")->name("materials.update");
        Route::put("/materials/{material}/add-amount", "addAmount")->name("materials.addAmount");
        Route::put("/materials/{material}/remove-amount", "removeAmount")->name("materials.removeAmount");
    });

    Route::controller(UserController::class)->group(function () {
        Route::get("/users", "index")->name("users.index");
        Route::delete("/users/{user}", "destroy")->name("users.destroy");
    });
});

Route::get("/403", function () {
    return Inertia::render("errors/Error403");
})->name("error403");

Route::get("/404", function () {
    return Inertia::render("errors/Error404");
})->name("error404");

Route::fallback(function () {
    return redirect()->route("error404");
});
