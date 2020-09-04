<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\TransactionsServiceInterface;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $service;

    public function __construct(TransactionsServiceInterface $service)
    {
        $this->service = $service;
    }

    //NO OLVIDARME DE AGREGAR EL PARAMETRO DE ORDENAR
    public function getTransactions(Request $request)
    {
        //saca los 4 parametros de la url
        $offset = $request->get('offset') ? $request->get('offset') : 0;
        $search = $request->get('search') ? $request->get('search') : '';
        //role es 'c' o 'p', clientes o proveedores respectivamente
        //por default quiero que devuelva clientes
        //deberia buscar una forma de validar 'role' para que solamente pueda ser 'c' o 'p'
        $type = $request->get('type') ? $request->get('type') : 'a';
        //deberia preguntarle a alguien si esto se puede refactorizar, son demasiados parametros para una sola funcion
        return $this->service->getTransactions($offset, $search, $type);
    }

    public function getTransactionsMinified()
    {
        return $this->service->getTransactionsMinified();
    }

    public function searchTransactions(string $search)
    {
        return $this->service->searchTransactions($search);
    }

    public function getTransactionById(int $id)
    {
        return $this->service->getTransactionById($id);
    }

    public function deleteTransactionById(int $id)
    {
        return $this->service->deleteTransactionById($id);
    }

    public function postTransaction(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|between:4,30',
                'phone' => 'required|digits_between:4,30|numeric|unique:contacts,phone',
                'address' => 'required|string|between:4,30',
                'role' => 'required|string|size:1',
                'money' => 'required|numeric'
            ]
        );
        $name = $request->get('name');
        $phone = $request->get('phone');
        $address = $request->get('address');
        $role = $request->get('role');
        $money = $request->get('money');
        return $this->service->postTransaction($name, $phone, $role, $money, $address);
    }

    public function updateTransaction(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|between:4,30',
                'address' => 'required|string|between:4,30',
                'contact_id' => 'required|integer|exists:contacts,contact_id',
                'money' => 'required|numeric',
                'phone' => 'required|numeric|unique:contacts,phone,'
                    . $request->get('contact_id') .
                    ',contact_id'
            ]
        );
        $name = $request->get('name');
        $phone = $request->get('phone');
        $address = $request->get('address');
        $money = $request->get('money');
        $id = $request->get('contact_id');
        return $this->service->updateTransaction($name, $phone, $address, $money, $id);
    }
}
