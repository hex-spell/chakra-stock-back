<?php

namespace App\Http\Controllers;

use App\Interfaces\ContactsRepositoryInterface;
use Illuminate\Http\Request;

class ContactsController extends Controller
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

    public function getContacts(){
        return $this->repo->getContacts();
    }

    public function searchContacts(string $search){
        return $this->repo->searchContacts($search);
    }

    public function getContactById(string $id){
        if (is_numeric($id)){
            return $this->repo->getContactById($id);
        }
        else return response()->json(['error'=>'id is not numeric']);
    }

    public function postContact(Request $request){
        $name = $request->json()->get('name');
        $phone = $request->json()->get('phone');
        return $this->repo->postContact($name,$phone);
    }
}
