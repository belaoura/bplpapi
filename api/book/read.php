<?php
// Headers
header( 'Access-Control-Allow-Origin: *' );
header( 'Content-Type: application/json' );

include_once '../../config/Database.php';
include_once '../../models/Book.php';

// Instantiate DB & connect
$database = new Database();
$db       = $database->connect();

// Instantiate Book informations object
$book = new Book( $db );

// Book informations query
$result = $book->read();

// Get row count
$num = $result->rowCount();

// Check if any books
if ( $num > 0 ) {
	// book array

	$books_arr = array();
	$books_api = array();
	// $books_arr['data'] = array();

	while ( $row = $result->fetch( PDO::FETCH_ASSOC ) ) {
		//var_dump($row);
		extract( $row );

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
		/** @var string $DOC_NUM */
		/** @var string $DOC_ISSN */
		/** @var string $DOC_AGENCE */
		/** @var string $EDT_NOM_AR */
		/** @var string $VED_NOM */
		/** @var string $IND_ID */
		$row['mats']         = (object) explode( ',', $row['mats'] );
		$row['authors']      = (object) explode( ',', $row['authors'] );
		$row['examplaires']  = (object) explode( ',', $row['examplaires'] );
		$row['EDT_KEYWORDS'] = array_filter( explode( '/', $row['EDT_KEYWORDS'] ) );
		$row['DOC_KEYWORDS'] = array_filter( explode( '/', $row['DOC_KEYWORDS'] ) );
		$book_item = array(
			'leader' => sprintf( '%06d', $DOC_ID ),
			'fields' => [
				[ '001' => sprintf( '%06d', $DOC_ID ) ],
				[ '010' => [ "$" . "a" => $DOC_ISBN ] ],
				[ '011' => [ "$" . "a" => $DOC_ISSN ] ],
				[ '017' => [ "$" . "a" => $DOC_NUM ] ],
				[ '111' => [ "$" . "a" => $LAN_ID ] ],
				[ '200' => [
					"$" . "a" => $DOC_TITRE_PROPRE,
					"$" . "d" => $DOC_TITRE_COMPLEMENT,
					"$" . "e" => $DOC_TITRE_PARALLELE,
				] ],
				[
					'210' => [
						'subfields' => [
							"$" . "a" => $DOC_LIEU_EDITION,
							"$" . "c" => $EDT_NOM_AR,
							"$" . "d" => $DOC_ANNEE,
						],
						'ind1'      => '1',
						'ind2'      => ''
					]
				],
				[ '225' => [ "$" . "a" => $DOC_TITRE_ENSEMBLE ] ],
				[
					'215' => [
						"$" . "a" => $DOC_NBR_UNITE,
						"$" . "d" => $DOC_ILLUSTRATION,
						"$" . "c" => $DOC_FORMAT
					]
				],
				[ '606' => $row['mats'] ],
				[ '701' => [ "$" . "a" => $VED_NOM ] ],
				[ '703' => $row['authors'] ],
				[
					'801' => [
						"$" . "a" => $PAY_ID,
						"$" . "b" => $DOC_AGENCE,
					]
				],
				[ '901' => $IND_ID ],
				[ '995' => $row['examplaires'] ],
				[ '999' => $DOC_NBR_EXEMPLAIRE ],
			]
		);

		// Push to "data"
		array_push( $books_arr, array_filter( $book_item ) );

		// array_push($books_arr, array_filter( $row ));
		// array_push($books_arr['data'], $book_item);
	}
	// Turn to JSON & output
	$books_api = array(
		'bplpName'   => 'Bplp ADrar',
		'bplpCode'   => '0101',
		'type'       => 'unimarc-json',
		'ApiVersion' => '1.0.0',
		'books'      => $books_arr
	);
	echo json_encode( (object) $books_api );

} else {
	// No books
	echo json_encode(
		array( 'message' => 'No books Found' )
	);
}
