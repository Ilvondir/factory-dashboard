<?php

namespace App\Traits;

use App\Models\Log;

trait Loggable
{
    public function log($operation, $action_id)
    {
        if (!app()->runningInConsole()) {
            Log::create([
                "operation" => $operation,
                "occured" => now("Europe/Warsaw"),
                "action_id" => $action_id,
                "user_id" => \Auth::id()
            ]);
        }
    }
}
