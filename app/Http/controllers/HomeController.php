<?php

namespace Framework\Http\controllers;

use Framework\config\Dump;
use Framework\Models\Controller;
use Framework\Models\PostModel;
use Framework\Router\URL\Redirect;

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
      'title' => 'Table',
      'content' => 'Table Updated'
    ];
    $where = ['id' => $id];
    $this->PostModel->update($data, $where);
    Redirect::with('/home', 'primary', 'Update successfully');
    // Redirect::back();
  }
  public function create($id)
  {
    $data = [
      'user_id' => $id,
      'title' => 'Table',
      'content' => 'Hello update',
    ];
    $this->PostModel->create($data);
  }
  public function delete($id)
  {
    $where = ['id' => $id];
    $this->PostModel->delete($where);
    Redirect::to('/home', 302);
  }
}
