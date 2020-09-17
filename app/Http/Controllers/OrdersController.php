<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Interfaces\Services\OrdersServiceInterface;
use App\Interfaces\Services\ProductsServiceInterface;

/**
 * Representación del recurso de pedidos.
 *
 * @Resource("Pedidos", uri="/orders")
 */
class OrdersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $service;
    private $productsService;

    public function __construct(OrdersServiceInterface $service, ProductsServiceInterface $productsService)
    {
        $this->service = $service;
        $this->productsService = $productsService;
    }

    /**
     * Obtener Pedidos. 
     * Filtrados por nombre de contacto, compleción, entregados, tipo (entrante o saliente) ('a' o 'b', respectivamente) y offset.
     * Ordenados por suma, fecha de creación o fecha de actualización.
     * El límite está programado a 10.
     * Los parámetros pueden ser enviados por querystring o por json.
     * 
     * @Get("{search?,type?,completed?,delivered?,order?,offset?}")
     * @Request({"search":"Patricio", "role":"c", "order":"name", "offset":"0"},headers={"Authorization": "Bearer {token}"})
     * @Parameters({
     *      @Parameter("search", type="string", required=false, description="Buscar por descripción del gasto.", default="String vacío"),
     *      @Parameter("completed", type="'completed'|'not_completed'|'all'", required=false, description="Filtrar por compleción.", default="all"),
     *      @Parameter("delivered", type="'delivered'|'not_delivered'|'all'", required=false, description="Filtrar por entregados.", default="all"),
     *      @Parameter("order", type="'created_at'|'updated_at'", required=false, description="Define la columna utilizada para ordenar los resultados. No está utilizado en el front", default="created_at"),
     *      @Parameter("offset", type="integer", required=false, description="Cantidad de resultados a saltear, recomendable ir de 10 en 10, ya que el límite está definido en 10.", default=0)
     *  })
     * @Response(200, body={"result":{{"order_id": "integer", "contact_id": "integer", "completed": "boolean", "delivered": "boolean", "type": "'a'|'b'", "paid": "float", "sum": "float", "products_count": "integer", "created_at": "timestamp", "updated_at": "timestamp", "deleted_at": "null", "contact":{"name":"string","address":"string","phone":"string","contact_id":"integer"}}}, "count":"integer"})
     */
    public function getOrders(Request $request)
    {
        $search = $request->get('search') ? $request->get('search') : "";
        $completed = $request->get('completed');
        $delivered = $request->get('delivered');
        $order = $request->get('order') ? $request->get('order') : "";
        $type = $request->get('type') ? $request->get('type') : "a";
        $offset = $request->get('offset') ? $request->get('offset') : 0;
        return $this->service->getOrders($search, $completed, $delivered, $order, $type, $offset);
    }
    /**
     * Obtener pedido específico.
     *
     * Obtener una representación JSON de un pedido por su ID.
     * "current_version" solo aparece si el producto en el pedido está desactualizado.
     *
     * @Get("/id/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID del pedido.")
     * })
     * @Request({},headers={"Authorization": "Bearer {token}"})
     * @Response(200, body={"order_id": "integer", "contact_id": "integer",
     *  "completed": "boolean", "delivered": "boolean", "type": "'a'|'b'",
     *  "paid": "float", "sum": "float", "created_at": "timestamp",
     *  "updated_at": "timestamp", "deleted_at": "null",
     *  "contact":{"name":"string","address":"string","phone":"string","contact_id":"integer"},
     *  "products":{{
     *      "ammount": "integer",
     *      "delivered": "boolean",
     *      "product_id": "integer",
     *      "product_history_id": "integer",
     *      "current_version": {
     *          "product_id": "integer",
     *          "product_history_id": "integer",
     *          "name": "string",
     *          "sell_price": "float",
     *          "buy_price": "float"
     *      },
     *      "product_version": {
     *          "product_id": "integer",
     *          "product_history_id": "integer",
     *          "name": "string",
     *          "sell_price": "integer",
     *          "buy_price": "integer"
     *     } 
     * }},
     * "transactions":{
     *      {
     *          "transaction_id": "integer",
     *          "sum": "integer",
     *          "created_at": "timestamp"
     *      }
     * }
     * })
     */
    public function getOrderById(Request $request)
    {
        $this->validate($request, ['order_id' => 'required|numeric|exists:orders,order_id']);
        $order_id = $request->get('order_id');
        return $this->service->getOrderById($order_id);
    }
    /**
     * Obtener productos de un pedido específico.
     *
     * Obtener una representación JSON de los productos de un pedido por su ID.
     * "current_version" solo aparece si el producto en el pedido está desactualizado.
     *
     * @Get("/id/products/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID del pedido.")
     * })
     * @Request({},headers={"Authorization": "Bearer {token}"})
     * @Response(200, body={
     *  "result":{{
     *      "ammount": "integer",
     *      "delivered": "boolean",
     *      "product_id": "integer",
     *      "product_history_id": "integer",
     *      "current_version": {
     *          "product_id": "integer",
     *          "product_history_id": "integer",
     *          "name": "string",
     *          "sell_price": "float",
     *          "buy_price": "float"
     *      },
     *      "product_version": {
     *          "product_id": "integer",
     *          "product_history_id": "integer",
     *          "name": "string",
     *          "sell_price": "integer",
     *          "buy_price": "integer"
     *     } 
     * }}
     * })
     */
    public function getOrderProductsByOrderId(Request $request)
    {
        $this->validate($request, ['order_id' => 'required|numeric|exists:orders,order_id']);
        $order_id = $request->get('order_id');
        return $this->service->getOrderProductsByOrderId($order_id);
    }
    /**
     * Eliminar un pedido.
     * 
     * @Delete("/orders")
     * @Request({"order_id": "integer"},headers={"Authorization": "Bearer {token}"})
     */
    public function deleteOrderById(Request $request)
    {
        $this->validate($request, ['order_id' => 'required|numeric|exists:orders,order_id']);
        $order_id = $request->get('order_id');
        return $this->service->deleteOrderById($order_id);
    }
    /**
     * Crear un pedido.
     * La variable type define si el pedido es una compra (a), o una venta (b).
     * 
     * @Post("/")
     * @Request({"contact_id": "integer", "type": "'a'|'b'"},headers={"Authorization": "Bearer {token}"})
     */
    public function postOrder(Request $request)
    {
        //los tipos son A (proveedores) o B (clientes)
        $this->validate(
            $request,
            [
                'contact_id' => 'required|numeric|exists:contacts,contact_id',
                'type' => 'required|string|size:1',
            ]
        );
        $contact_id = $request->get('contact_id');
        $type = $request->get('type');
        return $this->service->postOrder($contact_id, $type);
    }
    /**
     * Actualizar un pedido.
     * La variable type define si el pedido es una compra (a), o una venta (b).
     * 
     * @Put("/")
     * @Request({"order_id":"integer", "contact_id": "integer", "type": "'a'|'b'"},headers={"Authorization": "Bearer {token}"})
     */
    public function updateOrder(Request $request)
    {
        $this->validate(
            $request,
            [
                'order_id' => 'required|numeric|exists:orders,order_id',
                'contact_id' => 'required|numeric|exists:contacts,contact_id',
                'type' => 'required|string|size:1',
            ]
        );
        $order_id = $request->get('order_id');
        $contact_id = $request->get('contact_id');
        $type = $request->get('type');
        return $this->service->updateOrder($order_id, $contact_id, $type);
    }
    /**
     * Agregar un producto a un pedido.
     * Los productos no pueden estar repetidos en un pedido, si se intenta agregar un producto ya existente, devuelve error de validación.
     * 
     * @Post("/products")
     * @Request({"order_id":"integer", "product_id": "integer", "ammount": "integer"},headers={"Authorization": "Bearer {token}"})
     */
    public function addOrderProduct(Request $request)
    {
        $order_id = $request->get('order_id');
        $product_id = $request->get('product_id');
        $ammount = $request->get('ammount');
        $this->validate(
            $request,
            [
                'order_id' => 'required|numeric|exists:orders,order_id|unique:order_products,order_id,NULL,id,product_id,' . $product_id,
                'product_id' => 'required|numeric|exists:products,product_id|unique:order_products,product_id,NULL,id,order_id,' . $order_id,
                'ammount' => 'required|integer',
            ]
        );
        return $this->service->addOrderProduct($order_id, $product_id, $ammount);
    }
    /**
     * Modificar un producto de un pedido.
     * Los productos no pueden estar repetidos en un pedido, si se intenta cambiar a un producto ya existente, devuelve error de validación.
     * 
     * @Put("/products")
     * @Request({"order_id":"integer", "product_id": "integer", "ammount": "integer", "delivered": "integer"},headers={"Authorization": "Bearer {token}"})
     */
    public function modifyOrderProduct(Request $request)
    {
        $order_id = $request->get('order_id');
        $product_id = $request->get('product_id');
        $ammount = $request->get('ammount');
        $delivered = $request->get('delivered');
        $this->validate(
            $request,
            [
                'order_id' => [
                    'required',
                    'numeric',
                    Rule::exists('order_products')->where(function ($query) use ($product_id) {
                        $query->where('product_id', $product_id);
                    })
                ],
                'product_id' => [
                    'required',
                    'numeric',
                    Rule::exists('order_products')->where(function ($query) use ($order_id) {
                        $query->where('order_id', $order_id);
                    })
                ],
                'ammount' => 'required|integer',
                'delivered' => 'required|integer'
            ]
        );
        return $this->service->modifyOrderProduct($order_id, $product_id, $ammount, $delivered);
    }
    /**
     * Remover un producto de un pedido.
     * 
     * @Delete("/products")
     * @Request({"order_id":"integer", "product_id": "integer"},headers={"Authorization": "Bearer {token}"})
     */
    public function removeOrderProduct(Request $request)
    {
        $order_id = $request->get('order_id');
        $product_id = $request->get('product_id');

        $this->validate(
            $request,
            [
                'order_id' => 'required|numeric|exists:order_products,order_id',
                'product_id' => 'required|numeric|exists:order_products,product_id'
            ]
        );
        return $this->service->removeOrderProduct($order_id, $product_id);
    }
    /**
     * Definir cantidad de entregados de un producto en un pedido.
     * 
     * @Post("/products/delivered")
     * @Request({"order_id":"integer", "product_id": "integer", "ammount":"integer"},headers={"Authorization": "Bearer {token}"})
     */
    public function markDelivered(Request $request)
    {
        //ACÁ DEBERÍA VALIDAR QUE LA CANTIDAD ENTREGADA NO SEA MAYOR A LA CANTIDAD QUE HAY EN STOCK
        //HACIENDO UNA REGLA DE VALIDACION PERSONALIZADA
        $order_id = $request->get('order_id');
        $product_id = $request->get('product_id');
        $ammount = $request->get('ammount');
        $ammountOnStock = $this->productsService->getProductById($product_id)->stock;
        $this->validate(
            $request,
            [
                'order_id' => 'required|integer|exists:order_products,order_id',
                'product_id' => 'required|integer|exists:order_products,product_id',
                'ammount' => 'required|integer|max:' . $ammountOnStock
            ]
        );
        return $this->service->markDelivered($order_id, $product_id, $ammount);
    }
    /**
     * Definir cantidad de entregados de varios productos en un pedido al mismo tiempo.
     * - falta poder validar el maximo de productos que podes entregar en base a la cantidad de stock, para no quedar en números negativos
     * 
     * @Post("/products/delivered")
     * @Request({"order_id": "integer", "products":{{"product_id": "integer", "ammount":"integer"}}},headers={"Authorization": "Bearer {token}"})
     */
    public function markDeliveredMultiple(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required|integer|exists:order_products,order_id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|numeric|exists:order_products,product_id',
            'products.*.ammount' => 'required|integer'
        ]);
        $order_id = $request->get('order_id');
        $products = $request->get('products');
        return $this->service->markDeliveredMultiple($order_id, $products);
    }
    public function getTransactions(Request $request)
    {
        $search = $request->get('search') ? $request->get('search') : "";
        $order = $request->get('order') ? $request->get('order') : "";
        $type = $request->get('type') ? $request->get('type') : "a";
        $offset = $request->get('offset') ? $request->get('offset') : 0;
        return $this->service->getTransactions($search, $order, $type, $offset);
    }
    /**
     * Agregar una transacción a un pedido.
     * - debería pasar este endpoint al recurso "transacciones"
     * 
     * @Post("/transactions")
     * @Request({"transaction_id": "integer", "sum": "float"},headers={"Authorization": "Bearer {token}"})
     */
    public function addTransaction(Request $request)
    {
        $this->validate(
            $request,
            [
                'order_id' => 'required|numeric|exists:orders,order_id',
                'sum' => 'required|numeric'
            ]
        );
        $order_id = $request->get('order_id');
        $sum = $request->get('sum');
        return $this->service->addTransaction($order_id, $sum);
    }
    /**
     * Modificar una transacción de un pedido.
     * - debería pasar este endpoint al recurso "transacciones"
     * 
     * @Put("/transactions")
     * @Request({"transaction_id": "integer", "sum": "float"},headers={"Authorization": "Bearer {token}"})
     */
    public function modifyTransaction(Request $request)
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
        return $this->service->modifyTransaction($transaction_id, $sum);
    }
    /**
     * Eliminar una transacción de un pedido.
     * - debería pasar este endpoint al recurso "transacciones"
     * 
     * @Delete("/transactions")
     * @Request({"transaction_id":"integer"},headers={"Authorization": "Bearer {token}"})
     */
    public function deleteTransaction(Request $request)
    {
        $this->validate(
            $request,
            [
                'transaction_id' => 'required|numeric|exists:transactions,transaction_id'
            ]
        );
        $transaction_id = $request->get('transaction_id');
        return $this->service->deleteTransaction($transaction_id);
    }
    /**
     * Marcar pedido como completado.
     * Cambia el booleano "completed" de false a true
     * 
     * @Post("/completed")
     * @Request({"order_id":"integer"},headers={"Authorization": "Bearer {token}"})
     */
    public function markCompleted(Request $request)
    {
        //ACÁ DEBERIA VALIDAR QUE EL PEDIDO ESTÉ PAGO Y ENTREGADO
        //AUNQUE PROBABLEMENTE TENGA QUE HACERLO DESDE EL REPOSITORIO
        $order_id = $request->get('order_id');
        return $this->service->markCompleted($order_id);
    }

    public function getOrderTicketPDF(Request $request)
    {
        $this->validate($request,[
            'order_id'=>'required|integer|exists:orders,order_id'
        ]);
        $order_id = $request->get('order_id');
        return $this->service->getOrderTicketPDF($order_id);
    }
}
