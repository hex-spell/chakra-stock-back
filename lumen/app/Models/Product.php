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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function current()
    {
        return $this->belongsTo('App\ProductHistory', 'product_history_id', 'product_history_id');
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
        return $this->hasMany('App\ProductHistory', 'product_id', 'product_id');
    }
}
