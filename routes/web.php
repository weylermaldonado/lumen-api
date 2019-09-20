<?php

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

$router->get('/', function () use ($router) {
    return response()->json("El diablo anda suelto", 200);
});

// Product routes
$router->post('/products', "ProductController@store");
$router->get('/products', "ProductController@getProducts");
$router->get('/products/{id}', "ProductController@getProductById");
$router->put('/products/{id}', "ProductController@updateProductById");
$router->delete('/products/{id}', "ProductController@deleteProductById");