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

    public function getExpenses(Request $request)
    {
        $search = $request->get('search') ? $request->get('search') : "";
        $order = $request->get('order') ? $request->get('order') : "description";
        $category_id = $request->get('category_id') ? $request->get('category_id') : 0; //si es 0, que obtenga todas las categorias
        $offset = $request->get('offset') ? $offset = $request->get('offset') : 0;
        return $this->service->getExpenses($search, $order, $category_id, $offset);
    }

    public function getExpenseCategories()
    {
        return $this->service->getExpenseCategories();
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

    public function postExpense(Request $request)
    {
        $this->validate(
            $request,
            [
                'description' => 'required|string|between:4,30',
                'category_id' => 'required|integer|exists:expense_categories,category_id',
                'sum' => 'required|numeric',
            ]
        );
        $description = $request->get('description');
        $sum = $request->get('sum');
        $category_id = $request->get('category_id');
        return $this->service->postExpense($description, $sum, $category_id);
    }

    public function updateExpense(Request $request)
    {
        $this->validate(
            $request,
            [
                'description' => 'required|string|between:4,30',
                'category_id' => 'required|integer|exists:expense_categories,category_id',
                'expense_id' => 'required|integer|exists:expenses,expense_id',
                'sum' => 'required|numeric',
            ]
        );
        $description = $request->get('description');
        $sum = $request->get('sum');
        $category_id = $request->get('category_id');
        $expense_id = $request->get('expense_id');
        return $this->service->updateExpense($description, $sum, $expense_id, $category_id);
    }

    public function postExpenseCategory(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|between:4,30|unique:expense_categories,name',
            ]
        );
        $name = $request->get('name');
        return $this->service->postExpenseCategory($name);
    }

    public function updateExpenseCategory(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|between:4,30|unique:expense_categories,name,'
                    . $request->get('category_id') .
                    ',category_id',
                'category_id' => 'required|numeric|exists:expense_categories,category_id'
            ]
        );
        $name = $request->get('name');
        $category_id = $request->get('category_id');
        return $this->service->updateExpenseCategory($name, $category_id);
    }

    public function deleteExpenseCategoryById(Request $request)
    {
        $this->validate(
            $request,
            [
                'category_id' => 'required|numeric|exists:expense_categories,category_id'
            ]
        );
        $category_id = $request->get('category_id');
        return $this->service->deleteExpenseCategoryById($category_id);
    }
}

