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
    protected $fillable = ['ammount', 'delivered', 'product_history_id'];

  
}
