<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Orders;

class Contact extends Model{
    public $timestamps = false;
    protected $attributes = [
        'deleted' => false
    ];
    protected $fillable = array('name','phone');
    public function orders(){
        return $this->hasMany(Orders::class);
    }
}