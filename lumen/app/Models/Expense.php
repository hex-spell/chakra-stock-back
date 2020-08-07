<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $expense_id
 * @property string $description
 * @property float $sum
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property ExpenseCategory[] $expenseCategories
 */
class Expense extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    
    protected $dates = ['deleted_at'];

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'expense_id';

    /**
     * @var array
     */
    protected $fillable = ['description', 'sum'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expenseCategory()
    {
        return $this->belongsTo('App\ExpenseCategory', 'category_id', 'category_id');
    }
}
