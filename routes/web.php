<?php

use App\Http\Controllers\RedisMessageController;

/** @var \Laravel\Lumen\Routing\Router $router */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->put('/message', RedisMessageController::class);
