<?php

namespace App\Interfaces;

interface OrdersRepositoryInterface
{
    public function getOrders();
    public function searchOrders(string $search);
    public function getOrderById(int $id);
    public function deleteOrderById(int $id);
    public function postOrder(string $name, string $phone);
    public function updateOrder(string $name, string $phone,int $id);
}
