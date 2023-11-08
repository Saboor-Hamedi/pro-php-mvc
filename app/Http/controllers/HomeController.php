<?php

namespace Framework\Http\controllers;

use Framework\config\Dump;
use Framework\Models\Controller;
use Framework\Models\PostModel;

class HomeController extends Controller
{
  use Dump;
  protected $PostModel;
  public function __construct()
  {
    $this->PostModel = new PostModel();
  }
  public function index()
  {
    $data = ['user_id' => 1];
    $posts = $this->PostModel->where($data);
    $this->view('home', ['posts'  => $posts]);
  }
  public function update($id)
  {
    $data = [
      'id' => $id,
      'title' => 'Hello World, which I dont understand',
      'content' => 'Okay, you force to updated'
    ];
    $where = ['id' => $id];
    
    $this->PostModel->update($data, $where);
    $this->dd($data);
    $this->view('/home');
  }
  public function create($id){
    $data = [
      'user_id'=> $id,
      'title'=> 'I am new data',
      'content'=> 'New Data',
    ];
    $this->PostModel->create($data);
  }
  public function delete($id){
    $where = ['id'=> $id];
    $this->PostModel->delete($where);
  }
}
