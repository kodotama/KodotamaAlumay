<?php

$root = realpath ( $_SERVER ["DOCUMENT_ROOT"] );
require_once $root . '/includes/Util.php';
Util::startSession ();
$db = Util::getDb ();
$confige= Util::getConfig ();
$dbprefix =$confige['prefix'];
$message_id = isset ( $_GET ['message_id'] ) ? $_GET ['message_id'] : 0;
$output="";
if (! $message_id) {
	$message_id = isset ( $_POST ['message_id'] ) ? $_POST ['message_id'] : 0;
}
  
$token = isset ( $_GET ['token'] ) ? $_GET ['token'] : 0;


    if (!$token) {
	   $token = isset ( $_POST ['token'] ) ? $_POST ['token'] : 0;
	}

	$sessionToken = $_SESSION ['token'];

$userId = isset ( $_GET ['userId'] ) ? $_GET ['userId'] : 0;
	
	
	if (!$userId) {
		$userId = isset ( $_POST ['userId'] ) ? $_POST ['userId'] : 0;
	}
	
	$sessionUserId = $_SESSION ['user_id'];
 
 
try {

	if(($message_id!=0 & ($token==$sessionToken) & ($userId==$sessionUserId))  ||   $_SESSION["user_id"]==1 ){
		Util::startSession ();
	
		$sql = " DELETE FROM {$dbprefix}messages WHERE id = :messageId;";
			
		$st = $db->prepare ( $sql );
		$st->execute ( array (
				':messageId' => $message_id 
		) );
	
		$deleteInfo= Util::lang ( 'success' );
	

	
	
	}else{
		$deleteInfo= Util::lang ( 'message not found' );
	}
	
} catch (Exception $e) {
	$info= Util::lang ( 'failed' );
	
}
if (isset ( $deleteInfo )) $output ["deleteInfo"] = $deleteInfo;
echo json_encode ( $output ); // output JSON data


 