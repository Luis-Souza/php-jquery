<?php

namespace App\Responses;

use Psr\Http\Message\ResponseInterface as Response;

class CustomResponses {

  public static function withMessage(Response $response, $message, $statusCode = 200): Response
  {
    $responseMessage = json_encode([
      'message' => $message
    ]);
    $response->getBody()->write($responseMessage);
    return $response->withHeader('Content-Type', 'Application/json')
      ->withStatus($statusCode);
  }

  public static function withDataEndMessage(Response $response, $message, $data, $statusCode = 200): Response
  {
    $responseMessage = json_encode([
      'message' => $message,
      'data'    => $data
    ]);
    $response->getBody()->write($responseMessage);
    return $response->withHeader('Content-Type', 'Application/json')
      ->withStatus($statusCode);
  }
}