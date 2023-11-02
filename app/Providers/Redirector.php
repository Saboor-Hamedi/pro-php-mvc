<?php

namespace Framework\Providers;

use Framework\Providers\RouteServiceProvider;
use Framework\routes\InvalidRouteException;

class Redirector
{
  protected $redirectService;
  public function __construct(RouteServiceProvider $redirectService)
  {
    $this->redirectService = $redirectService;
  }
  public function redirect(int $statusCode, string $url)
  {
    try {
      
      // Validate the status code
      if ($this->isValidStatusCode($statusCode)) {
        // Validate the URL
        if ($this->isValidUrl($url)) {
          $this->redirectService->setRedirect($statusCode, $url);
          $this->redirectService->redirect();
        } else {
          // Handle invalid URL error
          $this->handleError('Invalid URL');
        }
      } else {
        // Handle invalid status code error
        $this->handleError('Invalid Status Code');
      }
    } catch (InvalidRouteException $e) {
      // Handle the InvalidRouteException
      $this->handleError($e->getMessage());
    }
  }
  protected function isValidStatusCode(int $statusCode)
  {
    return ($statusCode >= 300 && $statusCode <= 399);
  }
  protected function isValidUrl(string $url)
  {
    // You can add more advanced URL validation here if needed
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
  }
  protected function handleError($message)
  {
    // Handle the error as needed, e.g., log it or display an error page
    echo "Error: $message";
    // You can also log the error here using a logger
  }
 
}
