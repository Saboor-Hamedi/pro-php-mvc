<?php 

namespace Framework\Http\controllers\administration;
use Framework\models\Controller;

class AdministrationController extends Controller{
  public function index(){
    $this->view('administration/admin');
  }
}