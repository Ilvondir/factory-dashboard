<?php

namespace App\Models;

use App\Casts\ContactCaster;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $salary
 * @property mixed $contact
 * @property string $hired
 * @property int $position_id
 * @property-read \App\Models\Position $position
 * @method static \Database\Factories\WorkerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Worker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Worker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Worker query()
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereHired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereSalary($value)
 * @mixin \Eloquent
 */
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

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
