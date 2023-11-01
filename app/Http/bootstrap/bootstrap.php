<?php 
require_once __DIR__ . '/../../../vendor/autoload.php';
use Framework\models\Web;
$routers = new Web();
$routers->routes();