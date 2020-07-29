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

    private $validatePostContact = ['name'=>'required|string|between:4,30','phone'=>'required|digits_between:4,30|numeric|unique:contacts,phone'];

    public function __construct(ContactsServiceInterface $service)
    {
        $this->service = $service;
    }

    public function getContacts(){
        return $this->service->getContacts();
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
        return $this->service->postContact($name,$phone);
    }

    public function updateContact(Request $request){
        $this->validate($request,$this->validateUpdateContact);
        $name = $request->json()->get('name');
        $phone = $request->json()->get('phone');
        $id = $request->json()->get('id');
        return $this->service->updateContact($name,$phone,$id);
    }
}
