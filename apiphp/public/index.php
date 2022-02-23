<?php

use DI\Bridge\Slim\Bridge as SlimAppFactory;

require '../vendor/autoload.php';

$container = require_once '../app/container.php';

$app = SlimAppFactory::create($container);

$middleware = require_once '../app/middleware.php';
$middleware($app);

$routes = require_once '../app/routes.php';
$routes($app);

$app->run();