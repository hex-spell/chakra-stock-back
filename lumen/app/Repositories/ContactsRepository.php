<?php
namespace App\Repositories;
use App\Interfaces\Repositories\ContactsRepositoryInterface;
use App\Models\Contact;

class ContactsRepository implements ContactsRepositoryInterface {
    public function getContacts(){
        return Contact::all()->take(10);
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

    public function postContact(string $name, string $phone){
        return Contact::create(array('name'=>$name,'phone'=>$phone));
    }

    public function updateContact(string $name, string $phone, int $id){
        $Contact = Contact::find($id);
        $Contact->name = $name;
        $Contact->phone = $phone;
        return $Contact->save();
    }
}