<?php

namespace App\Models;

use App\Casts\ContactCaster;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $guarded = [];

    protected function casts(): array
    {
        return [
            'contact' => ContactCaster::class,
        ];
    }
}
