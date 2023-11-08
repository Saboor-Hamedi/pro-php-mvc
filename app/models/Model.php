<?php

namespace Framework\models;

use Exception;
use Framework\config\Dump;
use Framework\Database\Database;
use Framework\Router\Exceptions\FindException;
use PDO;
use PDOException;

class Model extends Database
{
  use Dump;
  protected $table;
  public function __construct()
  {
    parent::__construct();
  }
  public function find($params)
  {
    try {

      $sql = "SELECT * FROM `{$this->table}` WHERE ";
      $validColumns = array_keys(get_object_vars($this));
      foreach ($params as $field  => $value) {
        // if (in_array($field, $validColumns)) {
        //   throw new Exception("Invalid column name: {$field}");
        // }
        $sql .= " {$field}= :{$field} AND";
      }
      $sql = rtrim($sql, "AND");
      $stmt = $this->prepare($sql);
      foreach ($params as $field => $value) {
        $stmt->bindValue(":{$field}", $value, PDO::PARAM_STR);
      }
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
        return $stmt->fetch(PDO::FETCH_OBJ);
      } else {
        throw new Exception("No record found");
      }
    } catch (PDOException $e) {
      throw new Exception("Find: Something went wrong! " . $e->getMessage());
    }
  }
  public function where($params)
  {
    try {

      // Create a variable to store the SQL query
      $sql = "SELECT * FROM `{$this->table}` WHERE ";
      // Iterate over the params array and add each condition to the SQL query
      foreach ($params as $field => $value) {
        $sql .= " `{$field}` = :{$field} AND";
      }

      // Remove the trailing AND from the SQL query
      $sql = rtrim($sql, "AND");

      // Prepare the SQL statement
      $stmt = $this->prepare($sql);

      // Bind the values to the prepared statement
      foreach ($params as $field => $value) {
        $stmt->bindValue(":{$field}", $value, PDO::PARAM_STR);
      }
      // Execute the prepared statement
      $stmt->execute();

      // If there are any results, return them
      if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll(PDO::FETCH_OBJ);
      } else {
        // If there are no results, return an empty array
        return [];
      }
    } catch (PDOException $e) {
      throw new Exception("Where: Something went wrong! " . $e->getMessage());
    }
  }

  public function update($params, $where)
  {
    try {
      $whereField = key($where);
      $whereValue = $where[$whereField];

      unset($params[$whereField]);

      $sql = "UPDATE `{$this->table}` SET ";
      foreach ($params as $field => $value) {
        $sql .= " {$field}= :{$field},";
      }

      $sql = rtrim($sql, ", ");
      $sql .= " WHERE {$whereField}=:whereValue";  // Add the WHERE clause

      $stmt = $this->prepare($sql);

      foreach ($params as $field => $value) {
        $stmt->bindValue(":{$field}", $value, PDO::PARAM_STR);
      }

      $stmt->bindValue(":whereValue", $whereValue, PDO::PARAM_INT);  // Bind the 'whereValue' parameter

      $stmt->execute();
      return $stmt->rowCount();
    } catch (PDOException $e) {
      throw new Exception("Update: Something went wrong!" . $e->getMessage());
    }
  }
  public function all($order = null, $group = null, $limit = null)
  {
    try {
      $sql = "SELECT * FROM `{$this->table}`";

      if ($group) {
        $sql .= " GROUP BY {$group}";
      }

      if ($order) {
        $sql .= " ORDER BY {$order}";
      }

      if ($limit) {
        $sql .= " LIMIT {$limit}";
      }

      $stmt = $this->prepare($sql);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
      throw new Exception("All: Something went wrong!" . $e->getMessage());
    }
  }
  public function create($data)
  {
    try {
      $fields = implode(',', array_keys($data));
      $placeholders = ':' . implode(', :', array_keys($data));

      $sql = "INSERT INTO `{$this->table}` ({$fields}) VALUES ({$placeholders})";

      $stmt = $this->prepare($sql);

      foreach ($data as $field => $value) {
        $stmt->bindValue(":{$field}", $value, PDO::PARAM_STR);
      }

      $stmt->execute();
      return $this->getLastInsertId();
    } catch (PDOException $e) {
      throw new Exception("Insert: Something went wrong!" . $e->getMessage());
    }
  }
  public function delete($where)
  {
    try {
      $whereField = key($where);
      $whereValue = $where[$whereField];

      $sql = "DELETE FROM `{$this->table}` WHERE {$whereField} = :whereValue";

      $stmt = $this->prepare($sql);
      $stmt->bindValue(":whereValue", $whereValue, PDO::PARAM_STR);

      $stmt->execute();
      return $stmt->rowCount();
    } catch (PDOException $e) {
      throw new Exception("Delete: Something went wrong!" . $e->getMessage());
    }
  }
}
