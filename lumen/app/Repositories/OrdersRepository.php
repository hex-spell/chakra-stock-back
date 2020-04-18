<?php
namespace App\Repositories;
use App\Interfaces\OrdersRepositoryInterface;

class OrdersRepository implements OrdersRepositoryInterface {
    public function getOrders(){
        return app('db')->select("SELECT * FROM orders JOIN contacts ON orders.contact_id = contacts.id");
    }

    public function searchOrdersByContactName(string $search){
        $loweredString = strtolower($search);
        return app('db')->select("SELECT * FROM orders JOIN contacts ON orders.contact_id = contacts.id WHERE LOWER(name) LIKE '%$loweredString%'");
    }

    public function getOrderById(int $id){
        return app('db')->select("SELECT * FROM orders JOIN contacts ON orders.contact_id = contacts.id WHERE id = $id");
    }

    /*public function deleteOrderById(int $id){
        return app('db')->delete("DELETE FROM contacts WHERE id = $id");
    }

    public function postOrder(string $name, string $phone){
        return app('db')->insert("INSERT INTO contacts (name,phone) VALUES ('$name',$phone)");
    }

    public function updateOrder(string $name, string $phone, int $id){
        return app('db')->update("UPDATE contacts SET name='$name', phone=$phone WHERE id=$id");
    }*/
}