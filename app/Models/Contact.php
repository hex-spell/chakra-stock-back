<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $contact_id
 * @property string $created_at
 * @property int $deleted
 * @property string $address
 * @property float $money
 * @property string $name
 * @property string $role
 * @property string $phone
 * @property string $updated_at
 * @property Order[] $orders
 * @property Transaction[] $transactions
 */
class Contact extends Model
{

    use SoftDeletes;

    public $timestamps = true;
    
    protected $dates = ['deleted_at'];


    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'contact_id';

    /**
     * @var array
     */
    protected $fillable = [ 'address', 'money', 'name', 'role', 'phone'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Order', null, 'contact_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction', null, 'contact_id');
    }
}
