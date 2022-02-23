<?php

use DI\Container;
use Psr\Container\ContainerInterface;
use App\Http\Controllers\UserController;
use App\Http\Repositories\Persistences\MongoUserRepository;
use App\Validation\Validator;

$container = new Container();

$container->set('settings', function(){
  return [
    'displayErrorDetails' => true,
    'logErrorDetails' => true,
    'logErrors' => true,
  ];
});

$container->set('MongoUserRepository', function(ContainerInterface $c){
  $db = $c->get('DBConnection');
  return new MongoUserRepository($db);
});

$container->set('UserController', function(ContainerInterface $c){
  $mongo = $c->get('MongoUserRepository');
  $validate = $c->get('Validator');
  return new UserController($mongo, $validate);
});

return $container;