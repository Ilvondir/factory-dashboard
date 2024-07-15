<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    use HasFactory, Loggable;

    public $timestamps = false;

    public $guarded = [];

    /**
     * @return BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @return HasMany
     */
    public function workers(): HasMany
    {
        return $this->hasMany(Worker::class);
    }

    /**
     * Boot the model and add event listeners for created, updated, and deleted events.
     *
     * This method overrides the parent boot method and adds event listeners to log
     * messages whenever a Position model is created, updated, or deleted.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            $model->log("Position " . $model->name . " in department " . $model->department->name . " created.", 1);
        });
        static::updated(function ($model) {
            $model->log("Position " . $model->name . " updated.", 2);
        });
        static::deleted(function ($model) {
            $model->log("Position " . $model->name . " deleted.", 3);
        });
    }
}
