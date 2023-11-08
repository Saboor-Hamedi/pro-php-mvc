<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Framework\models\Web;
use Framework\Providers\Redirector;
use Framework\Providers\RouteServiceProvider;
use Framework\Providers\ServiceLocator;

error_reporting(E_ALL);
ini_set('display_errors', 1);
$router = RouteServiceProvider::getInstance();
$routeServiceProvider  = new Redirector($router);
// Set up the service locator with the Redirector instance
ServiceLocator::setRedirector($routeServiceProvider);
// redict
function redirect(int $statusCode, string $url): void
{
  ServiceLocator::getRedirector()->redirect($statusCode, $url);
}

$routers = new Web();
$routers->routes();
