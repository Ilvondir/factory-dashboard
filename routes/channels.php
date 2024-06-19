<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('logs', function (User $user) {
    return $user->role_id === 1;
});
