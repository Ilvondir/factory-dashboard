<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $guarded = [];

    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
