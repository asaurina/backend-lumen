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
  return 'Api is working';
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {
  $router->get('users', 'UserController@index');
  $router->get('users/{uuid}', 'UserController@show');
  $router->post('users', 'UserController@store');
  $router->put('users/{uuid}', 'UserController@update');
  $router->delete('users/{uuid}', 'UserController@destroy');
  $router->post('users/restore/{uuid}', 'UserController@restore');
});
