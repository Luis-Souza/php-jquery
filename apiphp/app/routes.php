<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy as Group;
use Slim\Handlers\Strategies\RequestResponseArgs;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

return function (App $app) {
    $app->get('/', [HomeController::class, 'index']);
    $app->group('', function(Group $group) {
        $group->get('/users', [UserController::class , 'listAll']);
        $group->post('/create', [UserController::class , 'store']);
        $group->get('/search/{name}', [UserController::class , 'find'])
        ->setInvocationStrategy(new RequestResponseArgs);
        $group->map(['DELETE','OPTIONS'],'/delete/{id}', [UserController::class , 'delete'])
        ->setInvocationStrategy(new RequestResponseArgs);
        $group->map(['PATCH','OPTIONS'],'/update', [UserController::class , 'update']);
    });
};