<?php 
  class Book {
    // DB stuff
    private $conn;
    private $table = 'NOTICE';

    // Post Properties
    public $DOC_ID;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    //public $isbn;
    public $created_at;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query SQL SERVER
      //$query = 'SELECT TOP 10 *  FROM '. $this->table . ' ';
	  // Create query Mysql
	  $query = 'SELECT  *  FROM '. $this->table . '
	    JOIN  editeur ON editeur.EDT_ID =notice.EDT_ID
		 JOIN type_document ON type_document.TYP_ID = notice.TYP_ID
		 JOIN langue ON langue.LAN_ID = notice.LAN_ID
		 JOIN statut_notice ON statut_notice.STA_ID = notice.STA_ID
		 JOIN periodicite ON periodicite.PER_ID = notice.PER_ID
		LEFT JOIN notice_auteur ON notice.DOC_ID = notice_auteur.DOC_ID
		LEFT JOIN vedette vauth ON notice_auteur.VED_ID = vauth.VED_ID
		LEFT JOIN notice_matiere ON notice.DOC_ID = notice_matiere.DOC_ID
		LEFT JOIN vedette vmath ON notice_matiere.VED_ID = vmath.VED_ID
	   LIMIT 10 ';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      //  var_dump($stmt);
      // Execute query
      $stmt->execute();


      return $stmt;
    }

    // Get Single Post
    public function read_single() {
          // Create query
          $query = 'SELECT  *  FROM  NOTICE
                    JOIN  editeur ON editeur.EDT_ID =NOTICE.EDT_ID
					 JOIN type_document ON type_document.TYP_ID = NOTICE.TYP_ID
					 JOIN langue ON langue.LAN_ID = NOTICE.LAN_ID
					 JOIN statut_notice ON statut_notice.STA_ID = NOTICE.STA_ID
	                 WHERE    NOTICE.DOC_ID = ?    LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();
	    return $stmt;
    }

    
  }