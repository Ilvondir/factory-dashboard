<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render("logs/Logs", [
            "logs" => Log::orderByDesc("id")->with(["action", "user"])->paginate(100),
            "canDownloadLogs" => \Auth::user()->can("downloadLogs")
        ]);
    }

    public function downloadJSON()
    {
        $logs = Log::with(["action", "user.role"])->orderByDesc("id")->get();
        $logs->each(function ($log) {
            $log->makeHidden(['action_id', 'user_id']);
            $log->user->makeHidden("role_id");
        });

        date_default_timezone_set("Europe/Warsaw");

        $filename = "logs" . date("YmdHis") . ".json";

        return Response::make(json_encode($logs), 200, [
            'Content-Type' => 'text/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
