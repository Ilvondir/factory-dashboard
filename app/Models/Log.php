<?php

namespace App\Models;

use App\Events\NewLogEvent;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property int $id
 * @property string $operation
 * @property string $occured
 * @property int|null $user_id
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log query()
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereOccured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereOperation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereUserId($value)
 * @property int $action_id
 * @property-read \App\Models\Action $action
 * @method static \Database\Factories\LogFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereActionId($value)
 * @mixin \Eloquent
 */
class Log extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $guarded = [];


    /**
     * Boot the model and add event listeners for the created event.
     *
     * This method overrides the parent boot method and adds an event listener to broadcast
     * a new log event whenever a Log model is created.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();
        static::created(function ($model) {
            $log = Log::with(["action", "user.role"])->where("id", "=", $model->id)->first()->makeHidden(["action_id", "user_id"]);
            $log->user->makeHidden("role_id");
            broadcast(new NewLogEvent($log))->toOthers();
        });
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function action(): BelongsTo
    {
        return $this->belongsTo(Action::class);
    }

}
