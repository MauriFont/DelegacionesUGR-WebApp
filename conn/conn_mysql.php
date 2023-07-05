<?php

class MySQL_PDO
{
    private $servername;
    private $username;
    private $password;
    public $conn;

  function __construct($db)
  {

    $this->servername = getenv("DB_ADDRESS");
    $this->username = getenv("DB_USER");
    $this->password = getenv("DB_PASS");

    try {
        $driver_options = array(
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $this->conn = new PDO("mysql:host=$this->servername;dbname=$db;charset=utf8", $this->username, $this->password, $driver_options);
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  function existe($tabla, $column, $dato)
  {
    $stmt = $this->conn->prepare("SELECT count(*) FROM $tabla WHERE $column=:$column");
    $stmt->bindParam(":$column", $dato);
    $stmt->execute();

    $rows = $stmt->fetchColumn();

    return $rows > 0;
  }

  function get($sql, $params = array())
  {
    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);

    return $stmt;
  }

  # El indice del array es el valor de la primer columna
  function getUnique($sql, $params = array())
  {
    return $this->get($sql, $params)->fetchAll(PDO::FETCH_UNIQUE);
  }

}
