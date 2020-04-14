<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
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

    public function sayHello(){
        return "hello";
    }

    public function saySomething(string $something){
        return $something;
    }

    public function postSomething(Request $request,string $id){
        $word = $request->json()->get('something');
        return response()->json(['message'=>"you posted $word in $id"]);
    }
    //
}
