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

$router->get('/', 'ExampleController@sayHello');

$router->group(['prefix'=>'contacts'],function() use ($router){
    $router->get('/', 'ContactsController@getContacts');
    $router->get('/search/{search}', 'ContactsController@searchContacts');
    $router->get('/id/{id:[0-9]+}', 'ContactsController@getContactById');
    $router->delete('/id/{id:[0-9]+}', 'ContactsController@deleteContactById');
    $router->post('/', 'ContactsController@postContact');
    $router->put('/', 'ContactsController@updateContact');
});

$router->group(['prefix'=>'orders'],function() use ($router){
    $router->get('/', 'OrdersController@getOrders');
    $router->get('/searchbycontactname/{search}', 'OrdersController@searchOrdersByContactName');
    $router->get('/id/{id:[0-9]+}', 'OrdersController@getOrderById');
    /*$router->delete('/id/{id:[0-9]+}', 'OrdersController@deleteOrderById');
    $router->post('/', 'OrdersController@postOrder');
    $router->put('/', 'OrdersController@updateOrder');*/
});

$router->post('/{id}', 'ExampleController@postSomething');

$router->get('/say/{something}', 'ExampleController@saySomething');
