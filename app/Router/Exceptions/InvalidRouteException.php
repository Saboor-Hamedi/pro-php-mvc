<?php

namespace Framework\Router\Exceptions;
use Framework\Router\Exceptions\RouterException;
class InvalidRouteException extends RouterException
{
  public function __construct($message = 'Invalid route', $code = 0, $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }
}
