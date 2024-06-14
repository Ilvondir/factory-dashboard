<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('logs', function () {
    return true;
});
