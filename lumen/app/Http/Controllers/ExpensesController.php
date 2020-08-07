<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\ExpensesServiceInterface;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $service;

    public function __construct(ExpensesServiceInterface $service)
    {
        $this->service = $service;
    }

    public function getExpenses()
    {
        return $this->service->getExpenses();
    }

    public function searchExpenses()
    {
        return $this->service->searchExpenses();
    }

    public function getExpenseById()
    {
        return $this->service->getExpenseById();
    }

    public function deleteExpenseById()
    {
        return $this->service->deleteExpenseById();
    }

    public function postExpense()
    {
        return $this->service->postExpense();
    }

    public function updateExpense()
    {
        return $this->service->updateExpense();
    }
}
