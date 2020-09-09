<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $order_id
 * @property int $contact_id
 * @property string $created_at
 * @property int $completed
 * @property string $type
 * @property string $updated_at
 * @property string $deleted_at
 * @property Contact $contact
 * @property OrderProduct[] $orderProducts
 * @property Transaction[] $transactions
 */
class Order extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $dates = ['deleted_at'];

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'order_id';

    protected $table = 'orders';
    /**
     * @var array
     */
    protected $fillable = ['contact_id', 'completed', 'type', 'delivered'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo('App\Models\Contact', 'contact_id', 'contact_id')->select([
            "name",
            "address",
            "phone",
            "contact_id"
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'order_products', 'order_id', 'product_id', 'order_id')
        ->using('App\Models\OrderProducts')      
        ->withPivot('product_history_id', 'ammount', 'delivered')
        ->as('details');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction', 'order_id', 'order_id');
    }
}
