<?php

namespace App\Repositories;

use App\Interfaces\Repositories\OrdersRepositoryInterface;
use App\Models\Order;

class OrdersRepository implements OrdersRepositoryInterface
{
    public function getOrders(string $search, string $order, string $type, int $offset)
    {
        return "hello";
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
        return "hello";
    }
    public function updateOrder(int $contact_id, string $type)
    {
        return "hello";
    }
    public function addOrderProduct(int $product_id, int $product_history_id, int $ammount)
    {
        return "hello";
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
