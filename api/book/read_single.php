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
$row  = $book->read_single();
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
$row['mats'] = (object)explode(',',$row['mats']);
$row['authors'] =(object) explode(',',$row['authors']);
$row['edt_keywords'] = array_filter(explode('/',$row['edt_keywords']));
$row['doc_keywords'] = array_filter(explode('/',$row['doc_keywords']));
/** @var string $DOC_AGENCE */
/** @var string $EDT_NOM_AR */
/** @var string $VED_NOM */
$book_item = array(
	'leader' => sprintf('%06d', $DOC_ID),
	'fields' => [
		['001'=> sprintf('%06d', $DOC_ID)],
		['010'=> [ "$" ."a" => $DOC_ISBN]],
		['011'=> ["$" ."a"=> $DOC_ISSN]],
		['017'=> [ "$" ."a" => $DOC_NUM]],
		['111'=>[ "$" ."a" =>$LAN_ID]],
		['200' => [ "$" ."a" =>$DOC_TITRE_PROPRE]],
		['210'=> [
			"$" ."a" => $DOC_LIEU_EDITION,
			"$" ."c" => $EDT_NOM_AR,
			"$" ."d" => $DOC_ANNEE,
		]],
		['225' => [ "$" ."a" =>$DOC_TITRE_ENSEMBLE]],
		['215'=>[
			"$" ."a" => $DOC_NBR_UNITE,
			"$" ."d" => $DOC_ILLUSTRATION,
			"$" ."c" => $DOC_FORMAT
		]],
		['606'=>$row['mats']],
		['701'=>[ "$" ."a" =>$VED_NOM]],
		['703'=>$row['authors']],
		['801'=> [
			"$" ."a" => $PAY_ID,
			"$" ."b" => $DOC_AGENCE,
		]],
		['999' => $DOC_NBR_EXEMPLAIRE],
	]
);
// Turn to JSON & output
$books_api = array(
	'bplpName'   => 'Bplp ADrar',
	'bplpCode'   => '0101',
	'type'       => 'marc-json',
	'ApiVersion' => '1.0.0',
	'book'=>$book_item
);
print_r(json_encode((object) $books_api));


//print_r( json_encode( array_filter( $row ) ) );