<?php 
  class Database {
    // DB Params
    private $host = '192.168.0.5';
    private $db_name = 'syngeb03';
    private $username = 'sa';
    private $password = 'bplpa';
    private $conn;

    // DB Connect
    public function connect() {
      $this->conn = null;

      try { 
        $this->conn = new PDO('sqlsrv:server=' . $this->host . ';Database=' . $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }

      return $this->conn;
    }
  }