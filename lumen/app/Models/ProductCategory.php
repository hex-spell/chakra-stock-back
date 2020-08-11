<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $category_id
 * @property string $name
 * @property Product[] $products
 */
class ProductCategory extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'category_id';

    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Product', 'category_id', 'category_id');
    }
}
