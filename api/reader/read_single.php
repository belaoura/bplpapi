<?php

// Headers
header( 'Access-Control-Allow-Origin: *' );
header( 'Content-Type: application/json' );

include_once '../../config/Database.php';
include_once '../../models/Reader.php';
// Instantiate DB & connect
$database = new Database();
$db       = $database->connect();
// Instantiate blog category object
$reader = new Reader( $db );

// Get ID
$reader->id = isset( $_GET['id'] ) ? $_GET['id'] : die();

// Get post
$stmt = $reader->read_single();
$row  = $stmt->fetch( PDO::FETCH_ASSOC );

unset( $row["CREATE_USER"] );
unset( $row["UPDATE_USER"] );
$actual_link  = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://{$_SERVER['HTTP_HOST']}";
$row["PHOTO"] = $actual_link . '/images/' . $row["LEC_ID"] . 'jpg';

// Make JSON
print_r( json_encode( $row ) );
