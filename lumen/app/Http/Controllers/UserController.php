<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\ContactsServiceInterface;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    //private $service;

    private $validateUpdateUser = ['name'=>'required|string|between:4,30','password'=>'required|string|between:4,30','email'=>'required|string|between:4,30','id'=>'required|integer|exist:contacts','api_token'=>'required|string|size:60'];

    private $validateAddUser = ['name'=>'required|string|between:4,30','email'=>'required|email|between:4,30|unique:users,email','password'=>'required|string|between:4,30'];

    public function addUser(Request $request){
        $this->validate($request,$this->validateAddUser);
        $name = $request->json()->get('name');
        $password = app('hash')->make($request->json()->get('password'));
        $email = $request->json()->get('email');
        return User::create(array('name'=>$name,'password'=>$password,'email'=>$email));
    }

    public function updateUser(string $search){
        return $this->service->updateUser($search);
    }

    public function deleteUser(int $id){
        return $this->service->deleteUser($id);
    }
}
