<?php

namespace App\Repositories;

use App\Interfaces\Repositories\OrdersRepositoryInterface;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProducts;
use App\Models\ProductHistory;

class OrdersRepository implements OrdersRepositoryInterface
{
    public function getOrders(string $search, string $order, string $type, int $offset)
    {
        $loweredSearch = strtolower($search);
        $loweredOrder = strtolower($order);
        $Orders = Order::with('contact')->withCount('products')->get();
        
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
            $sum += $product->productVersion->sell_price;
        }
        //loop que revisa si los productos estan actualizados
        foreach ($Products as $product) {
            if ($product->product_history_id !== Product::find($product->product_id)->product_history_id) {
                $product->currentVersion = $product->currentVersion()->first();
            }
        }
        return ['order' => $Order, 'contact' => $Order->contact()->first(), 'products' => $Products,  'sum' => $sum ];
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
    public function modifyOrderProduct(int $order_id, int $product_id, int $ammount)
    {
        $Product = Product::find($product_id);
        return Order::find($order_id)->products()->sync(
            $Product,
            [
                'product_history_id' => $Product->product_history_id,
                'ammount' => $ammount,
                'delivered' => 0
            ]
        );
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
