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
	      // SQL SERVER  connection string
	      $this->conn = new PDO('sqlsrv:server=' . $this->host . ';Database=' . $this->db_name, $this->username, $this->password);
	      // Mysql connection string
	     // $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
	      // SET ATTR ERRORMOD
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }

      return $this->conn;
    }
  }