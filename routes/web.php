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
$api = app('Dingo\Api\Routing\Router');

$api->version('v0.1', function ($api) {

$api->post('/login', 'App\Http\Controllers\AuthController@authenticate');

$api->group(['prefix' => 'users'], function($api) {
    $api->get('/', ['middleware' => 'jwt.auth', 'uses' => 'App\Http\Controllers\UsersController@getUsers']);
    $api->get('/{id}', ['middleware' => 'jwt.auth', 'uses' => 'App\Http\Controllers\UsersController@getUserByID']);
    $api->post('/', 'App\Http\Controllers\UsersController@addUser');
    $api->put('/updatename', ['middleware' => 'jwt.auth', 'uses' => 'App\Http\Controllers\UsersController@updateUserName']);
    $api->put('/updatepassword', ['middleware' => 'jwt.auth', 'uses' => 'App\Http\Controllers\UsersController@updateUserPassword']);
    $api->delete('/{id}', 'App\Http\Controllers\UsersController@deleteUser');
});

$api->group(['prefix' => 'contacts', 'middleware' => 'jwt.auth'], function($api) {
    $api->get('/', 'App\Http\Controllers\ContactsController@getContacts');
    $api->get('/menu', 'App\Http\Controllers\ContactsController@getContactsMinified');
    $api->get('/id/{id:[0-9]+}', 'App\Http\Controllers\ContactsController@getContactById');
    $api->delete('/', 'App\Http\Controllers\ContactsController@deleteContactById');
    $api->post('/', 'App\Http\Controllers\ContactsController@postContact');
    $api->put('/', 'App\Http\Controllers\ContactsController@updateContact');
});

$api->group(['prefix' => 'expenses', 'middleware' => 'jwt.auth'], function($api) {
    $api->get('/', 'App\Http\Controllers\ExpensesController@getExpenses');
    $api->get('/categories', 'App\Http\Controllers\ExpensesController@getExpenseCategories');
    $api->delete('/', 'App\Http\Controllers\ExpensesController@deleteExpenseById');
    $api->post('/', 'App\Http\Controllers\ExpensesController@postExpense');
    $api->put('/', 'App\Http\Controllers\ExpensesController@updateExpense');
    $api->post('/categories', 'App\Http\Controllers\ExpensesController@postExpenseCategory');
    $api->put('/categories', 'App\Http\Controllers\ExpensesController@updateExpenseCategory');
    $api->delete('/categories', 'App\Http\Controllers\ExpensesController@deleteExpenseCategoryById');
});

$api->group(['prefix' => 'products'/* , 'middleware' => 'jwt.auth' */], function($api) {
    $api->get('/', 'App\Http\Controllers\ProductsController@getProducts');
    $api->get('/categories', 'App\Http\Controllers\ProductsController@getProductCategories');
    $api->get('/list', 'App\Http\Controllers\ProductsController@getProductsList');
    $api->get('/pdf', 'App\Http\Controllers\ProductsController@getProductsPDF');
    $api->get('/id/{id:[0-9]+}', 'App\Http\Controllers\ProductsController@getProductById');
    $api->delete('/', 'App\Http\Controllers\ProductsController@deleteProductById');
    $api->post('/', 'App\Http\Controllers\ProductsController@postProduct');
    $api->put('/', 'App\Http\Controllers\ProductsController@updateProduct');
    $api->put('/stock', 'App\Http\Controllers\ProductsController@updateProductStock');
    $api->post('/categories', 'App\Http\Controllers\ProductsController@postProductCategory');
    $api->put('/categories', 'App\Http\Controllers\ProductsController@updateProductCategory');
    $api->delete('/categories', 'App\Http\Controllers\ProductsController@deleteProductCategoryById');
});


$api->group(['prefix' => 'orders', 'middleware' => 'jwt.auth'], function($api) {
    $api->get('/', 'App\Http\Controllers\OrdersController@getOrders');
    $api->delete('/', 'App\Http\Controllers\OrdersController@deleteOrderById');
    $api->get('/id', 'App\Http\Controllers\OrdersController@getOrderById');
    $api->get('/id/products', 'App\Http\Controllers\OrdersController@getOrderProductsByOrderId');
    $api->post('/', 'App\Http\Controllers\OrdersController@postOrder');
    $api->put('/', 'App\Http\Controllers\OrdersController@updateOrder');
    $api->post('/products', 'App\Http\Controllers\OrdersController@addOrderProduct');
    $api->put('/products', 'App\Http\Controllers\OrdersController@modifyOrderProduct');
    $api->delete('/products', 'App\Http\Controllers\OrdersController@removeOrderProduct');
    $api->post('/products/delivered', 'App\Http\Controllers\OrdersController@markDeliveredMultiple');
    $api->get('/transactions', 'App\Http\Controllers\OrdersController@getTransactions');
    $api->post('/transactions', 'App\Http\Controllers\OrdersController@addTransaction');
    $api->put('/transactions', 'App\Http\Controllers\OrdersController@modifyTransaction');
    $api->delete('/transactions', 'App\Http\Controllers\OrdersController@deleteTransaction');
    $api->post('/completed', 'App\Http\Controllers\OrdersController@markCompleted');
});

$api->group(['prefix' => 'transactions', 'middleware' => 'jwt.auth'], function($api) {
    $api->get('/', 'App\Http\Controllers\TransactionsController@getTransactions');
    $api->get('/menu', 'App\Http\Controllers\TransactionsController@getTransactionsMinified');
    $api->delete('/id/{id:[0-9]+}', 'App\Http\Controllers\TransactionsController@deleteTransactionById');
    $api->post('/', 'App\Http\Controllers\TransactionsController@postTransaction');
    $api->put('/', 'App\Http\Controllers\TransactionsController@updateTransaction');
});

$api->group(['prefix'=>'stats'], function($api){
    $api->get('/','App\Http\Controllers\StatsController@hello');
});

$api->options('/{route:.*}/', function () { return response(['status' => 'success']); });

});