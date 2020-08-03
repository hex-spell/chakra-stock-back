<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\ContactsServiceInterface;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $service;

    private $validateUpdateContact = ['name'=>'required|string|between:4,30','phone'=>'required|digits_between:4,30|numeric|unique:contacts,phone','id'=>'required|integer|exist:contacts'];

    private $validatePostContact = ['name'=>'required|string|between:4,30','phone'=>'required|digits_between:4,30|numeric|unique:contacts,phone','address'=>'required|string|between:4,30','role'=>'required|string|size:1','money'=>'required|numeric'];

    public function __construct(ContactsServiceInterface $service)
    {
        $this->service = $service;
    }

    //NO OLVIDARME DE AGREGAR EL PARAMETRO DE ORDENAR
    public function getContacts(Request $request){
        //saca los 4 parametros de la url
        $offset = $request->get('offset') ? $request->get('offset') : 0;
        $search = $request->get('search') ? $request->get('search') : '';
        //role es 'c' o 'p', clientes o proveedores respectivamente
        //por default quiero que devuelva clientes
        //deberia buscar una forma de validar 'role' para que solamente pueda ser 'c' o 'p'
        $role = $request->get('role') ? $request->get('role') : 'c';
        $order = $request->get('order') ? $request->get('order') : 'name';
        //deberia preguntarle a alguien si esto se puede refactorizar, son demasiados parametros para una sola funcion
        return $this->service->getContacts($offset,$search,$role,$order);
    }

    public function searchContacts(string $search){
        return $this->service->searchContacts($search);
    }

    public function getContactById(int $id){
        return $this->service->getContactById($id);
    }

    public function deleteContactById(int $id){
        return $this->service->deleteContactById($id);
    }

    public function postContact(Request $request){
        $this->validate($request, $this->validatePostContact);
        $name = $request->json()->get('name');
        $phone = $request->json()->get('phone');
        $address = $request->json()->get('address');
        $role = $request->json()->get('role');
        $money = $request->json()->get('money');
        return $this->service->postContact($name, $phone, $role, $money, $address);
    }

    public function updateContact(Request $request){
        $this->validate($request,$this->validateUpdateContact);
        $name = $request->json()->get('name');
        $phone = $request->json()->get('phone');
        $id = $request->json()->get('id');
        return $this->service->updateContact($name,$phone,$id);
    }
}
