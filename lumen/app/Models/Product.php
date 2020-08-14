<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $product_id
 * @property int $product_history_id
 * @property int $category_id
 * @property int $stock
 * @property string $deleted_at
 * @property ProductHistory $productHistory
 * @property ProductCategory $productCategory
 * @property ProductHistory[] $productHistories
 */
class Product extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = ['category_id', 'stock'];

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'product_id';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function current()
    {
        return $this->hasOne('App\Models\ProductHistory', 'product_history_id', 'product_history_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\ProductCategory', 'category_id', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productHistories()
    {
        return $this->hasMany('App\Models\ProductHistory', 'product_id', 'product_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order','order_products')->using('App\Models\OrderProducts')->as('details');
    }

    protected static function booted()
    {
        static::created(function ($product) {
            return $product->current()->update(['product_id' => $product->product_id]);
        });
    }

    public function updateProduct(int $category_id, int $stock)
    {
        $this->category_id = $category_id;
        $this->stock = $stock;
        return $this->save();
    }
}
