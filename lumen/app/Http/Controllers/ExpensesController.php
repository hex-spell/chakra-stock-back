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

    /**
     * Obtener gastos. 
     * Filtrados por descripción, categoría y offset.
     * Ordenados por descripción, suma, fecha de creación o fecha de actualización.
     * El límite está programado a 10.
     * Los parámetros pueden ser enviados por querystring o por json.
     * 
     * @Get("{search?,category_id,order?,offset?}")
     * @Request({"search":"Patricio", "role":"c", "order":"name", "offset":"0"},headers={"Authorization": "Bearer {token}"})
     * @Parameters({
     *      @Parameter("search", type="string", required=false, description="Buscar por descripción del gasto.", default="String vacío"),
     *      @Parameter("category_id", type="integer", required=true, description="Filtrar por categoría."),
     *      @Parameter("order", type="'description'|'created_at'|'updated_at'|'sum'", required=false, description="Define la columna utilizada para ordenar los resultados.", default="name"),
     *      @Parameter("offset", type="integer", required=false, description="Cantidad de resultados a saltear, recomendable ir de 10 en 10, ya que el límite está definido en 10.", default=0)
     *  })
     * @Response(200, body={"result":{{"expense_id": "integer", "category_id": "integer", "description": "string", "sum": "float", "created_at": "timestamp", "updated_at": "timestamp", "deleted_at": "null"}}, "count":"integer"})
     */
    public function getExpenses(Request $request)
    {
        $search = $request->get('search') ? $request->get('search') : "";
        $order = $request->get('order') ? $request->get('order') : "description";
        $category_id = $request->get('category_id') ? $request->get('category_id') : 0; //si es 0, que obtenga todas las categorias
        $offset = $request->get('offset') ? $offset = $request->get('offset') : 0;
        return $this->service->getExpenses($search, $order, $category_id, $offset);
    }

    /**
     * Obtener categorías.
     * Retorna una lista de todas las categorías de los gastos.
     * 
     * @Get("/categories")
     * 
     * @Request({},headers={"Authorization": "Bearer {token}"})
     * @Response(200, body={"result":{{"category_id": "integer", "name": "string"}}, "count":"integer"})
     */
    public function getExpenseCategories()
    {
        return $this->service->getExpenseCategories();
    }

    /**
     * Crear una categoría.
     * 
     * @Post("/categories")
     * @Request({"name": "string"},headers={"Authorization": "Bearer {token}"})
     */
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

    /**
     * Actualizar una categoría.
     * 
     * @Put("/categories")
     * @Request({"name": "string", "category_id": "integer"},headers={"Authorization": "Bearer {token}"})
     */
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

    /**
     * Eliminar una categoría.
     * 
     * @Delete("/categories")
     * @Request({"category_id": "integer"},headers={"Authorization": "Bearer {token}"})
     */
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

    /**
     * Postear un gasto.
     * 
     * @Post("/")
     * @Request({"category_id": "integer","name": "string", "description": "string", "sum": "float"},headers={"Authorization": "Bearer {token}"})
     */
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

    /**
     * Actualizar un gasto.
     * 
     * @Put("/")
     * @Request({"category_id":"integer","expense_id":"integer","name": "string", "description": "string", "sum": "float"},headers={"Authorization": "Bearer {token}"})
     */
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

    /**
     * Eliminar gasto.
     * 
     * @Delete("/")
     * @Request({"expense_id":"integer"},headers={"Authorization": "Bearer {token}"})
     */
    public function deleteExpenseById(Request $request)
    { {
            $this->validate(
                $request,
                [
                    'expense_id' => 'required|numeric|exists:expenses,expense_id'
                ]
            );
            $expense_id = $request->get('expense_id');
            return $this->service->deleteExpenseById($expense_id);
        }
    }
}
