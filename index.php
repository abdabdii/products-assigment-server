<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Config\Router;
use App\Controllers\ProductsController;

$router = new Router();
$productsCont = new ProductsController();


$router->get('/listing/products', function () {ProductsController::read();});
$router->post('/listing/products', function () {ProductsController::create();});
$router->delete('/listing/products', function () {ProductsController::delete();});

$router->setNotFoundHandler(function () {ProductsController::notFound();});


if (isset($_SERVER['HTTP_ORIGIN'])) {

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 1000');
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
    }

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");
    }
    exit(0);
}

$router->run();