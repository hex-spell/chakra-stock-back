<?php

namespace App\Interfaces\Repositories;

interface OrdersRepositoryInterface
{
    public function getOrders(string $search, string $order, string $type, int $offset);
    public function searchOrders();
    public function getOrderById();
    public function deleteOrderById(int $order_id);
    public function postOrder(int $contact_id, string $type);
    public function updateOrder(int $order_id, int $contact_id, string $type);
    public function addOrderProduct(int $order_id, int $product_id, int $ammount);
    public function modifyOrderProduct(int $product_id, int $product_history_id, int $ammount);
    public function markDelivered(int $product_id, int $ammount);
    public function getTransactions(int $order_id);
    public function addTransaction(float $sum);
    public function modifyTransaction(int $transaction_id, float $sum);
    public function markCompleted(int $order_id);
}
