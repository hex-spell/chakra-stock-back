<?php

namespace App\Interfaces\Repositories;

interface ExpensesRepositoryInterface
{
    public function getExpenses();
    public function searchExpenses();
    public function getExpenseById();
    public function deleteExpenseById();
    public function postExpense();
    public function updateExpense();
}
