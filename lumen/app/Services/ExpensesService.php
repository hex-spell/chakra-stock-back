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

    public function getExpenses(string $search, string $order, int $category_id, int $offset)
    {
        return $this->repo->getExpenses($search, $order, $category_id, $offset);
    }

    public function getExpenseCategories()
    {
        return $this->repo->getExpenseCategories();
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

    public function postExpense(string $description, float $sum, int $category_id)
    {
        return $this->repo->postExpense($description, $sum, $category_id);
    }

    public function updateExpense(string $description, float $sum, int $expense_id, int $category_id)
    {
        return $this->repo->updateExpense($description, $sum, $expense_id, $category_id);
    }

    public function postExpenseCategory(string $name)
    {
        return $this->repo->postExpenseCategory($name);
    }

    public function updateExpenseCategory(string $name, int $category_id)
    {
        return $this->repo->updateExpenseCategory($name, $category_id);
    }

    public function deleteExpenseCategoryById(int $category_id)
    {
        return $this->repo->deleteExpenseCategoryById($category_id);
    }
}
