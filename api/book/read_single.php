<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Book.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog book object
  $book = new book($db);

  // Get ID
  $book->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get book
  $book->read_single();

  // Create array
  $book_arr = array(
        /** @var string $DOC_ID */
        /** @var string $COT_NOTICE */
        /** @var string $DOC_KEYWORDS */
        /** @var string $DOC_TITRE_COMPLEMENT */
        /** @var string $DOC_TITRE_PROPRE */
        /** @var array $DOC_TITRE_PARALLELE */
        /** @var string $DOC_TITRE_ENSEMBLE */
        /** @var string $DOC_ANNEE */
        /** @var string $DOC_ISBN */
        /** @var string $LAN_ID */
        /** @var string $PAY_ID */
        /** @var string $DOC_NBR_EXEMPLAIRE */
        /** @var string $DOC_LIEU_EDITION */
        /** @var string $DOC_NBR_UNITE */
        /** @var string $DOC_ILLUSTRATION */
        /** @var string $DOC_FORMAT */
        $book_item = array(
        'id' => $DOC_ID,
        'Cot_notice'=>$COT_NOTICE,
        'title' => $DOC_TITRE_PROPRE,
        'body' => $DOC_TITRE_COMPLEMENT,
        'author' => $DOC_TITRE_PARALLELE,
        'category_id' => $DOC_TITRE_ENSEMBLE,
        'YEAR' => $DOC_ANNEE,
        'ISBN' => $DOC_ISBN,
        'LAN_ID'=>$LAN_ID,
        'PAY_ID'=> $PAY_ID,
        'DOC_NBR_EXEMPLAIRE' => $DOC_NBR_EXEMPLAIRE,
        'DOC_LIEU_EDITION'=> $DOC_LIEU_EDITION,
        'DOC_NBR_UNITE'=>$DOC_NBR_UNITE,
        'DOC_ILLUSTRATION'=>$DOC_ILLUSTRATION,
        'DOC_FORMAT'=>$DOC_FORMAT,
        'DOC_KEYWORDS'=>$DOC_KEYWORDS
  );

  // Make JSON
  print_r(json_encode($book_arr));