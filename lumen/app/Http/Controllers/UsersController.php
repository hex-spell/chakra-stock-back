<?php

namespace App\Http\Controllers;

use App\Interfaces\Repositories\UsersRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $request;
    private $repo;

    public function __construct(Request $request, UsersRepositoryInterface $repo)
    {
        $this->request = $request;
        $this->repo = $repo;
    }

    private $validateUserName = ['name'=>'required|string|between:4,30'];

    private $validateUserPassword = ['name'=>'required|string|between:4,30'];

    private $validateAddUser = ['name'=>'required|string|between:4,30','email'=>'required|email|between:4,30|unique:users,email','password'=>'required|string|between:4,30'];

    public function getUsers(){
        return User::all();
    }

    public function getUserByID(int $id){
        return User::find($id);
    }

    public function addUser(){
        $this->validate($this->request,$this->validateAddUser);
        $name = $this->request->json()->get('name');
        $password = app('hash')->make($this->request->json()->get('password'));
        $email = $this->request->json()->get('email');
        return $this->repo->addUser($name,$password,$email);
    }

    public function updateUserName(){
        $this->validate($this->request,$this->validateUserName);
        $name = $this->request->json()->get('name');
        $id = $this->request->auth->id;
        return $this->repo->updateUserName($name,$id);
    }

    public function updateUserPassword(){
        $this->validate($this->request,$this->validateUserPassword);
        $password = $this->request->json()->get('password');
        $id = $this->request->auth->id;
        return $this->repo->updateUserPassword($password,$id);
    }

    public function deleteUser(int $id){
        //return $this->service->deleteUser($id);
    }
}
