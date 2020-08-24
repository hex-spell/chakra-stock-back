<?php

namespace App\Repositories;

use App\Interfaces\Repositories\OrdersRepositoryInterface;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProducts;
use App\Models\ProductHistory;
use App\Models\Transaction;

class OrdersRepository implements OrdersRepositoryInterface
{
    //POR AHI EN VEZ DE HACER UNA COLUMNA CON EL TIPO DE TRANSACCION, DEBERÍA HACER QUE EL TIPO LO DEFINA EL TIPO DE CONTACTO
    //LOS DATOS VAN A SER MAS SOLIDOS DE ESA FORMA
    //ES REDUNDANTE QUE SIEMPRE TENGA QUE ACLARAR QUE LOS CLIENTES HACEN PEDIDOS COMPRANDO
    //Y CASI NUNCA SUCEDE QUE SE LE COMPRA A UN CLIENTE
    public function getOrders(string $search, string $order, string $type, int $offset)
    {
        $loweredSearch = strtolower($search);
        $loweredOrder = strtolower($order);
        $loweredType = strtolower($type);

        $Orders = Order::where('type', $loweredType)->with('contact')->withCount('products')->orderBy('created_at', 'desc');

        //argumentos para el where
        $whereRaw = ['lower(contacts.name) like (?)', ["%{$loweredSearch}%"]];

        //filtra la query por nombre de contacto
        $filteredOrders = $Orders->whereHas('contact', function ($query) use ($whereRaw) {
            return $query->whereRaw($whereRaw[0], $whereRaw[1]);
        });

        //ejecuta la consulta
        $filteredOrders = $filteredOrders->get();

        //agrega propiedades {sum, paid} a cada pedido
        foreach ($filteredOrders as $order) {
            $sum = 0;
            $paid = 0;
            //loop que suma los valores de los productos multiplicados por la cantidad pedida
            foreach ($order->products()->get() as $product) {
                $productHistory = ProductHistory::find($product->details->product_history_id);
                $sell = $productHistory->sell_price;
                $ammount = $product->details->ammount;
                $sum += $sell ? $sell * $ammount : 0;
            }
            //loop que suma todas las transacciones para saber el total pagado
            foreach ($order->transactions()->get() as $transaction) {
                $paid += $transaction->sum;
            }
            $order->paid = $paid;
            $order->sum = $sum;
        }

        return ['result' => $filteredOrders];
    }
    public function searchOrders()
    {
        return "hello";
    }
    public function getOrderById(int $order_id)
    {
        $Order = Order::find($order_id);
        $Transactions = $Order->transactions()->select(['transaction_id', 'sum', 'created_at'])->get();
        $Products = OrderProducts::where('order_id', $order_id)->with('productVersion')->select(
            [
                "ammount",
                "delivered",
                "product_id",
                "product_history_id"
            ]
        )->get();
        $sum = 0;
        $paid = 0;

        //loop que suma los valores de los productos
        foreach ($Products as $product) {
            $sum += $product->productVersion->sell_price * $product->ammount;
        }

        //loop que suma todas las transacciones
        foreach ($Transactions as $transaction) {
            $paid += $transaction->sum;
        }

        //loop que revisa si los productos estan actualizados
        foreach ($Products as $product) {
            if ($product->product_history_id !== Product::find($product->product_id)->product_history_id) {
                $product->currentVersion = $product->currentVersion()->first();
            }
        }
        return ['order' => $Order, 'sum' => $sum, 'paid' => $paid, 'contact' => $Order->contact()->first(), 'products' => $Products, 'transactions' => $Transactions];
    }
    public function deleteOrderById(int $order_id)
    {
        //las transacciones y los orderproducts se mantienen en caso de querer reestablecer el pedido
        return [Order::destroy($order_id)];
    }
    public function postOrder(int $contact_id, string $type)
    {
        return Order::create(['contact_id' => $contact_id, 'type' => $type]);
    }
    public function updateOrder(int $order_id, int $contact_id, string $type)
    {
        $Order = Order::find($order_id);
        $Order->contact_id = $contact_id;
        $Order->type = $type;
        return $Order->save();
    }
    public function addOrderProduct(int $order_id, int $product_id, int $ammount, int $delivered = 0)
    {
        $Product = Product::find($product_id);
        return Order::find($order_id)->products()->attach(
            $Product,
            [
                'product_history_id' => $Product->product_history_id,
                'ammount' => $ammount,
                'delivered' => $delivered
            ]
        );
    }
    public function removeOrderProduct(int $order_id, int $product_id)
    {
        return Order::find($order_id)->products()->detach($product_id);
    }
    public function modifyOrderProduct(int $order_id, int $product_id, int $ammount, int $delivered)
    {
        //EN VEZ DE ASIGNAR DELIVERED DE NUEVO, DEBERIA BUSCARLO EN LA TABLA Y ASIGNAR EL VALOR ANTERIOR
        $this->removeOrderProduct($order_id, $product_id);
        return $this->addOrderProduct($order_id, $product_id, $ammount, $delivered);
    }
    public function markDelivered(int $order_id, int $product_id, int $ammount)
    {
        //busca el producto en el pedido
        $OrderProductQuery = OrderProducts::where('order_id', $order_id)->where('product_id', $product_id);

        //obtengo los datos para hacer la suma en la asignacion
        $OrderProduct = $OrderProductQuery->first();

        //busco el producto en stock
        $Product = Product::find($product_id);

        //para restarle lo que le sumo a lo entregado
        $Product->stock -= $ammount;

        //OrderProduct es actualizado de esta forma porque la tabla no tiene llave primaria, y no se puede usar la funcion save() sin una
        return [$OrderProductQuery->update(['delivered' => $OrderProduct->delivered += $ammount]), $Product->save()];
    }

