<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render("logs/Logs", [
            "logs" => Log::orderByDesc("id")->with(["action", "user"])->get()
        ]);
    }
}
