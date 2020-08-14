<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $transaction_id
 * @property int $contact_id
 * @property int $order_id
 * @property string $created_at
 * @property float $sum
 * @property string $updated_at
 * @property string $deleted_at
 * @property Contact $contact
 * @property Order $order
 */
class Transaction extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    
    protected $dates = ['deleted_at'];

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'transaction_id';

    /**
     * @var array
     */
    protected $fillable = ['contact_id', 'order_id', 'sum'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo('App\Models\Contact', 'contact_id', 'contact_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'order_id');
    }
}
