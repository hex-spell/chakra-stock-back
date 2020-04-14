<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getContacts(){
        return app('db')->select("SELECT * FROM contacts");
    }

    public function searchContacts(string $search){
        $loweredString = strtolower($search);
        return app('db')->select("SELECT * FROM contacts WHERE LOWER(name) LIKE '%$loweredString%'");
    }

    public function getContactById(string $id){
        if (is_numeric($id)){
            return app('db')->select("SELECT * FROM contacts WHERE id = $id");
        }
        else return response()->json(['error'=>'id is not numeric']);
    }

    public function postContact(Request $request){
        $name = $request->json()->get('name');
        $phone = $request->json()->get('phone');
        return app('db')->insert("INSERT INTO contacts (name,phone) VALUES ('$name',$phone)");
    }
    //
}
