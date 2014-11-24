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
 
$newText = isset ( $_GET ['newText'] ) ? $_GET ['newText'] : '';
if (! $newText) {
$newText = isset ( $_POST ['newText'] ) ? $_POST ['newText'] : '';
}

try {

	if($message_id!=0 & $newText!='' & ($token==$sessionToken) & ($userId==$sessionUserId)){
		Util::startSession ();
	
		$sql = " UPDATE
			
		{$dbprefix}messages message
		SET
		message = :newText
		WHERE
		message.id = :messageId
		;";
			
		$st = $db->prepare ( $sql );
		$st->execute ( array (
				':messageId' => $message_id,
		':newText' => $newText
		) );
	
		$info= Util::lang ( 'success' );
	

	
	
	}else{
		$info= Util::lang ( 'denem' );
	}
	
} catch (Exception $e) {
	$info= Util::lang ( 'failed' );
	
}
if (isset ( $info )) $output ["info"] = $info;
echo json_encode ( $output ); // output JSON data


 