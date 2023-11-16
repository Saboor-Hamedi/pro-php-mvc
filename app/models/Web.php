<?php

namespace Framework\models;

use Framework\config\Dump;
use Framework\Http\controllers\dashboard\DashboardController;
use Framework\Http\controllers\HomeController;
use Framework\Router\Router;

class Web
{
  use Dump;
  private $route;
  public function routes()
  {
    $this->route = new Router();
    $this->route->get('/home', [HomeController::class, 'index']);
    $this->route->get('/home/update/{id}', [HomeController::class, 'update']);
    $this->route->get('/home/create/{id}', [HomeController::class, 'create']);
    $this->route->get('/home/delete/{id}', [HomeController::class, 'delete']);

    // group
    $this->route->group('/dashboard', function ($route) {
      $this->route->get('/admin', [DashboardController::class, 'index']);
    });
    $this->route->route();
  }
}
