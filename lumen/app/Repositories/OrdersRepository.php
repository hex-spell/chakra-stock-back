<?php
namespace App\Repositories;
use App\Interfaces\Repositories\OrdersRepositoryInterface;
use App\Models\Orders;

class OrdersRepository implements OrdersRepositoryInterface {
    public function getOrders(){
        return Orders::select('*')->join('contacts','contact_id','id')->take(10)->get();
    }

    public function searchOrdersByContactName(string $search){
        $loweredString = strtolower($search);
        return Orders::select('*')->join('contacts','contact_id','id')->whereRaw('lower(name) like (?)',["%{$loweredString}%"])->take(10)->get();
    }

    public function getOrderById(int $id){
        return Orders::select('*')->where('order_id','=',$id)->join('contacts','contact_id','id')->get();
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