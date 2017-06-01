<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Controllers;
use \DavidePastore\Slim\Validation\Validation as Validacion;

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write('Quién te conoce papá?');
    return $response;
});

/* Users */

$app->get('/users', '\App\Controllers\UserController:all');

$app->get('/users/{id:[1-9]+[0-9]*}', '\App\Controllers\UserController:show');

$app->post('/users', '\App\Controllers\UserController:create')
	->add(new Validacion($USER_CREATE, $translator));

$app->put('/users/{id:[1-9]+[0-9]*}', '\App\Controllers\UserController:update')
	->add(new Validacion($USER_EDIT, $translator));

$app->delete('/users/{id:[1-9]+[0-9]*}', '\App\Controllers\UserController:delete');

/* Customers */

$app->get('/customers', '\App\Controllers\CustomerController:all');

$app->get('/customers/{id:[1-9]+[0-9]*}', '\App\Controllers\CustomerController:show');

$app->post('/customers', '\App\Controllers\CustomerController:create')
	->add(new Validacion($CUSTOMER_CREATE, $translator));

$app->put('/customers/{id:[1-9]+[0-9]*}', '\App\Controllers\CustomerController:update')
	->add(new Validacion($CUSTOMER_EDIT, $translator));

$app->delete('/customers/{id:[1-9]+[0-9]*}', '\App\Controllers\CustomerController:delete');

/* Authentication */

$app->post('/auth/attempt', '\App\Controllers\Auth\AuthController:attempt')
	->add(new Validacion($LOGIN_VALIDATORS, $translator));

$app->post('/login', '\App\Controllers\Auth\AuthController:login')
	->add(new Validacion($LOGIN_VALIDATORS, $translator));

/* Locales */
$app->post('/locals', '\App\Controllers\LocalController:create');
$app->get('/locals', '\App\Controllers\LocalController:all');
$app->put('/locals/{id:[1-9]+[0-9]*}', '\App\Controllers\LocalController:update');
$app->delete('/locals/{id:[1-9]+[0-9]*}', '\App\Controllers\LocalController:delete');

/* Roles */
$app->post('/roles', '\App\Controllers\RoleController:create');
$app->get('/roles', '\App\Controllers\RoleController:all');
$app->put('/roles/{id:[1-9]+[0-9]*}', '\App\Controllers\RoleController:update');
$app->delete('/roles/{id:[1-9]+[0-9]*}', '\App\Controllers\RoleController:delete');

/* Providers */
$app->post('/providers', '\App\Controllers\ProviderController:create');
$app->get('/providers', '\App\Controllers\ProviderController:all');
$app->put('/providers/{id:[1-9]+[0-9]*}', '\App\Controllers\ProviderController:update');
$app->delete('/providers/{id:[1-9]+[0-9]*}', '\App\Controllers\ProviderController:delete');

/* Invoices */
$app->post('/invoices', '\App\Controllers\InvoiceController:create');
$app->get('/invoices', '\App\Controllers\InvoiceController:all');
$app->get('/invoices/{id:[1-9]+[0-9]*}', '\App\Controllers\InvoiceController:show');
$app->put('/invoices/{id:[1-9]+[0-9]*}', '\App\Controllers\InvoiceController:update');
$app->delete('/invoices/{id:[1-9]+[0-9]*}', '\App\Controllers\InvoiceController:delete');

/* Items */
$app->post('/items', '\App\Controllers\ItemController:create');
$app->get('/items', '\App\Controllers\ItemController:all');
$app->put('/items/{id:[1-9]+[0-9]*}', '\App\Controllers\ItemController:update');
$app->delete('/items/{id:[1-9]+[0-9]*}', '\App\Controllers\ItemController:delete');