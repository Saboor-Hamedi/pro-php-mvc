<?php 
namespace Framework\Http\controllers;
use Framework\models\Controller;

class DashboardController extends Controller{
  public function index(){
    $this->view('admin/dashboard');
  }
}