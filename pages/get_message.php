<?php
	$root = realpath ( $_SERVER ["DOCUMENT_ROOT"] );
	require_once $root . '/includes/Util.php';
 	$db = Util::getDb ();
	$confige= Util::getConfig ();
    $dbprefix =$confige['prefix'];
	$message_id = isset ( $_GET ['message_id'] ) ? $_GET ['message_id'] : 0;
 
	
	if (!$message_id) {
	$message_id = isset ( $_POST ['message_id'] ) ? $_POST ['message_id'] : 0;
	
		}
	 
	$output="";

 
 
 
	 
 
	if($message_id!=0 ){
	

 
		$sql = "        SELECT    
						*
					    FROM {$dbprefix}messages message
						WHERE
						message.id = :messageId;";
					
						$st = $db->prepare ( $sql );
				    	$st->execute ( array (
												':messageId' => $message_id 
										) );
						
				    	$message = $st->fetchAll ();
					 
				  
if (isset ( $message )) $output ["message"] = $message;


}
 	echo json_encode ( $output );
	
 
 
 // output JSON data


 