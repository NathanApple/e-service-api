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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix'=>'api'], function() use ($router){

    $router->group(['middleware' => 'auth'], function() use ($router){
    
        // TODO middleware for merchant role
        $router->group(['prefix'=>'merchant'], function() use ($router){
    
            $router->group(['prefix'=>'product'], function() use ($router){
    
                $router->post('create', 'ProductController@create');
    
            });

            $router->group(['prefix'=>'transaction'], function() use ($router){
    
                $router->post('start', 'TransactionController@start_transaction');

            });


        });

        // For user
        $router->group(['prefix'=>'user'], function() use ($router){
            
            $router->group(['prefix'=>'transaction'], function() use ($router){

                $router->post('start', 'TransactionController@accept_transaction');
    
            });

        });

        $router->post('login', 'LoginController@login');

    });
});





