<?php

namespace App\Services;

use App\Interfaces\Services\OrdersServiceInterface;
use App\Interfaces\Repositories\OrdersRepositoryInterface;

class OrdersService implements OrdersServiceInterface
{
    private $repo;

    public function __construct(OrdersRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getOrders(string $search, string $completed, string $delivered, string $order, string $type, int $offset)
    {
        return $this->repo->getOrders($search, $completed, $delivered, $order, $type, $offset);
    }
    public function getOrderById(int $order_id)
    {
        return $this->repo->getOrderById($order_id);
    }
    public function getOrderProductsByOrderId(int $order_id){
        return $this->repo->getOrderProductsByOrderId($order_id);
    }
    public function deleteOrderById(int $order_id)
    {
        return $this->repo->deleteOrderById($order_id);
    }
    public function postOrder(int $contact_id, string $type)
    {
        return $this->repo->postOrder($contact_id, $type);
    }
    public function updateOrder(int $order_id, int $contact_id, string $type)
    {
        return $this->repo->updateOrder($order_id, $contact_id, $type);
    }
    public function addOrderProduct(int $order_id, int $product_id, int $ammount)
    {
        return $this->repo->addOrderProduct($order_id, $product_id, $ammount);
    }
    public function modifyOrderProduct(int $order_id, int $product_id, int $ammount, int $delivered)
    {
        return $this->repo->modifyOrderProduct($order_id, $product_id, $ammount, $delivered);
    }
    public function removeOrderProduct(int $order_id, int $product_id)
    {
        return $this->repo->removeOrderProduct($order_id, $product_id);
    }
    public function markDelivered(int $order_id, int $product_id, int $ammount)
    {
        return $this->repo->markDelivered($order_id, $product_id, $ammount);
    }
    public function markDeliveredMultiple(int $order_id, array $products)
    {
        return $this->repo->markDeliveredMultiple($order_id, $products);
    }
    public function getTransactions(string $search, string $order, string $type, int $offset)
    {
        return $this->repo->getTransactions($search, $order, $type, $offset);
    }
    public function addTransaction(int $order_id, float $sum)
    {
        return $this->repo->addTransaction($order_id, $sum);
    }
    public function modifyTransaction(int $transaction_id, float $sum)
    {
        return $this->repo->modifyTransaction($transaction_id, $sum);
    }
    public function deleteTransaction(int $transaction_id)
    {
        return $this->repo->deleteTransaction($transaction_id);
    }
    public function markCompleted(int $order_id)
    {
        return $this->repo->markCompleted($order_id);
    }
}
