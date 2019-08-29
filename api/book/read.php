<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Book.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Book informations object
  $book = new Book($db);

  // Book informations query
  $result = $book->read();

  // Get row count
  $num = $result->fetchColumn();

  // Check if any books
  if($num > 0) {
    // book array
    $books_arr = array();
    // $books_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);


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

      // Push to "data"
      array_push($books_arr, $book_item);
      // array_push($books_arr['data'], $book_item);
    }

    // Turn to JSON & output
    echo json_encode($books_arr);

  } else {
    // No books
    echo json_encode(
      array('message' => 'No books Found')
    );
  }
