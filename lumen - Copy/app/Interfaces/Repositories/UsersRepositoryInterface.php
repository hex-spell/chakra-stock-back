<?php

namespace App\Interfaces\Repositories;

interface UsersRepositoryInterface
{
    public function getUsers();
    public function addUser(string $name, string $password, string $email);
    public function updateUserName(string $name, int $id);
    public function updateUserPassword(string $password, int $id);
    public function deleteUser(int $id);
}
