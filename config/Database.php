<?php 
  class Database {
    // DB Params
    private $host = '127.0.0.1';
    private $db_name = 'syngeb';
    private $username = 'root';
    private $password = '';
    private $conn;

    // DB Connect
    public function connect() {
      $this->conn = null;

      try {
	      // SQL SERVER  connection string
	      //$this->conn = new PDO('sqlsrv:server=' . $this->host . ';Database=' . $this->db_name, $this->username, $this->password);
	      // Mysql connection string
	      $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password,
		      array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	      // SET ATTR ERRORMOD
	      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }

      return $this->conn;
    }
  }