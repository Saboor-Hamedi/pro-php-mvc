<?php 
namespace Framework\Http\controllers;
use Framework\models\Controller;

class AdminController extends Controller{
  public function index(){
    $this->view('admin/admin'); // Update the view path
  }
}