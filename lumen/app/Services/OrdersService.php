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

    public function getOrders(string $search, string $order, string $type, int $offset)
    {
        return $this->repo->getOrders($search, $order, $type, $offset);
    }
    public function searchOrders()
    {
        return $this->repo->searchOrders();
    }
    public function getOrderById(int $order_id)
    {
        return $this->repo->getOrderById($order_id);
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
    public function modifyOrderProduct(int $order_id, int $product_id, int $ammount)
    {
        return $this->repo->modifyOrderProduct($order_id, $product_id, $ammount);
    }
    public function removeOrderProduct(int $order_id, int $product_id)
    {
        return $this->repo->removeOrderProduct($order_id, $product_id);
    }
    public function markDelivered(int $product_id, int $ammount)
    {
        return $this->repo->markDelivered($product_id, $ammount);
    }
    public function getTransactions(int $order_id)
    {
        return $this->repo->getTransactions($order_id);
    }
    public function addTransaction(float $sum)
    {
        return $this->repo->addTransaction($sum);
    }
    public function modifyTransaction(int $transaction_id, float $sum)
    {
        return $this->repo->modifyTransaction($transaction_id, $sum);
    }
    public function markCompleted(int $order_id)
    {
        return $this->repo->markCompleted($order_id);
    }
}
