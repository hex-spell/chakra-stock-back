<?php

namespace App\Repositories;

use App\Interfaces\Repositories\OrdersRepositoryInterface;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProducts;
use App\Models\ProductHistory;

class OrdersRepository implements OrdersRepositoryInterface
{
    //TENGO QUE BUSCAR ALGUNA FORMA DE CONSEGUIR LA SUMA DE LOS VALORES DE TODOS LOS PRODUCTOS EN UN PEDIDO
    public function getOrders(string $search, string $order, string $type, int $offset)
    {
        $loweredSearch = strtolower($search);
        $loweredOrder = strtolower($order);
        $Orders = Order::with('contact')->withCount('products')->get();
        foreach ($Orders as $order) {
            $sum = 0;
            foreach ($order->products()->get() as $product) {
                $productHistory = ProductHistory::find($product->details->product_history_id);
                $sell = $productHistory->sell_price;
                $ammount = $product->details->ammount;
                $sum += $sell ? $sell*$ammount : 0;
            }
            $order->sum = $sum;
        }

        return ['result' => $Orders];
    }
    public function searchOrders()
    {
        return "hello";
    }
    public function getOrderById(int $order_id)
    {
        $Order = Order::find($order_id);
        $Products = OrderProducts::where('order_id', $order_id)->with('productVersion')->select(
            [
                "ammount",
                "delivered",
                "product_id",
                "product_history_id"
            ]
        )->get();
        $sum = 0;
        foreach ($Products as $product) {
            $sum += $product->productVersion->sell_price*$product->ammount;
        }
        //loop que revisa si los productos estan actualizados
        foreach ($Products as $product) {
            if ($product->product_history_id !== Product::find($product->product_id)->product_history_id) {
                $product->currentVersion = $product->currentVersion()->first();
            }
        }
        return ['order' => $Order, 'contact' => $Order->contact()->first(), 'products' => $Products,  'sum' => $sum];
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
        return "hello";
    }
    public function addTransaction(float $sum)
    {
        return "hello";
    }
    public function modifyTransaction(int $transaction_id, float $sum)
    {
        return "hello";
    }
    public function markCompleted(int $order_id)
    {
        return "hello";
    }
}
