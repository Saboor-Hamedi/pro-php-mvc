<?php

namespace Framework\routes;

class InvalidRouteException extends RouterException
{
  public function __construct($message = 'Invalid route', $code = 0, $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }
}
