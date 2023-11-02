<?php 
namespace Framework\Providers;
class RouteServiceProvider{
  protected $statusCode; 
  protected $url;
  protected static $instances;
  public function __construct(){}

  public static function getInstance(){
    if(self::$instances == null){
      self::$instances = new RouteServiceProvider();
    }
    return self::$instances;
  }
  public function setRedirect(int $statusCode, string $url){
    $this->statusCode = $statusCode;
    $this->url = $url;
  }
  public function redirect(){
    // set http status code
    http_response_code($this->statusCode);
    // set header location
    header('Location:'. $this->url);

    exit;
  }
  public function boot(){
  }
}