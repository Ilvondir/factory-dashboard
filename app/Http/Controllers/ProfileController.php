<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function show()
    {
        return Inertia::render("auth/Profile", [
            "sessions" => \Auth::user()->sessions
        ]);
    }
}
