<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/*
$router->get('/', function(){
    return "hello world";
});
*/

$router->post('/login', 'AuthController@authenticate');

$router->group(['prefix'=>'users'],function() use ($router){
    $router->get('/',['middleware'=>'jwt.auth','uses'=>'UsersController@getUsers']);
    $router->post('/', 'UsersController@addUser');
    $router->put('/updatename',['middleware'=>'jwt.auth', 'uses'=>'UsersController@updateUserName']);
    $router->put('/updatepassword',['middleware'=>'jwt.auth', 'uses'=>'UsersController@updateUserPassword']);
    $router->delete('/', 'UsersController@deleteUser');
});

$router->group(['prefix'=>'contacts','middleware'=>'jwt.auth'],function() use ($router){
    $router->get('/', 'ContactsController@getContacts');
    $router->get('/search/{search}', 'ContactsController@searchContacts');
    $router->get('/id/{id:[0-9]+}', 'ContactsController@getContactById');
    $router->delete('/id/{id:[0-9]+}', 'ContactsController@deleteContactById');
    $router->post('/', 'ContactsController@postContact');
    $router->put('/', 'ContactsController@updateContact');
});

$router->group(['prefix'=>'orders','middleware'=>'jwt.auth'],function() use ($router){
    $router->get('/', 'OrdersController@getOrders');
    $router->get('/searchbycontactname/{search}', 'OrdersController@searchOrdersByContactName');
    $router->get('/id/{id:[0-9]+}', 'OrdersController@getOrderById');
    /*$router->delete('/id/{id:[0-9]+}', 'OrdersController@deleteOrderById');
    $router->post('/', 'OrdersController@postOrder');
    $router->put('/', 'OrdersController@updateOrder');*/
});

