<?php
  class Reader {
    // DB Stuff
    private $conn;
    private $table = 'LECTEUR';

    // Properties
    public $id;
    public $name;
    public $created_at;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Single Reader
  public function read_single(){
    // Create query
    $query = 'SELECT TOP 1 *
        FROM
          ' . $this->table . '
      WHERE LEC_ID = ?';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->id = $row['LEC_ID'];
      $this->name = $row['LEC_NOM'];
  }


  }
