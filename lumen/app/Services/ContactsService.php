<?php

namespace App\Services;

use App\Interfaces\Repositories\ContactsRepositoryInterface;
use App\Interfaces\Services\ContactsServiceInterface;

class ContactsService implements ContactsServiceInterface
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $repo;

    public function __construct(ContactsRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getContacts(){
        return $this->repo->getContacts();
    }

    public function searchContacts(string $search){
        return $this->repo->searchContacts($search);
    }

    public function getContactById(int $id){
        return $this->repo->getContactById($id);
    }

    public function deleteContactById(int $id){
        return $this->repo->deleteContactById($id);
    }

    public function postContact(string $name, string $phone){
        return $this->repo->postContact($name,$phone);
    }

    public function updateContact(string $name, string $phone, int $id){
        return $this->repo->updateContact($name,$phone,$id);
    }
}
