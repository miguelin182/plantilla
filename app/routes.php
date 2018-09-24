<?php
/* Controllers */
$router->group(['middleware' => 'auth'], function($router){

$router->controller('/credit','App\\Controllers\\CreditController');


});

$router->controller('/auth', 'App\\Controllers\\AuthController');
$router->controller('/home', 'App\\Controllers\\HomeController');

$router->get('/', function(){
    if(!\Core\Auth::isLoggedIn()){
        \App\Helpers\UrlHelper::redirect('home');
    } else {
        \App\Helpers\UrlHelper::redirect('credit');
    }
});

$router->get('/welcome', function(){
    return 'Welcome page';
}, ['before' => 'auth']);

$router->get('/test', function(){
    return 'Welcome page';
}, ['before' => 'auth']);