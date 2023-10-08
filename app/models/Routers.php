<?php

namespace Framework\models;

use Framework\config\Dump;
use Framework\Http\controllers\AdminController;
use Framework\Http\controllers\DashboardController;
use Framework\Http\controllers\HomeController;
use Framework\Http\controllers\administration\AdministrationController;
use Framework\routes\Router;

class Routers
{
  use Dump;
  private $route;
  public function routes()
  {

    $this->route = new Router();
    $this->route->get('/home', [HomeController::class, 'index']);
    $this->route->group('/admin', function ($route) {
      $this->route->get('/admin', [AdminController::class, 'index']); // Updated namespace
      $this->route->get('/dashboard', [DashboardController::class, 'index']); // Updated namespace
    });
    $this->route->group('/administration', function ($rout) {
      $this->route->get('/admin', [AdministrationController::class, 'index']);
    });

    // $this->route->get('/home/show/{id}', [HomeController::class, 'show']);
    $this->route->route();
  }
}
