<?php

namespace App\Repositories;

use App\Interfaces\Repositories\OrdersRepositoryInterface;
use App\Models\Order;
use App\Models\Contact;
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
    //SINO DESDE EL FRONTEND TENGO QUE HACER QUE NO SE PUEDA ELEGIR Y SIEMPRE PROVEEDORES HAGAN A Y CLIENTES B
    //EN CASO  DE QUE LAS RELACIONES SEAN DEMASIADO COMPLICADAS DE MANEJAR COMO PARA HACER ESTE CAMBIO
    //ESA PODRIA SER LA SOLUCION MAS FLOJA, PERO ES LA MAS RAPIDA AHORA MISMO, CREO
    public function getOrders(string $search, string $completed, string $delivered, string $order, string $type, int $offset)
    {
        $loweredSearch = strtolower($search);
        $loweredOrder = strtolower($order);
        $loweredType = strtolower($type);

        $Orders = Order::where('type', $loweredType)
            ->where(function ($query) use ($completed) {
                switch ($completed) {
                    case "completed":
                        return $query->where('completed', true);
                    case "not_completed":
                        return $query->where('completed', false);
                    case "all":
                    default:
                        return $query;
                }
            })
            ->where(function ($query) use ($delivered) {
                switch ($delivered) {
                    case "delivered":
                        return $query->where('delivered', true);
                    case "not_delivered":
                        return $query->where('delivered', false);
                    case "all":
                    default:
                        return $query;
                }
            })
            ->with('contact')
            ->orderBy('created_at', 'desc');

        //argumentos para el where
        $whereRaw = ['lower(contacts.name) like (?)', ["%{$loweredSearch}%"]];

        //filtra la query por nombre de contacto
        $filteredOrders = $Orders->whereHas('contact', function ($query) use ($whereRaw) {
            return $query->whereRaw($whereRaw[0], $whereRaw[1]);
        });

        //ejecuta la consulta
        $count = $filteredOrders->count();
        $filteredOrders = $filteredOrders->offset($offset)->take(10)->get();

        //agrega propiedades {sum, paid} a cada pedido
        foreach ($filteredOrders as $order) {
            $sum = 0;
            $paid = 0;
            $delivered = true;
            $products_count = 0;
            //loop que suma los valores de los productos multiplicados por la cantidad pedida
            foreach ($order->products()->get() as $product) {
                $productHistory = ProductHistory::find($product->details->product_history_id);
                $price = $order->type === "a" ? $productHistory->buy_price : $productHistory->sell_price;
                $ammount = $product->details->ammount;
                $sum += $price ? $price * $ammount : 0;
                $products_count += $ammount;
                //si uno de todos los productos no se entregó, el checkbox de entregado se va a ver falso en el frontend
                if ($product->details->delivered != $ammount) {
                    $delivered = false;
                }
            }
            //loop que suma todas las transacciones para saber el total pagado
            foreach ($order->transactions()->get() as $transaction) {
                $paid += $transaction->sum;
            }
            //delivered2 funciona para saber si la funcion checkDelivered esta funcionando
            $order->delivered2 = $delivered;
            $order->paid = $paid;
            $order->sum = $sum;
            $order->products_count = $products_count;
        }

        return ['result' => $filteredOrders, 'count' => $count];
    }
    public function searchOrders()
    {
        return "hello";
    }
    //funcion provisoria, no tiene uso real en el frontend
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
            $price = $Order->type === "a" ? $product->productVersion->buy_price : $product->productVersion->sell_price;
            $sum += $Order->type === "a" ?: $price * $product->ammount;
        }

        //loop que suma todas las transacciones
        foreach ($Transactions as $transaction) {
            $paid += $transaction->sum;
        }

        //loop que revisa si los productos estan actualizados
        foreach ($Products as $product) {
            if ($product->product_history_id !== Product::find($product->product_id)->product_history_id) {
                $product->current_version = $product->currentVersion()->first();
            }
        }
        return ['order' => $Order, 'sum' => $sum, 'paid' => $paid, 'contact' => $Order->contact()->first(), 'products' => $Products, 'transactions' => $Transactions];
    }
    public function getOrderProductsByOrderId(int $order_id)
    {
        $Products = OrderProducts::where('order_id', $order_id)->with('productVersion')->select(
            [
                "ammount",
                "delivered",
                "product_id",
                "product_history_id"
            ]
        )->get();
        //loop que revisa si los productos estan actualizados
        foreach ($Products as $product) {
            if ($product->product_history_id !== Product::find($product->product_id)->product_history_id) {
                $product->current_version = $product->currentVersion()->first();
            }
        }
        return ['result' => $Products, 'count' => $Products->count()];
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
        $added = Order::find($order_id)->products()->attach(
            $Product,
            [
                'product_history_id' => $Product->product_history_id,
                'ammount' => $ammount,
                'delivered' => $delivered
            ]
        );
        return ['added' => $added, 'checked' => $this->checkDelivered($order_id)];
    }
    public function removeOrderProduct(int $order_id, int $product_id)
    {
        $removed = Order::find($order_id)->products()->detach($product_id);
        return ['removed' => $removed, 'checked' => $this->checkDelivered($order_id)];
    }
    public function modifyOrderProduct(int $order_id, int $product_id, int $ammount, int $delivered)
    {
        //EN VEZ DE ASIGNAR DELIVERED DE NUEVO, DEBERIA BUSCARLO EN LA TABLA Y ASIGNAR EL VALOR ANTERIOR
        $this->removeOrderProduct($order_id, $product_id);
        $added = $this->addOrderProduct($order_id, $product_id, $ammount, $delivered);
        return ['modified' => $added, 'checked' => $this->checkDelivered($order_id)];
    }
    public function checkDelivered(int $order_id)
    {
        //reviso si todos los productos estan entregados para marcar delivered
        $Order = Order::find($order_id);
        $delivered = true;
        $AllOrderProducts = OrderProducts::where('order_id', $order_id);

        foreach ($AllOrderProducts->get() as $orderProduct) {
            if ($orderProduct->ammount != $orderProduct->delivered) {
                $delivered = false;
            }
        }

        $Order->delivered = $delivered;
        return $Order->save();
    }
    public function markDelivered(int $order_id, int $product_id, int $ammount)
    {
        //busco el pedido para saber el tipo
        $type = Order::find($order_id)->type;

        //busca el producto en el pedido
        $OrderProductQuery = OrderProducts::where('order_id', $order_id)->where('product_id', $product_id);

        //obtengo los datos para hacer la suma en la asignacion
        $OrderProduct = $OrderProductQuery->first();

        //actualizo los numeros del producto
        $update = $OrderProductQuery->update(['delivered' => $OrderProduct->delivered += $ammount]);

        //busco el producto en stock
        $Product = Product::find($product_id);

        //para restarle o sumarle lo que le sumo a lo entregado
        $Product->stock += $type == "a" ? $ammount : -$ammount;

        //OrderProduct es actualizado de esta forma porque la tabla no tiene llave primaria, y no se puede usar la funcion save() sin una
        return ['updated' => $update, 'checked' => $this->checkDelivered($order_id), 'substracted' => $Product->save()];
    }

    public function markDeliveredMultiple(int $order_id, array $products)
    {
        //busco el pedido para saber el tipo
        $type = Order::find($order_id)->type;

        $updatedStock = [];
        $updatedOrderProduct = [];
        foreach ($products as $product) {
            //busca el producto en el pedido
            $OrderProductQuery = OrderProducts::where('order_id', $order_id)->where('product_id', $product['product_id']);

            //obtengo los datos para hacer la suma en la asignacion
            $OrderProduct = $OrderProductQuery->first();

            //actualizo los numeros del producto en el pedido
            $updatedOrderProduct[] = $OrderProductQuery->update(['delivered' => $OrderProduct->delivered += $product['ammount']]);

            //busco el producto en stock
            $Product = Product::find($product['product_id']);

            //para restarle o sumarle lo que le sumo a lo entregado
            $Product->stock += $type == "a" ? $product['ammount'] : -$product['ammount'];

            $updatedStock[] = $Product->save();
        }


        //OrderProduct es actualizado de esta forma porque la tabla no tiene llave primaria, y no se puede usar la funcion save() sin una
        return ['updated' => $updatedOrderProduct, 'checked' => $this->checkDelivered($order_id), 'updated_stock' => $updatedStock];
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
        //el modelo lo cargo aparte para guardar de forma mas limpia
        $Order = Order::find($order_id);
        foreach ($Order->products()->get() as $product) {
            if($product->details->delivered){
                $this->modifyOrderProduct($order_id, $product->product_id, $product->details->delivered, $product->details->delivered);
            }
            else {
                $this->removeOrderProduct($order_id,$product->product_id);
            }
        }
        $Order->completed = true;
        $Order->save();
        //esta funcion va a revisar que este pago el pedido, si no lo está se va a restar del dinero del contacto (si es un pedido tipo a (saliente))
        $OrderDetails = $this->getOrderById($order_id);
        $sum = $OrderDetails['sum'];
        $paid = $OrderDetails['paid'];
        $type = $OrderDetails['order']['type'];
        $Contact = Contact::find($Order->contact_id);
        if ($sum != $paid) {
            switch ($type) {
                case "a":
                    //A ES CUANDO VOS COMPRAS, EL CONTACTO OBTIENE COMO DINERO "A FAVOR" LO QUE TE FALTÓ PAGAR, ES DECIR ES TU DEUDA
                    $Contact->money += $sum - $paid;
                    break;
                case "b":
                    //B ES CUANDO VOS VENDES, AL CONTACTO SE LE RESTA LO QUE QUEDA POR PAGAR, ES SU DEUDA CON VOS
                    $Contact->money += $paid - $sum;
                    break;
            }
        }
        return [$Contact->save()];
    }
}
