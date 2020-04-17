<?php

namespace App\Http\Controllers;

use App\Interfaces\OrdersRepositoryInterface;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $repo;

    //private $validateUpdateContact = array(['name'=>'required|string|between:4,30','phone'=>'required|digits_between:4,30|numeric|unique:contacts,phone','id'=>'required|integer|exist:contacts']);

    //private $validatePostContact = array(['name'=>'required|string|between:4,30','phone'=>'required|digits_between:4,30|numeric|unique:contacts,phone']);

    public function __construct(OrdersRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getOrders(){
        return $this->repo->getOrders();
    }

    public function searchOrders(string $search){
        $sanitizedSearch = $this->sanitizeString($search);
        return $this->repo->searchOrders($sanitizedSearch);
    }

    public function getOrderById(int $id){
        return $this->repo->getOrderById($id);
    }

    public function deleteOrderById(int $id){
        return $this->repo->deleteOrderById($id);
    }

    public function postOrder(Request $request){
        $this->validate($request, $this->validatePostOrder);
        $name = $this->sanitizeString($request->json()->get('name')); //sanitized name
        $phone = $request->json()->get('phone');
        return $this->repo->postOrder($name,$phone);
    }

    public function updateOrder(Request $request){
        $this->validate($request,$this->validateUpdateOrder);
        $name = $this->sanitizeString($request->json()->get('name')); //sanitized name
        $phone = $request->json()->get('phone');
        $id = $request->json()->get('id');
        return $this->repo->updateOrder($name,$phone,$id);
    }
}
