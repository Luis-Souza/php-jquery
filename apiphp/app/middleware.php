<?php

use Slim\App;
use App\Middlewares\JsonBodyParserMiddleware;
use Slim\Middleware\MethodOverrideMiddleware;

return function (App $app) {
    $setting = $app->getContainer()->get('settings');

    $app->add(JsonBodyParserMiddleware::class);

    (require_once __DIR__ . '/cors.php')($app);
    // $app->addBodyParsingMiddleware();
    
    $app->addErrorMiddleware(
        $setting['displayErrorDetails'],
        $setting['logErrors'],
        $setting['logErrorDetails']
    );
    
    $app->addRoutingMiddleware();

    $app->add(new MethodOverrideMiddleware());
    
};