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

	  $query = '
		SELECT  *,
		GROUP_CONCAT(DISTINCT  vmath.VED_NOM) AS mats,
		GROUP_CONCAT( DISTINCT vauth.VED_NOM) AS authors,
		GROUP_CONCAT( DISTINCT notice_exemplaire.EXP_COTE) AS examplaires
		FROM notice n
	    LEFT JOIN  editeur ON editeur.EDT_ID =n.EDT_ID
		LEFT JOIN type_document ON type_document.TYP_ID = n.TYP_ID
		LEFT JOIN langue ON langue.LAN_ID = n.LAN_ID
		LEFT JOIN statut_notice ON statut_notice.STA_ID = n.STA_ID
		LEFT JOIN periodicite ON periodicite.PER_ID = n.PER_ID
		LEFT JOIN notice_auteur ON n.DOC_ID = notice_auteur.DOC_ID
		LEFT JOIN vedette vauth ON notice_auteur.VED_ID = vauth.VED_ID
		LEFT JOIN notice_matiere ON n.DOC_ID = notice_matiere.DOC_ID
		LEFT JOIN vedette vmath ON notice_matiere.VED_ID = vmath.VED_ID
		LEFT JOIN notice_exemplaire ON n.DOC_ID = notice_exemplaire.DOC_ID
		GROUP BY n.DOC_ID
		LIMIT 3 ';
      
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
          $query = 'SELECT  *,GROUP_CONCAT(DISTINCT  vmath.VED_NOM) AS mats,GROUP_CONCAT( DISTINCT vauth.VED_NOM) AS authors
		FROM notice n
	    LEFT JOIN  editeur ON editeur.EDT_ID =n.EDT_ID
		LEFT JOIN type_document ON type_document.TYP_ID = n.TYP_ID
		LEFT JOIN langue ON langue.LAN_ID = n.LAN_ID
		LEFT JOIN statut_notice ON statut_notice.STA_ID = n.STA_ID
		LEFT JOIN periodicite ON periodicite.PER_ID = n.PER_ID
		LEFT JOIN notice_auteur ON n.DOC_ID = notice_auteur.DOC_ID
		LEFT JOIN vedette vauth ON notice_auteur.VED_ID = vauth.VED_ID
		LEFT JOIN notice_matiere ON n.DOC_ID = notice_matiere.DOC_ID
		LEFT JOIN vedette vmath ON notice_matiere.VED_ID = vmath.VED_ID
		WHERE   n.DOC_ID = ?    LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();
	     $row = $stmt->fetch( PDO::FETCH_ASSOC );
	    return $row;
    }

    
  }