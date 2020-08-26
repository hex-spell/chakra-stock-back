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

$router->post('/login', 'AuthController@authenticate');

$router->group(['prefix' => 'users'], function () use ($router) {
    $router->get('/', ['middleware' => 'jwt.auth', 'uses' => 'UsersController@getUsers']);
    $router->get('/{id}', ['middleware' => 'jwt.auth', 'uses' => 'UsersController@getUserByID']);
    $router->post('/', 'UsersController@addUser');
    $router->put('/updatename', ['middleware' => 'jwt.auth', 'uses' => 'UsersController@updateUserName']);
    $router->put('/updatepassword', ['middleware' => 'jwt.auth', 'uses' => 'UsersController@updateUserPassword']);
    $router->delete('/', 'UsersController@deleteUser');
});

$router->group(['prefix' => 'contacts', 'middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('/', 'ContactsController@getContacts');
    $router->get('/search/{search}', 'ContactsController@searchContacts');
    $router->get('/id/{id:[0-9]+}', 'ContactsController@getContactById');
    $router->delete('/id/{id:[0-9]+}', 'ContactsController@deleteContactById');
    $router->post('/', 'ContactsController@postContact');
    $router->put('/', 'ContactsController@updateContact');
});

$router->group(['prefix' => 'expenses', 'middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('/', 'ExpensesController@getExpenses');
    $router->get('/categories', 'ExpensesController@getExpenseCategories');
    $router->get('/search/{search}', 'ExpensesController@searchExpenses');
    $router->get('/id/{id:[0-9]+}', 'ExpensesController@getExpenseById');
    $router->delete('/', 'ExpensesController@deleteExpenseById');
    $router->post('/', 'ExpensesController@postExpense');
    $router->put('/', 'ExpensesController@updateExpense');
    $router->post('/categories', 'ExpensesController@postExpenseCategory');
    $router->put('/categories', 'ExpensesController@updateExpenseCategory');
    $router->delete('/categories', 'ExpensesController@deleteExpenseCategoryById');
});

$router->group(['prefix' => 'products', 'middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('/', 'ProductsController@getProducts');
    $router->get('/categories', 'ProductsController@getProductCategories');
    $router->get('/search/{search}', 'ProductsController@searchProducts');
    $router->get('/id/{id:[0-9]+}', 'ProductsController@getProductById');
    $router->delete('/', 'ProductsController@deleteProductById');
    $router->post('/', 'ProductsController@postProduct');
    $router->put('/', 'ProductsController@updateProduct');
    $router->put('/stock', 'ProductsController@updateProductStock');
    $router->post('/categories', 'ProductsController@postProductCategory');
    $router->put('/categories', 'ProductsController@updateProductCategory');
    $router->delete('/categories', 'ProductsController@deleteProductCategoryById');
});


$router->group(['prefix' => 'orders', 'middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('/', 'OrdersController@getOrders');
    $router->delete('/', 'OrdersController@deleteOrderById');
    $router->get('/id', 'OrdersController@getOrderById');
    $router->post('/', 'OrdersController@postOrder');
    $router->put('/', 'OrdersController@updateOrder');
    $router->post('/products', 'OrdersController@addOrderProduct');
    $router->put('/products', 'OrdersController@modifyOrderProduct');
    $router->post('/products/delivered', 'OrdersController@markDelivered');
    $router->get('/transactions', 'OrdersController@getTransactions');
    $router->post('/transactions', 'OrdersController@addTransaction');
    $router->put('/transactions', 'OrdersController@modifyTransaction');
    $router->delete('/transactions', 'OrdersController@deleteTransaction');
    $router->post('/completed', 'OrdersController@markCompleted');
});
