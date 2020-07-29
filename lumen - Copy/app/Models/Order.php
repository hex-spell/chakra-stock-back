<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contacts;

class Order extends Model{
    public $timestamps = false;
    /*protected $attributes = [
        'deleted' => false
    ];*/
    //protected $fillable = array('name','phone');
    protected $primaryKey = 'order_id';
    public function contact()
    {
        return $this->belongsTo(Contact::class,'contact_id');
    }
}