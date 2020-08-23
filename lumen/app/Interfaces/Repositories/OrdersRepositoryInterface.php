<?php

namespace App\Interfaces\Repositories;

interface OrdersRepositoryInterface
{
    public function getOrders(string $search, string $order, string $type, int $offset);
    public function searchOrders();
    public function getOrderById(int $order_id);
    public function deleteOrderById(int $order_id);
    public function postOrder(int $contact_id, string $type);
    public function updateOrder(int $order_id, int $contact_id, string $type);
    public function addOrderProduct(int $order_id, int $product_id, int $ammount);
    public function modifyOrderProduct(int $order_id, int $product_id, int $ammount, int $delivered);
    public function removeOrderProduct(int $order_id, int $product_id);
    public function markDelivered(int $order_id, int $product_id, int $ammount);
    public function getTransactions(string $search, string $order, string $type, int $offset);
    public function addTransaction(int $order_id, float $sum);
    public function modifyTransaction(int $transaction_id, float $sum);
    public function deleteTransaction(int $transaction_id);
    public function markCompleted(int $order_id);
}
