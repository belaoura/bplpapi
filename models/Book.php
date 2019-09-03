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
	public function __construct( $db ) {
		$this->conn = $db;
	}

	// Get Posts
	public function read() {
		// Create query SQL SERVER
		//$query = 'SELECT TOP 10 *  FROM '. $this->table . ' ';
		// Create query Mysql

		$query = 'SELECT   
	n.DOC_ID, 
   type_document.TYP_LIBELLE_AR, 
	indication.IND_LIBELLE_AR, 
   n.LAN_ID,
   langue.LAN_LIBELLE_AR, 
   n.DOC_TITRE_PROPRE, 
   n.DOC_TITRE_COMPLEMENT, 
   n.DOC_TITRE_PARALLELE, 
   n.DOC_TITRE_ENSEMBLE, 
   n.DOC_NUMERO_PARTIE, 
   editeur.EDT_NOM_AR, 
   editeur.EDT_KEYWORDS, 
   n.DOC_LIEU_EDITION, 
   n.DOC_ANNEE, 
   n.DOC_EDITION, 
   periodicite.PER_LIBELLE_AR, 
   n.DIP_ID, 
	specialite.SPE_LIBELLE_AR,
   n.COL_ID, 
   n.COL_NUMERO, 
   n.COT_NOTICE, 
   n.SCL_ID, 
   n.SCL_NUMERO, 
   n.DOC_NBR_UNITE, 
   n.DOC_ILLUSTRATION, 
   n.DOC_FORMAT, 
   n.DOC_MATERIEL, 
   n.DOC_ISBN, 
   n.DOC_ISSN, 
   n.DOC_NBR_EXEMPLAIRE, 
   n.STA_ID, 
   n.REL_VOLUME, 
   n.PAY_ID, 
   n.DOC_AGENCE, 
   n.DOC_PRET_INTERNE, 
   n.DOC_PRET_EXTERNE, 
   n.DOC_KEYWORDS, 
   n.CREATE_DATE, 
   n.UPDATE_DATE, 
   statut_notice.STA_LIBELLE_AR, 
   notice_auteur.VED_ID, 
   notice_auteur.FON_ID, 
   notice_auteur.AUT_TYPE, 
	GROUP_CONCAT(DISTINCT  vmath.VED_NOM) AS mats,
   vmath.VED_KEYWORDS, 
	GROUP_CONCAT( DISTINCT vauth.VED_NOM) AS auths,
	vauth.VED_KEYWORDS, 
	GROUP_CONCAT( DISTINCT notice_exemplaire.EXP_COTE) AS examp_cote,
	GROUP_CONCAT( DISTINCT notice_exemplaire.LOC_ID) AS exmp_location
FROM notice n
	   INNER JOIN editeur ON editeur.EDT_ID =n.EDT_ID
		INNER JOIN type_document ON type_document.TYP_ID = n.TYP_ID
		INNER JOIN langue ON langue.LAN_ID = n.LAN_ID
		INNER JOIN statut_notice ON statut_notice.STA_ID = n.STA_ID
		INNER JOIN indication ON indication.IND_ID = n.IND_ID
		INNER JOIN notice_exemplaire ON n.DOC_ID = notice_exemplaire.DOC_ID
		LEFT JOIN specialite ON n.SPE_ID = specialite.SPE_ID
		LEFT JOIN periodicite ON periodicite.PER_ID = n.PER_ID
		INNER JOIN notice_auteur ON n.DOC_ID = notice_auteur.DOC_ID
		INNER JOIN vedette vauth ON notice_auteur.VED_ID = vauth.VED_ID
		LEFT JOIN notice_matiere ON n.DOC_ID = notice_matiere.DOC_ID
		LEFT JOIN vedette vmath ON notice_matiere.VED_ID = vmath.VED_ID
		GROUP BY n.DOC_ID
		LIMIT 10  ';

		// Prepare statement
		$stmt = $this->conn->prepare( $query );
		//  var_dump($stmt);
		// Execute query
		$stmt->execute();


		return $stmt;
	}

	// Get Single Post
	public function read_single() {
		// Create query
		$query = 'SELECT   
	n.DOC_ID, 
   type_document.TYP_LIBELLE_AR, 
	indication.IND_LIBELLE_AR, 
   n.LAN_ID,
   langue.LAN_LIBELLE_AR, 
   n.DOC_TITRE_PROPRE, 
   n.DOC_TITRE_COMPLEMENT, 
   n.DOC_TITRE_PARALLELE, 
   n.DOC_TITRE_ENSEMBLE, 
   n.DOC_NUMERO_PARTIE, 
   editeur.EDT_NOM_AR, 
   editeur.EDT_KEYWORDS, 
   n.DOC_LIEU_EDITION, 
   n.DOC_ANNEE, 
   n.DOC_EDITION, 
   periodicite.PER_LIBELLE_AR, 
   n.DIP_ID, 
	specialite.SPE_LIBELLE_AR,
   n.COL_ID, 
   n.COL_NUMERO, 
   n.COT_NOTICE, 
   n.SCL_ID, 
   n.SCL_NUMERO, 
   n.DOC_NBR_UNITE, 
   n.DOC_ILLUSTRATION, 
   n.DOC_FORMAT, 
   n.DOC_MATERIEL, 
   n.DOC_ISBN, 
   n.DOC_ISSN, 
   n.DOC_NBR_EXEMPLAIRE, 
   n.STA_ID, 
   n.REL_VOLUME, 
   n.PAY_ID, 
   n.DOC_AGENCE, 
   n.DOC_PRET_INTERNE, 
   n.DOC_PRET_EXTERNE, 
   n.DOC_KEYWORDS, 
   n.CREATE_DATE, 
   n.UPDATE_DATE, 
   statut_notice.STA_LIBELLE_AR, 
   notice_auteur.VED_ID, 
   notice_auteur.FON_ID, 
   notice_auteur.AUT_TYPE, 
	GROUP_CONCAT(DISTINCT  vmath.VED_NOM) AS mats,
   vmath.VED_KEYWORDS, 
	GROUP_CONCAT( DISTINCT vauth.VED_NOM) AS auths,
	vauth.VED_KEYWORDS, 
	GROUP_CONCAT( DISTINCT notice_exemplaire.EXP_COTE) AS examp_cote,
	GROUP_CONCAT( DISTINCT notice_exemplaire.LOC_ID) AS exmp_location
FROM notice n
	   INNER JOIN editeur ON editeur.EDT_ID =n.EDT_ID
		INNER JOIN type_document ON type_document.TYP_ID = n.TYP_ID
		INNER JOIN langue ON langue.LAN_ID = n.LAN_ID
		INNER JOIN statut_notice ON statut_notice.STA_ID = n.STA_ID
		INNER JOIN indication ON indication.IND_ID = n.IND_ID
		INNER JOIN notice_exemplaire ON n.DOC_ID = notice_exemplaire.DOC_ID
		LEFT JOIN specialite ON n.SPE_ID = specialite.SPE_ID
		LEFT JOIN periodicite ON periodicite.PER_ID = n.PER_ID
		INNER JOIN notice_auteur ON n.DOC_ID = notice_auteur.DOC_ID
		INNER JOIN vedette vauth ON notice_auteur.VED_ID = vauth.VED_ID
		LEFT JOIN notice_matiere ON n.DOC_ID = notice_matiere.DOC_ID
		LEFT JOIN vedette vmath ON notice_matiere.VED_ID = vmath.VED_ID
		WHERE   n.DOC_ID = ?    LIMIT 0,1';

		// Prepare statement
		$stmt = $this->conn->prepare( $query );

		// Bind ID
		$stmt->bindParam( 1, $this->id );

		// Execute query
		$stmt->execute();
		$row = $stmt->fetch( PDO::FETCH_ASSOC );

		return $row;
	}


}