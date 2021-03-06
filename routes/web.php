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

$router->group(['prefix'=>'test'], function() use ($router){
    $router->group(['middleware' => 'merchant'], function() use ($router){

        $router->post('merchant', 'LoginController@test');


    });
});


$router->group(['prefix'=>'api'], function() use ($router){

    $router->group(['middleware' => 'auth'], function() use ($router){
    
        $router->group(['middleware' => 'merchant'], function() use ($router){
                
            $router->group(['prefix'=>'merchant'], function() use ($router){
        
                $router->get('/', 'MerchantController@check');

                $router->group(['prefix'=>'product'], function() use ($router){
        
                    $router->post('create', 'ProductController@create');
        
                });

                $router->group(['prefix'=>'nego_transaction'], function() use ($router){
        
                    $router->post('start', 'TransactionController@start_negotiable_transaction');

                });

                $router->group(['prefix'=>'transaction'], function() use ($router){
        
                });

            });

        });

        // For user
        $router->group(['prefix'=>'user'], function() use ($router){
            
            $router->get('/', 'UserController@check');

            $router->group(['prefix'=>'nego_transaction'], function() use ($router){

                $router->post('accept', 'TransactionController@accept_transaction');
    
            });

        });

        
    });

    // Auth
    $router->post('login', 'LoginController@login');
    $router->post('register', 'LoginController@register');

});





