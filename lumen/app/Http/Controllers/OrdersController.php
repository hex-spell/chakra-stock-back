<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\Services\OrdersServiceInterface;

class OrdersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $OrdersService;

    public function __construct(OrdersServiceInterface $Service)
    {
        $this->OrdersService = $Service;
    }

    //private $validateUpdateContact = array(['name'=>'required|string|between:4,30','phone'=>'required|digits_between:4,30|numeric|unique:contacts,phone','id'=>'required|integer|exist:contacts']);

    //private $validatePostContact = array(['name'=>'required|string|between:4,30','phone'=>'required|digits_between:4,30|numeric|unique:contacts,phone']);

    

    public function getOrders(){
        return $this->OrdersService->getOrders();
    }

    public function searchOrdersByContactName(string $search){
        $sanitizedSearch = $this->sanitizeString($search);
        return $this->OrdersService->searchOrdersByContactName($sanitizedSearch);
    }

    public function getOrderById(int $id){
        return $this->OrdersService->getOrderById($id);
    }

    /*public function deleteOrderById(int $id){
        return $this->repo->deleteOrderById($id);
    }*/

    /*public function postOrder(Request $request){
        $this->validate($request, $this->validatePostOrder);
        $name = $this->sanitizeString($request->json()->get('name')); //sanitized name
        $phone = $request->json()->get('phone');
        return $this->repo->postOrder($name,$phone);
    }*/

    /*public function updateOrder(Request $request){
        $this->validate($request,$this->validateUpdateOrder);
        $name = $this->sanitizeString($request->json()->get('name')); //sanitized name
        $phone = $request->json()->get('phone');
        $id = $request->json()->get('id');
        return $this->repo->updateOrder($name,$phone,$id);
    }*/
}
