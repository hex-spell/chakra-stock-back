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

    public function getContactById(int $id){
        return app('db')->select("SELECT * FROM contacts WHERE id = $id");
    }

    public function deleteContactById(int $id){
        return app('db')->delete("DELETE FROM contacts WHERE id = $id");
    }

    public function postContact(string $name, string $phone){
        return app('db')->insert("INSERT INTO contacts (name,phone) VALUES ('$name',$phone)");
    }

    public function updateContact(string $name, string $phone, int $id){
        return app('db')->update("UPDATE contacts SET name='$name', phone=$phone WHERE id=$id");
    }
}