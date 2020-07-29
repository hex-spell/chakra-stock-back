<?php

namespace App\Interfaces\Repositories;

interface ContactsRepositoryInterface
{
    public function getContacts();
    public function searchContacts(string $search);
    public function getContactById(int $id);
    public function deleteContactById(int $id);
    public function postContact(string $name, string $phone, string $role, float $money, string $address);
    public function updateContact(string $name, string $phone,int $id);
}
