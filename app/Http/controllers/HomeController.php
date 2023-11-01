<?php
namespace Framework\Http\controllers;

use Framework\models\Controller;

class HomeController extends Controller
{
  public function index()
  {
    $this->view('home');
  }
  public function show($id)
  {
    echo $id;
    $this->view('show');
  }
  public function edit($id){
    $this->view('edit');
  }
}
