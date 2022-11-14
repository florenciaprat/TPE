<?php
require_once './libs/Router.php';
require_once './app/controllers/product-api.controller.php';
require_once './app/controllers/auth-api.controller.php';

// crea el router
$router = new Router();

// defina la tabla de ruteo
$router->addRoute('products', 'GET', 'productApiController', 'getProducts');
$router->addRoute('products/:ID', 'GET', 'productApiController', 'getProduct');
$router->addRoute('products/:ID', 'DELETE', 'productApiController', 'deleteProduct');
$router->addRoute('products', 'POST', 'productApiController', 'insertProduct'); 
$router->addRoute('products/:ID', 'PUT', 'productApiController', 'updateProduct'); 

$router->addRoute("users/token", 'GET', 'AuthApiController', 'getToken');
// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);

