<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function action()
    {
        return $this->belongsTo(Action::class);
    }

}
