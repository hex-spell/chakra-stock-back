<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    private $validateUserName = ['name'=>'required|string|between:4,30'];

    private $validateUserPassword = ['name'=>'required|string|between:4,30'];

    private $validateAddUser = ['name'=>'required|string|between:4,30','email'=>'required|email|between:4,30|unique:users,email','password'=>'required|string|between:4,30'];

    public function getUsers(){
        return User::all();
    }

    public function addUser(){
        $this->validate($this->request,$this->validateAddUser);
        $name = $this->request->json()->get('name');
        $password = app('hash')->make($this->request->json()->get('password'));
        $email = $this->request->json()->get('email');
        return User::create(array('name'=>$name,'password'=>$password,'email'=>$email));
    }

    public function updateUserName(){
        $this->validate($this->request,$this->validateUserName);
        $name = $this->request->json()->get('name');
        $User = User::find($this->request->auth->id);
        $User->name = $name;
        return $User->save();
    }

    public function updateUserPassword(){
        $this->validate($this->request,$this->validateUserPassword);
        $password = $this->request->json()->get('password');
        $User = User::find($this->request->auth->id);
        $User->password = app('hash')->make($password);;
        return $User->save();
    }

    public function deleteUser(int $id){
        return $this->service->deleteUser($id);
    }
}
