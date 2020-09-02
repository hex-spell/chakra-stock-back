<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $order_id
 * @property int $product_id
 * @property int $producto_history_id
 * @property int $ammount
 * @property int $delivered
 * @property Order $order
 */

class OrderProducts extends Pivot
{

    /**
     * @var array
     */
    public $timestamps = false;

    protected $fillable = ['ammount', 'delivered', 'product_history_id'];

    protected $table = 'order_products';

    public function productVersion() {
        return $this->hasOne('App\Models\ProductHistory', 'product_history_id', 'product_history_id')->select([
            "product_id",
            "product_history_id",
            "name",
            "sell_price",
            "buy_price"
        ]);
    }

    public function currentVersion() {
        return $this->hasOne('App\Models\ProductHistory', 'product_id', 'product_id')->select([
            "product_id",
            "product_history_id",
            "name",
            "sell_price",
            "buy_price"
        ])->latest();
    }
}
