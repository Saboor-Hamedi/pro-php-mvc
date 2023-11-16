<?php

namespace Framework\Router\URL;

class Error
{
  public static function has($key)
  {
    return isset($_SESSION[$key]);
  }

  public static function get($key)
  {
    if (self::has($key)) {
      $value = $_SESSION[$key];
      unset($_SESSION[$key]); // Clear the flashed message after retrieving it
      return $value;
    }
    return null;
  }

  public static function setMessage($type)
  {
    // Map message types to CSS classes
    $typeClassMap = [
      'primary_message' => 'alert-primary',
      'success_message' => 'alert-success',
      'info_message' => 'alert-info',
      'warning_message' => 'alert-warning',
      'light_message' => 'alert-light',
      'dark_message' => 'alert-dark',
      'danger_message' => 'alert-danger',
    ];

    // Use the mapped CSS class for the message type, or the default if not found
    $cssClass = $typeClassMap[$type] ?? 'alert-info';

    if (self::has($type)) {
      $message = self::get($type);
      echo "<div class=\"alert $cssClass\">$message</div>";
    }
  }
}
