<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model{
    public $timestamps = false;
    protected $attributes = [
        'deleted' => false
    ];
    protected $fillable = array('name','phone');
}