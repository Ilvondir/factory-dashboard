<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 *
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property int $role_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Log> $logs
 * @property-read int|null $logs_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Role $role
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, Loggable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            $model->log("User " . $model->first_name . " " . $model->last_name . " (" . $model->role->name . ") created.", 1);
        });
        static::updated(function ($model) {
            $model->log("User " . $model->first_name . " " . $model->last_name . " (" . $model->role->name . ") updated.", 2);
        });
        static::deleted(function ($model) {
            $model->log("User " . $model->first_name . " " . $model->last_name . " (" . $model->role->name . ") deleted.", 3);
        });
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
