<?php
namespace App\Repositories;
use App\Interfaces\Repositories\UsersRepositoryInterface;
use App\Models\User;

class UsersRepository implements UsersRepositoryInterface {
    public function getUsers(){
        return User::all();
    }

    public function addUser(string $name, string $password, string $email){
        return User::create(array('name'=>$name,'password'=>$password,'email'=>$email));
    }

    public function updateUserName(string $name, int $id){
        $User = User::find($id);
        $User->name = $name;
        return $User->save();
    }

    public function updateUserPassword(string $password, int $id){
        $User = User::find($id);
        $User->password = app('hash')->make($password);
        return $User->save();
    }

    public function deleteUser(int $id){
        //return $this->service->deleteUser($id);
    }
}