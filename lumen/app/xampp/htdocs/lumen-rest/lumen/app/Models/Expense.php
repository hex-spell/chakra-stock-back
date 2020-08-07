<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $expense_id
 * @property int $category_id
 * @property string $description
 * @property float $sum
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property ExpenseCategory $expenseCategory
 */
class Expense extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'expense_id';

    /**
     * @var array
     */
    protected $fillable = ['category_id', 'description', 'sum', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expenseCategory()
    {
        return $this->belongsTo('App\ExpenseCategory', 'category_id', 'category_id');
    }
}
