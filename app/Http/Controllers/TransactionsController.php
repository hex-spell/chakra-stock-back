<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\TransactionsServiceInterface;
use Illuminate\Http\Request;

/**
 * Representación del recurso de transacciones.
 *
 * @Resource("Transacciones", uri="/transactions")
 */
class TransactionsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $service;

    public function __construct(TransactionsServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Obtener transacciones. 
     * Filtrados por nombre de contacto, tipo de pedido (compra o venta) y offset.
     * Ordenados por fecha de creación.
     * El límite está programado a 10.
     * Los parámetros pueden ser enviados por querystring o por json.
     * - 'name' es el nombre del contacto vinculado a la transacción.
     * 
     * @Get("{search?,category_id,order?,offset?}")
     * @Request({"search":"Arróz", "category_id":1, "order":"name", "offset":"0"},headers={"Authorization": "Bearer {token}"})
     * @Parameters({
     *      @Parameter("search", type="string", required=false, description="Buscar por nombre del contacto.", default="String vacío"),
     *      @Parameter("type", type="'a'|'b'", required=true, description="Filtrar por tipo de pedido al que está vinculada (compra o venta)."),
     *      @Parameter("offset", type="integer", required=false, description="Cantidad de resultados a saltear, recomendable ir de 10 en 10, ya que el límite está definido en 10.", default=0)
     *  })
     * @Response(200, body={"result":
     *      {
     *          {
     *              "transaction_id": "integer",
     *              "order_id": "integer",
     *              "contact_id": "integer",
     *              "type": "'a'|'b'",
     *              "description": "string",
     *              "name": "string",
     *              "created_at": "timestamp", 
     *              "updated_at": "timestamp", 
     *              "deleted_at": "null"
     *          }
     *      }, 
     *      "count":"integer"
     *      }
     * )
     */
    public function getTransactions(Request $request)
    {
        //saca los 4 parametros de la url
        $offset = $request->get('offset') ? $request->get('offset') : 0;
        $search = $request->get('search') ? $request->get('search') : '';
        //role es 'c' o 'p', clientes o proveedores respectivamente
        //por default quiero que devuelva clientes
        //deberia buscar una forma de validar 'role' para que solamente pueda ser 'c' o 'p'
        $type = $request->get('type') ? $request->get('type') : 'a';
        //deberia preguntarle a alguien si esto se puede refactorizar, son demasiados parametros para una sola funcion
        return $this->service->getTransactions($offset, $search, $type);
    }

    /**
     * Eliminar una transacción de un pedido.
     * - debería pasar este endpoint al recurso "transacciones"
     * 
     * @Delete("/transactions")
     * @Parameters({
     *      @Parameter("transaction_id", type="integer", required=true, description="ID de la transacción a eliminar")
     *  })
     * @Request({},headers={"Authorization": "Bearer {token}"})
     */
    public function deleteTransactionById(int $id)
    {
        return $this->service->deleteTransactionById($id);
    }

    //POR AHORA ESTO NO LO USO
    /* public function postTransaction(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|between:4,30',
                'phone' => 'required|digits_between:4,30|numeric|unique:contacts,phone',
                'address' => 'required|string|between:4,30',
                'role' => 'required|string|size:1',
                'money' => 'required|numeric'
            ]
        );
        $name = $request->get('name');
        $phone = $request->get('phone');
        $address = $request->get('address');
        $role = $request->get('role');
        $money = $request->get('money');
        return $this->service->postTransaction($name, $phone, $role, $money, $address);
    } */

    /**
     * Actualizar una transacción.
     * 
     * @Put("/")
     * @Request({"transaction_id":"integer", "sum": "float"},headers={"Authorization": "Bearer {token}"})
     */
    public function updateTransaction(Request $request)
    {
        $this->validate(
            $request,
            [
                'transaction_id' => 'required|numeric|exists:transactions,transaction_id',
                'sum' => 'required|numeric'
            ]
        );
        $transaction_id = $request->get('transaction_id');
        $sum = $request->get('sum');
        return $this->service->updateTransaction($transaction_id, $sum);
    }
}
