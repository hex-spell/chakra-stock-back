<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ExpensesRepositoryInterface;
use App\Models\Expense;
use App\Models\ExpenseCategory;

class ExpensesRepository implements ExpensesRepositoryInterface
{
  public function getExpenses(string $search, string $order, int $category_id, int $offset)
  {
    $loweredSearch = strtolower($search);
    $loweredOrder = strtolower($order);
    //argumentos de la consulta
    $whereRaw = ['lower(description) like (?)', ["%{$loweredSearch}%"]];
    //si el category_id es 0 o nulo, se busca en todas las categorias
    $query = $category_id ? ExpenseCategory::findOrFail($category_id)->expenses()->whereRaw($whereRaw[0], $whereRaw[1])
      : Expense::whereRaw($whereRaw[0], $whereRaw[1]);
    //si el orden es por fecha, se cambia la orientacion
    $orderedQuery = $loweredOrder === 'updated_at' ? $query->orderBy($loweredOrder, 'desc') : $query->orderBy($loweredOrder);
    $count = $query->count();
    return ['result' => $orderedQuery->skip($offset)->take(10)->get(), 'count' => $count];
  }

  public function getExpenseCategories()
  {
    return ['result'=>ExpenseCategory::all()];
  }


  public function searchExpenses()
  {
    return "hello";
  }
  public function getExpenseById()
  {
    return "hello";
  }
  public function deleteExpenseById(int $expense_id)
  {
    return Expense::destroy($expense_id);
  }

  public function postExpense(string $description, float $sum, int $category_id)
  {
    return Expense::create(['description' => $description, 'sum' => $sum, 'category_id' => $category_id]);
  }

  public function updateExpense(string $description, float $sum, int $expense_id, int $category_id)
  {
    $Expense = Expense::findOrFail($expense_id);
    $Expense->description = $description;
    $Expense->sum = $sum;
    $Expense->category_id = $category_id;
    return $Expense->save(); 
  }

  public function postExpenseCategory(string $name)
  {
    return ExpenseCategory::create(['name' => $name]);
  }

  public function updateExpenseCategory(string $name, int $category_id)
  {
    $Category = ExpenseCategory::find($category_id);
    $Category->name = $name;
    return $Category->save();
  }

  public function deleteExpenseCategoryById(int $category_id){
    return ExpenseCategory::destroy($category_id);
  }
}
