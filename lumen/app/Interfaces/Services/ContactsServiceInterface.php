<?php

namespace App\Interfaces\Services;

interface ContactsServiceInterface
{
    public function getContacts(int $offset,string $search,string $role,string $order);
    public function searchContacts(string $search);
    public function getContactById(int $id);
    public function deleteContactById(int $id);
    public function postContact(string $name, string $phone, string $role, float $money, string $address);
    public function updateContact(string $name,string $phone,string $address,float $money,int $id);
}
