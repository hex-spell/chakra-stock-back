<?php
namespace App\Services;
use App\Interfaces\Services\OrdersServiceInterface;
use App\Interfaces\Repositories\OrdersRepositoryInterface;

Class OrdersService implements OrdersServiceInterface{
    private $repo;

    public function __construct(OrdersRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getOrders(){
        return $this->repo->getOrders();
    }

    public function searchOrdersByContactName(string $search){
        return $this->repo->searchOrdersByContactName($search);
    }

    public function getOrderById(int $id){
        return $this->repo->getOrderById($id);
    }

}