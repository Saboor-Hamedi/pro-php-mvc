<?php 

namespace Framework\Http\controllers\dashboard;

use Framework\models\Controller;
class DashboardController extends Controller{
  public function index(){
    $this->view('dashboard/admin');
  }
}
// $this->view('administration/admin');
