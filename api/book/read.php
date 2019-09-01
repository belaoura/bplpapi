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
  $num = $result->rowCount();

  // Check if any books
  if($num > 0) {
    // book array
    $books_arr = array();
    // $books_arr['data'] = array();
	  $jasoninfo = array(
		  'bplpName'   => 'Bplp ADrar',
		  'bplpCode'   => '0101',
		  'type'       => 'marc-json',
		  'ApiVersion' => '1.0.0'
	  );

	  array_push($books_arr, $jasoninfo);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

        /** @var string $doc_id */
        /** @var string $cot_notice */
        /** @var string $doc_keywords */
        /** @var string $doc_titre_complement */
        /** @var string $doc_titre_propre */
        /** @var array $doc_titre_parallele */
        /** @var string $doc_titre_ensemble */
        /** @var string $doc_annee */
        /** @var string $doc_isbn */
        /** @var string $lan_id */
        /** @var string $pay_id */
        /** @var string $doc_nbr_exemplaire */
        /** @var string $doc_lieu_edition */
        /** @var string $doc_nbr_unite */
        /** @var string $doc_illustration */
        /** @var string $doc_format */
	    /** @var string $doc_num */
	    /** @var string $doc_issn */
        $row['mats'] = (object)explode(',',$row['mats']);
        $row['authors'] =(object) explode(',',$row['authors']);
        $row['edt_keywords'] = array_filter(explode('/',$row['edt_keywords']));
        $row['doc_keywords'] = array_filter(explode('/',$row['doc_keywords']));
        $book_item = array(
	        'leader' => sprintf('%06d', $doc_id),
	        'fields' => [
				['001'=> sprintf('%06d', $doc_id)],
				['101'=> [ "$" ."a " => $doc_isbn]],
				['011'=> ["$" ."a "=> $doc_issn]],
				['017'=> [ "$" ."a " => $doc_num]],
		        ['111'=>$lan_id],
                ['cot_notice'=>$cot_notice],
                ['200' => $doc_titre_propre],
                ['body' => $doc_titre_complement],
		        ['author' => $doc_titre_parallele],
		        ['category_id' => $doc_titre_ensemble],
		        ['year' => $doc_annee],
		        ['isbn' => $doc_isbn],
		        ['801'=> $pay_id],
		        ['999' => $doc_nbr_exemplaire],
		        ['doc_lieu_edition'=> $doc_lieu_edition],
		        ['doc_nbr_unite'=>$doc_nbr_unite],
		        ['doc_illustration'=>$doc_illustration],
		        ['doc_format'=>$doc_format],
                ['keyedt'=>$row['edt_keywords']],
                ['docedt'=>$row['doc_keywords']],
                ['606'=>$row['mats'] ],
                ['703'=>$row['authors']]
	        ]
      );

      // Push to "data"
      array_push($books_arr, array_filter($book_item));

     // array_push($books_arr, array_filter( $row ));
      // array_push($books_arr['data'], $book_item);
    }

    // Turn to JSON & output
    echo json_encode((object) $books_arr);

  } else {
    // No books
    echo json_encode(
      array('message' => 'No books Found')
    );
  }
