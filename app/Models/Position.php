<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $responsibilities
 * @property int $department_id
 * @property-read \App\Models\Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Worker> $workers
 * @property-read int|null $workers_count
 * @method static \Database\Factories\PositionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Position newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Position newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Position query()
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereResponsibilities($value)
 * @mixin \Eloquent
 */
class Position extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $guarded = [];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function workers()
    {
        return $this->hasMany(Worker::class);
    }
}
