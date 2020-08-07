<?php
namespace App\Repositories;
use App\Interfaces\Repositories\ExpensesRepositoryInterface;
use App\Models\Expense;

class ExpensesRepository implements ExpensesRepositoryInterface {
    public function getExpenses(){return "hello";}
    public function searchExpenses(){return "hello";}
    public function getExpenseById(){return "hello";}
    public function deleteExpenseById(){return "hello";}
    public function postExpense(){return "hello";}
    public function updateExpense(){return "hello";}
}