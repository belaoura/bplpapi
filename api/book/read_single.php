<?php
// Headers
header( 'Access-Control-Allow-Origin: *' );
header( 'Content-Type: application/json' );

include_once '../../config/Database.php';
include_once '../../models/Book.php';

// Instantiate DB & connect
$database = new Database();
$db       = $database->connect();

// Instantiate blog book object
$book = new book( $db );

// Get ID
$book->id = isset( $_GET['id'] ) ? $_GET['id'] : die();

// Get book
$stmt = $book->read_single();
$row  = $stmt->fetch( PDO::FETCH_ASSOC );
extract( $row );
// Create array

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
$book_item = array(
	'leader' => sprintf( '%06d', $DOC_ID ),
	'fields' => [
		// n? notice
		'001'              => sprintf( '%06d', $DOC_ID ),
		//ISBN
		'101'              => [ "$" . "a " => $DOC_ISBN ],
		// ISSN
		'011'              => [ "$" . "a " => $DOC_ISSN ],
		// Autre num?ro
		'017'              => [ "$" . "a " => $DOC_NUM ],
		'111'              => $LAN_ID,
		'Cot_notice'       => $COT_NOTICE,
		'200'              => $DOC_TITRE_PROPRE,
		'body'             => $DOC_TITRE_COMPLEMENT,
		'author'           => $DOC_TITRE_PARALLELE,
		'category_id'      => $DOC_TITRE_ENSEMBLE,
		'YEAR'             => $DOC_ANNEE,
		'ISBN'             => $DOC_ISBN,
		'801'              => $PAY_ID,
		'999'              => $DOC_NBR_EXEMPLAIRE,
		'DOC_LIEU_EDITION' => $DOC_LIEU_EDITION,
		'DOC_NBR_UNITE'    => $DOC_NBR_UNITE,
		'DOC_ILLUSTRATION' => $DOC_ILLUSTRATION,
		'DOC_FORMAT'       => $DOC_FORMAT,
		'606'              => $DOC_KEYWORDS
	]
);

// Make JSON

print_r( json_encode( array_filter( $row ) ) );