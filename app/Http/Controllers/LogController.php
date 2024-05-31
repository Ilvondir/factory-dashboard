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
        return Inertia::render("logs/Logs");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Log $log)
    {
        //
    }
}
