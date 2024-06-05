<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $added
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\MaterialFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Material newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Material newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Material query()
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereAdded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereName($value)
 * @property int $quantity
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereQuantity($value)
 * @mixin \Eloquent
 */
class Material extends Model
{
    use HasFactory, Loggable;

    public $guarded = [];

    public function getCreatedAtAttribute($date)
    {
        return Carbon\Carbon::parse($date)->format("d.m.Y, H:i:s");
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon\Carbon::parse($date)->format("d.m.Y, H:i:s");
    }

    public function products()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(Product::class, "products_materials", "material_id", "product_id");
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            $model->log("Material " . $model->name . " created.", 1);
        });
        static::updated(function ($model) {
            $model->log("Material " . $model->name . " updated.", 2);
        });
        static::deleted(function ($model) {
            $model->log("Material " . $model->name . " deleted.", 3);
        });
    }
}
