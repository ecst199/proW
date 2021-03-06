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
    return $router->app->version();
});
$router->group(['middleware' => []], function () use ($router) {
    $router->post('/login', ['uses' => 'AuthController@login']);
    $router->post('/register', ['uses' => 'AuthController@register']);
    $router->post('/password_recovery_request', ['uses' => 'AuthController@passwordRecoveryRequest']);
    $router->get('/password_recovery', ['uses' => 'AuthController@passwordRecovery']);
    $router->post('/registro', ['uses' => 'AuthController@registro']);
 });
