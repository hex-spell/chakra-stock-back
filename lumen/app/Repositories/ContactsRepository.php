<?php
namespace App\Repositories;
use App\Interfaces\ContactsRepositoryInterface;

class ContactsRepository implements ContactsRepositoryInterface {
    public function getContacts(){
        return app('db')->select("SELECT * FROM contacts");
    }

    public function searchContacts(string $search){
        $loweredString = strtolower($search);
        return app('db')->select("SELECT * FROM contacts WHERE LOWER(name) LIKE '%$loweredString%'");
    }

    public function getContactById(string $id){
        return app('db')->select("SELECT * FROM contacts WHERE id = $id");
    }

    public function postContact(string $name, string $phone){
        return app('db')->insert("INSERT INTO contacts (name,phone) VALUES ('$name',$phone)");
    }
}