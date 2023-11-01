<?php

namespace Framework\config;

/**
 * Summary of Setting
 */
class Setting
{
  /**
   * Summary of config
   * @var 
   */
  protected $config;

  /**
   * Summary of __construct
   */
  public function __construct()
  {
    $this->config = [];
    $this->load();
  }

  /**
   * Summary of load
   * @return void
   */
  protected function load()
  {
    $envFilePath = __DIR__ . '/../../';

    // Load values from .env file
    $envFile = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envFile as $line) {
      list($key, $value) = explode('=', $line, 2);
      $this->config[$key] = $value;
    }
  }

  /**
   * Summary of env
   * @param mixed $key
   * @param mixed $default
   * @return void
   */
  public function env($key, $default = null)
  {
    $result =  $this->config[$key] ?? $default;
    echo $result;
  }
  public function details($key, $default = null)
  {
    return $this->config[$key] ?? $default;
    
  }
}
