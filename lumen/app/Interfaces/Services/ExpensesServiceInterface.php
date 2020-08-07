<?php

namespace App\Interfaces\Services;

interface ExpensesServiceInterface
{
    public function getExpenses();
    public function searchExpenses();
    public function getExpenseById();
    public function deleteExpenseById();
    public function postExpense();
    public function updateExpense();
}
