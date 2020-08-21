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
    //ME FALTA ORDENARLOS
    public function getOrders(string $search, string $order, string $type, int $offset)
    {
        $loweredSearch = strtolower($search);
        $loweredOrder = strtolower($order);
        $loweredType = strtolower($type);
  
        $Orders = Order::where('type',$loweredType)->with('contact')->withCount('products');

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
        return "hello";
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
    public function addOrderProduct(int $order_id, int $product_id, int $ammount)
    {
        $Product = Product::find($product_id);
        return Order::find($order_id)->products()->attach(
            $Product,
            [
                'product_history_id' => $Product->product_history_id,
                'ammount' => $ammount,
                'delivered' => 0
            ]
        );
    }
    public function removeOrderProduct(int $order_id, int $product_id)
    {
        return Order::find($order_id)->products()->detach($product_id);
    }
    public function modifyOrderProduct(int $order_id, int $product_id, int $ammount)
    {
        $this->removeOrderProduct($order_id, $product_id);
        return $this->addOrderProduct($order_id, $product_id, $ammount);
    }
    public function markDelivered(int $product_id, int $ammount)
    {
        return "hello";
    }
    public function getTransactions(int $order_id)
    {
        return Transaction::all();
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
        return "hello";
    }
}
