<?php

namespace Framework\Database;

use Framework\config\Dump;
use PDO;

class Database
{
  use Dump;
  protected $db;
  public  function __construct()
  {

    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '../../../');
    $dotenv->load();
    try {
      $dsn = "mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_DATABASE'];
      // Set PDO options
      $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES => false,
      ];

      $this->db = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $options);
    } catch (\PDOException $e) {
      throw new \Exception('Database: Something went wrong!' . $e->getMessage());
    }
  }
  public function prepare($sql)
  {
    return $this->db->prepare($sql);
  }
  public function query($sql, $params = [])
  {
    try {
      $stmt = $this->prepare($sql);
      $stmt->execute($params);
      return $stmt;
    } catch (\PDOException $e) {
      throw new \Exception('Query: Semething went wrong' . $e->getMessage());
    }
  }

  public function fetch($sql, $params = []): ?object
  {
    try {
      $stmt = $this->prepare($sql);
      $stmt->execute($params);
      if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        if (is_object($result)) {
          return $result;
        } else {
          return null;
        }
      } else {
        return null;
      }
    } catch (\PDOException $e) {
      throw new \Exception('Fetch: Something went wrong failed' . $e->getMessage());
    }
  }

  public function fetchAll($sql, $params = [])
  {
    try {
      $stmt = $this->query($sql, $params);
      if (!is_object($stmt)) {
        return null;
      }
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    } catch (\PDOException $e) {
      throw new \Exception('FetchAll: Something went wrong!' . $e->getMessage());
    }
  }
  public function getLastInsertId()
  {
    return $this->db->lastInsertId();
  }
  public function close()
  {
    if ($this->db !== null) {
      $this->db = null;
    }
  }
}
