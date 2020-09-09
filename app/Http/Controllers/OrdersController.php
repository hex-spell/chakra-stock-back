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
    public function getOrderById(Request $request)
    {
        $this->validate($request, ['order_id' => 'required|numeric|exists:orders,order_id']);
        $order_id = $request->get('order_id');
        return $this->service->getOrderById($order_id);
    }
    public function getOrderProductsByOrderId(Request $request)
    {
        $this->validate($request, ['order_id' => 'required|numeric|exists:orders,order_id']);
        $order_id = $request->get('order_id');
        return $this->service->getOrderProductsByOrderId($order_id);
    }
    public function deleteOrderById(Request $request)
    {
        $this->validate($request, ['order_id' => 'required|numeric|exists:orders,order_id']);
        $order_id = $request->get('order_id');
        return $this->service->deleteOrderById($order_id);
    }
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
    public function markCompleted(Request $request)
    {
        //ACÁ DEBERIA VALIDAR QUE EL PEDIDO ESTÉ PAGO Y ENTREGADO
        //AUNQUE PROBABLEMENTE TENGA QUE HACERLO DESDE EL REPOSITORIO
        $order_id = $request->get('order_id');
        return $this->service->markCompleted($order_id);
    }
}
