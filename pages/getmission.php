<?php
 		try {
			
			if (isset ( $_POST ["room_id"] )) {
				$room_id = $_POST ["room_id"];
				
				$sql = "SELECT text from asndb_missions where room_id=:room_id";
		 	
				$db = db ();
				$st = $db->prepare ( $sql );
				$st->execute ( array (
						':room_id' => $room_id
				) );
				
				$st->execute ();
				$text= $st->fetch();
			    $st->closeCursor ();
			   
				// prepare for JSON
				$output = array (
						'text' => $text
						 
				);
				echo json_encode ( $output ); // output JSON data
			}
		} catch ( Exception $e ) {
			echo json_encode ( $e->getTraceAsString () );
		}
 
 
 
 
function db() {
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
		
	$config = require ($root.'/config.php');

	$dsn = 'mysql:host=' . $config ['host'] . ';dbname=' . $config ['dbname'] . ';charset=utf8';
	$options = array (
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => FALSE
	);
	$db = new PDO ( $dsn, $config ['user'], $config ['pass'], $options );
	$db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$db->setAttribute ( PDO::ATTR_AUTOCOMMIT, TRUE );
	$db->setAttribute ( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
		


	return $db;
}
?>
 