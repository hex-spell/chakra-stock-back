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

    public function getContacts(int $offset,string $search,string $role,string $order)
    {
        return $this->repo->getContacts($offset,$search,$role,$order);
    }

    public function searchContacts(string $search)
    {
        return $this->repo->searchContacts($search);
    }

    public function getContactById(int $id)
    {
        return $this->repo->getContactById($id);
    }

    public function deleteContactById(int $id)
    {
        return $this->repo->deleteContactById($id);
    }

    public function postContact(string $name, string $phone, string $role, float $money, string $address)
    {
        return $this->repo->postContact($name, $phone, $role, $money, $address);
    }

    public function updateContact(string $name, string $phone, int $id)
    {
        return $this->repo->updateContact($name, $phone, $id);
    }
}
