<?php

namespace Framework\database;

use PDO;
use PDOException;

class Database
{
  /**
   * Summary of _instances
   * @var 
   */
  private static $_instances;
  private $pdo;
  private $error;
  private $stmt;
  public function __construct()
  {
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '../../../');
    $dotenv->load();
    try {
      $dsn = "mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_DATABASE'];
      // Set PDO options
      $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
      ];
      $this->pdo = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $options);
    } catch (PDOException $e) {
      $this->error = $e->getMessage();
      echo $this->error;
    }
  }

  // Prepare a SQL statement
  // Prepare and execute a SQL statement
  public function query($sql)
  {
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute();
    return $this->stmt;
  }

  // Bind values to the prepared statement
  public function bind($param, $value, $type = null)
  {
    if (is_null($type)) {
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }

    $this->stmt->bindValue($param, $value, $type);
  }

  // Execute the prepared statement
  public function execute()
  {
    return $this->stmt->execute();
  }

  // Execute a SELECT query and fetch all results
  public function fetchAll()
  {
    $this->execute();
    return $this->stmt->fetchAll();
  }

  // Execute a SELECT query and fetch a single result
  public function fetch()
  {
    $this->execute();
    return $this->stmt->fetch();
  }
  // Execute an INSERT query and return the number of affected rows
  public function insert($sql)
  {
    $this->query($sql);
    $this->execute();
    return $this->count();
  }
  // Get the row count of the last query
  public function count()
  {
    return $this->stmt->count();
  }
}
