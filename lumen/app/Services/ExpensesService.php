<?php

namespace App\Services;

use App\Interfaces\Repositories\ExpensesRepositoryInterface;
use App\Interfaces\Services\ExpensesServiceInterface;

class ExpensesService implements ExpensesServiceInterface
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $repo;

    public function __construct(ExpensesRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getExpenses()
    {
        return $this->repo->getExpenses();
    }

    public function searchExpenses()
    {
        return $this->repo->searchExpenses();
    }

    public function getExpenseById()
    {
        return $this->repo->getExpenseById();
    }

    public function deleteExpenseById()
    {
        return $this->repo->deleteExpenseById();
    }

    public function postExpense()
    {
        return $this->repo->postExpense();
    }

    public function updateExpense()
    {
        return $this->repo->updateExpense();
    }
}
