<?php

namespace App\Models;

use App\Casts\ContactCaster;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property string $email
 * @property string $phone_number
 * @property string $address
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Worker wherePhoneNumber($value)
 * @mixin \Eloquent
 */
class Worker extends Model
{
    use HasFactory, Loggable;

    public $timestamps = false;

    public $guarded = [];

    /**
     * @return BelongsTo
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Boot the model and add event listeners for created, updated, and deleted events.
     *
     * This method overrides the parent boot method and adds event listeners to log
     * messages whenever a Worker model is created, updated, or deleted.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();
        static::created(function ($model) {
            $model->log("Worker " . $model->first_name . " " . $model->last_name . " (" . $model->position->name . ") created.", 1);
        });
        static::updated(function ($model) {
            $model->log("Worker " . $model->first_name . " " . $model->last_name . " (" . $model->position->name . ") updated.", 2);
        });
        static::deleted(function ($model) {
            $model->log("Worker " . $model->first_name . " " . $model->last_name . " (" . $model->position->name . ") deleted.", 3);
        });
    }
}
