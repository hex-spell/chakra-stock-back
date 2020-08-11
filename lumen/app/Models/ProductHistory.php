<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $product_history_id
 * @property int $product_id
 * @property string $created_at
 * @property string $name
 * @property float $sell_price
 * @property float $buy_price
 * @property string $updated_at
 * @property Product $product
 * @property Product $product
 */
class ProductHistory extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    
    protected $dates = ['deleted_at'];
    
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'product_history';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'product_history_id';

    /**
     * @var array
     */
    protected $fillable = ['product_id', 'created_at', 'name', 'sell_price', 'buy_price', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentProduct()
    {
        return $this->belongsTo('App\Product', null, 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function currentProduct()
    {
        return $this->hasOne('App\Product', 'product_history_id', 'product_history_id');
    }
}
