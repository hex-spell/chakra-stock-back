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

    return Order::with('contact')->get();
    }
    public function searchOrders()
    {
        return "hello";
    }
    public function getOrderById()
    {
        return "hello";
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
    public function modifyOrderProduct(int $product_id, int $product_history_id, int $ammount)
    {
        return "hello";
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
