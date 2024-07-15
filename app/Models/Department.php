<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Position> $positions
 * @property-read int|null $positions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\DepartmentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereName($value)
 * @mixin \Eloquent
 */
class Department extends Model
{
    use HasFactory, Loggable;

    public $timestamps = false;
    public $guarded = [];

    /**
     * @return HasMany
     */
    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Boot the model and add event listeners for created, updated, and deleted events.
     *
     * This method overrides the parent boot method and adds event listeners to log
     * messages whenever a Department model is created, updated, or deleted.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();
        static::created(function ($model) {
            $model->log("Department " . $model->name . " created.", 1);
        });
        static::updated(function ($model) {
            $model->log("Department " . $model->name . " updated.", 2);
        });
        static::deleted(function ($model) {
            $model->log("Department " . $model->name . " deleted.", 3);
        });
    }
}
