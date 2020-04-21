<?php

namespace App\Http\Controllers;

use App\Interfaces\Repositories\ContactsRepositoryInterface;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $repo;

    private $validateUpdateContact = array(['name'=>'required|string|between:4,30','phone'=>'required|digits_between:4,30|numeric|unique:contacts,phone','id'=>'required|integer|exist:contacts']);

    private $validatePostContact = array(['name'=>'required|string|between:4,30','phone'=>'required|digits_between:4,30|numeric|unique:contacts,phone']);

    public function __construct(ContactsRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getContacts(){
        return $this->repo->getContacts();
    }

    public function searchContacts(string $search){
        $sanitizedSearch = $this->sanitizeString($search);
        return $this->repo->searchContacts($sanitizedSearch);
    }

    public function getContactById(int $id){
        return $this->repo->getContactById($id);
    }

    public function deleteContactById(int $id){
        return $this->repo->deleteContactById($id);
    }

    public function postContact(Request $request){
        $this->validate($request, $this->validatePostContact);
        $name = $this->sanitizeString($request->json()->get('name')); //sanitized name
        $phone = $request->json()->get('phone');
        return $this->repo->postContact($name,$phone);
    }

    public function updateContact(Request $request){
        $this->validate($request,$this->validateUpdateContact);
        $name = $this->sanitizeString($request->json()->get('name')); //sanitized name
        $phone = $request->json()->get('phone');
        $id = $request->json()->get('id');
        return $this->repo->updateContact($name,$phone,$id);
    }
}
