<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $price
 * @property int $department_id
 * @property-read \App\Models\Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Material> $materials
 * @property-read int|null $materials_count
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory, Loggable;

    public $timestamps = false;
    public $guarded = [];

    /**
     * Boot the model and add event listeners for created, updated, and deleted events.
     *
     * This method overrides the parent boot method and adds event listeners to log
     * messages whenever a Product model is created, updated, or deleted.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            $model->log("Product " . $model->name . " created.", 1);
        });
        static::updated(function ($model) {
            $model->log("Product " . $model->name . " updated.", 2);
        });
        static::deleted(function ($model) {
            $model->log("Product " . $model->name . " deleted.", 3);
        });
    }

    /**
     * @return BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @return BelongsToMany
     */
    public function materials(): BelongsToMany
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(Material::class, "products_materials", "product_id", "material_id");
    }
}