    public function getTransactions(string $search, string $order, string $type, int $offset)
    {
        $loweredSearch = strtolower($search);
        $loweredOrder = strtolower($order);
        $loweredType = strtolower($type);

        $Transactions = Transaction::with('order');

        //argumentos para el where
        //lo hago de esta manera para poder verlos aparte
        //el whereraw es necesario para que sea case insensitive
        //podria crear una funcion personalizada para esto, pero ahora mismo no tengo ganas
        //le pondria whereLowerLikeLower(column,variable);
        $whereRawType = ['lower(type) like (?)', ["%{$loweredType}%"]];
        $whereRawName = ['lower(name) like (?)', ["%{$loweredSearch}%"]];


        //filtra la query por tipo de transaccion y nombre de contacto
        $filteredTransactions = $Transactions->whereHas('order', function ($order) use ($whereRawType, $whereRawName) {
            $orderFilteredByContactName = $order->whereHas('contact', function ($contact) use ($whereRawName) {
                return $contact->whereRaw($whereRawName[0], $whereRawName[1]);
            });
            return $orderFilteredByContactName->whereRaw($whereRawType[0], $whereRawType[1]);
        });

        return ['result' => $filteredTransactions->with('order.contact')->orderBy('created_at', 'desc')->take(10)->offset($offset)->get()];
    }
    public function addTransaction(int $order_id, float $sum)
    {
        $Order = Order::find($order_id);
        return $Order->transactions()->create(['sum' => $sum, 'contact_id' => $Order->contact()->first()->contact_id]);
    }
    public function modifyTransaction(int $transaction_id, float $sum)
    {
        $Transaction = Transaction::find($transaction_id);
        $Transaction->sum = $sum;
        return $Transaction->save();
    }
    public function deleteTransaction(int $transaction_id)
    {
        return Transaction::find($transaction_id)->destroy();
    }
    public function markCompleted(int $order_id)
    {
        //esta funcion va a revisar que este pago el pedido, si no lo está se va a restar del dinero del contacto (si es un pedido tipo a (saliente))

        return "hello";
    }
}
