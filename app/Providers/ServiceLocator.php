<?php 
namespace Framework\Providers;
use Framework\Providers\Redirector;
class ServiceLocator{
  protected static $redirector;

  public static function setRedirector(Redirector $redirector)
  {
      self::$redirector = $redirector;
  }
  public static function getRedirector()
  {
      return self::$redirector;
  }
}