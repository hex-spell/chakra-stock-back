<?php
namespace App\Repositories;
use App\Interfaces\Repositories\ContactsRepositoryInterface;
use App\Models\Contact;

class ContactsRepository implements ContactsRepositoryInterface {
    public function getContacts(int $offset,string $search,string $role,string $order){
        //los paso a minusculas para asegurarme de no perder resultados
        //tengo que hacer un middleware para hacer todo esto minusculas
        $loweredSearch = strtolower($search);
        $loweredRole = strtolower($role);
        $loweredOrder = strtolower($order);
        $query = Contact::whereRaw('lower(name) like (?) and lower(role) = (?)',["%{$loweredSearch}%","{$loweredRole}"]);
        return array('contacts'=>$query->take(10)->skip($offset)->orderBy($loweredOrder)->get(),'count'=>$query->count());
    }

    public function searchContacts(string $search){
        $loweredString = strtolower($search);
        return Contact::whereRaw('lower(name) like (?)',["%{$loweredString}%"])->take(10)->get();
    }

    public function getContactById(int $id){
        return Contact::find($id);
    }

    public function deleteContactById(int $id){
        return Contact::destroy($id);
    }

    public function postContact(string $name, string $phone, string $role, float $money, string $address){
        return Contact::create(array('name'=>$name,'phone'=>$phone,'role'=>$role,'money'=>$money,'address'=>$address));
    }

    public function updateContact(string $name,string $phone,string $address,float $money,int $id){
        $Contact = Contact::find($id);
        $Contact->name = $name;
        $Contact->phone = $phone;
        $Contact->address = $address;
        $Contact->money = $money;
        return $Contact->save();
    }
}