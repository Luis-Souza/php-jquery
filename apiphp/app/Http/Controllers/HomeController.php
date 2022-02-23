<?php
namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController 
{
  public function index(Request $request, Response $response): Response
  {
      $response->getBody()->write('Api with slim framework');

      return $response;
  }
}