<?php

namespace App\Interfaces;

interface ContactsRepositoryInterface
{
    public function getContacts();
    public function searchContacts(string $search);
    public function getContactById(string $id);
    public function postContact(string $name, string $phone);
    public function updateContact(string $name, string $phone,int $id);
}
