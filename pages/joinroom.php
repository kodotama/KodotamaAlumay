<?php
$root = realpath ( $_SERVER ["DOCUMENT_ROOT"] );
require_once $root . '/includes/Util.php';
$db = Util::getDb ();
$confige= Util::getConfig ();
$dbprefix =$confige['prefix'];

Util::startSession ();

$usageTypeId = isset ( $_POST ['usageTypeId'] ) ? $_POST ['usageTypeId'] : 0;

	
$roomName = isset ( $_POST ['roomName'] ) ? $_POST ['roomName'] : '';
 
$limit=isset ( $_POST ['limit'] ) ? $_POST ['limit'] : 0;

$room_id = isset ( $_GET ['room_id'] ) ? $_GET ['room_id'] : 0;
if (! $room_id) {
	$room_id = isset ( $_POST ['room_id'] ) ? $_POST ['room_id'] : 0;
}

$message_id = isset ( $_GET ['message_id'] ) ? $_GET ['message_id'] : 0;
if (! $message_id) {
	$message_id = isset ( $_POST ['message_id'] ) ? $_POST ['message_id'] : 0;
}

if($limit==0) {//E�er limit 0'dan b�y�kse, bu showPast20Msg �zelli�inden g�nderilmi�tir ve h�li haz�rda oda bilgileri vard�r.
	
  	$room_pass = isset ( $_POST ['password'] ) ? $_POST ['password'] : '';
	
	$user_id = $_SESSION ['user_id'];
	
	$sql = "
	SELECT
	room.*, usage_text, usage_deadline
	FROM {$dbprefix}rooms room
	LEFT JOIN {$dbprefix}room_usage room_usage
	ON room.id=room_usage.room_id
	WHERE
	room.id = :room_id
	OR
	(room.usage_type_id=:usageTypeId AND room.name=:roomName)
	";
	
	try {
	$db->beginTransaction ();
	
	$st = $db->prepare ( $sql );
	
	$db->commit ();
	} catch ( Exception $e ) {
	
	$db->rollback ();
	}
	$st->execute ( array (
			':room_id' => $room_id,
			':usageTypeId' => $usageTypeId,
			':roomName' => $roomName
	) );
	$room = $st->fetch ();
	$st->closeCursor ();
	
	if (! $room) {
	$output = array (
	'type' => "error",
	'message' => $roomName,
	'navigate' => $usageTypeId,
				'urlRoom' => Util::url ( 'admin_edit_room' )
					);
					echo json_encode ( $output ); // output JSON data
	
	return false;
	}
	
	if (! $room_id) {
	$room_id = $room ["id"];
	}
	
	$pass = $room ['password'];
		unset ( $room ['password'] );
	
		if ($pass) {
		require (Util::getRoot () . '/includes/libraries/phpass/PasswordHash.php');
		$phpass = new PasswordHash ( 8, false );
	
		if (empty ( $room_pass )) {
			$output = array (
					'url' => '?page=roompass&room_id=' . $room_id
				)
				;
				echo json_encode ( $output ); // output JSON data
				return false;
			} elseif (! $phpass->CheckPassword ( $room_pass, $pass )) {
				
			$output = array (
					'type' => "error",
					'message' => Util::lang ( 'room_password_fail' )
			);
			echo json_encode ( $output ); // output JSON data
		
			return false;
			}
			}
	
			$_SESSION ['last_local_sync_time'] = time ();
	
			$sql = "
			UPDATE {$dbprefix}users
		SET
			timestamp = :timestamp,
			ip = :ip
			WHERE
			id = :user_id
			";
			$st = $db->prepare ( $sql );
			$st->execute ( array (
			':user_id' => $user_id,
			':timestamp' => date ( 'Y-m-d H:i:s' ),
			':ip' => $_SERVER ['REMOTE_ADDR']
	) );
	
					$sql = "
		INSERT IGNORE INTO {$dbprefix}room_users (user_id, room_id) VALUES (:user_id, :room_id)
					";
					$st = $db->prepare ( $sql );
					$st->execute ( array (
					':room_id' => $room_id,
					':user_id' => $user_id
			) );
	
					$sql = "
					SELECT
					room_user.*,
					user.username AS user_name
					FROM {$dbprefix}room_users room_user
					INNER JOIN {$dbprefix}users user ON
					user.id = room_user.user_id
					WHERE
					room_id = :room_id
					";
					$st = $db->prepare ( $sql );
					$st->execute ( array (
							':room_id' => $room_id
					) );
					$users = $st->fetchAll ();
	
					$sql = "
					INSERT INTO {$dbprefix}messages (timestamp, message_type, dest_type, dest_id, source_type, source_id) VALUES (:timestamp, :message_type, :dest_type, :dest_id, :source_type, :source_id)
					";
					$st = $db->prepare ( $sql );
					$st->execute ( array (
					':timestamp' => date ( 'Y-m-d H:i:s' ),
					':message_type' => 'room_resync',
					':dest_type' => 'room',
					':dest_id' => $room_id,
						':source_type' => 'system',
								':source_id' => 0
	) );
	 
 
}		/*
					* if ($room ['greeting']) { $x7->load ( 'user' ); $user = new x7_user (); $user_data = $user->data (); $greet = str_replace ( '%u', $user_data ['username'], $room ['greeting'] ); $sql = " INSERT INTO {$dbprefix}messages (timestamp, message, message_type, dest_type, dest_id, source_type, source_id) VALUES (:timestamp, :message, :message_type, :dest_type, :dest_id, :source_type, :source_id) "; $st = $db->prepare ( $sql ); $st->execute ( array ( ':timestamp' => date ( 'Y-m-d H:i:s' ), ':message' => $greet, ':message_type' => 'message', ':dest_type' => 'user', ':dest_id' => $user_id, ':source_type' => 'system', ':source_id' => 0 ) ); }
					 */
					$sql = "
					SELECT    
					message.*,
					msgrooms.hashtag_room_id as hashtag_room_id,
					user.username AS source_name
					FROM {$dbprefix}messages message
					LEFT JOIN {$dbprefix}message_rooms msgrooms ON
					 msgrooms.message_id = message.id
					LEFT JOIN {$dbprefix}users user ON
					 message.source_type = 'user'
					AND
					 user.id=message.source_id
					WHERE
					message.dest_type = 'room'
					AND (message.dest_id = :room_id OR msgrooms.hashtag_room_id=:room_id)
					AND message.message_type = 'message'   ";
					
						 $paramMsg= array (
					':room_id' => $room_id 
						 );
						 
						if($message_id){
							$sql=$sql. " AND message.id = :message_id  ";
							$paramMsg["message_id"] = $message_id;
						  
						}
						
					$sql=$sql."	ORDER BY message.id DESC
						LIMIT " . $limit. ", 20 ";
						 
						$st = $db->prepare ( $sql );
				 $st->execute ( $paramMsg );
					$messages = $st->fetchAll ();
					$messages = array_reverse ( $messages );
					if($messages){
					$sql = "SELECT  
					count(1)  as messageCount
					FROM {$dbprefix}messages message
					LEFT JOIN {$dbprefix}message_rooms msgrooms ON
					 msgrooms.message_id = message.id
					LEFT JOIN {$dbprefix}users user ON
					 message.source_type = 'user'
					AND
					 user.id=message.source_id
					WHERE
					message.dest_type = 'room'
					AND (message.dest_id = :room_id OR msgrooms.hashtag_room_id=:room_id)
					AND message.message_type = 'message' ";
					 
					

						 $paramMsg= array (
					':room_id' => $room_id 
						 );
						 
						if($message_id){
							$sql=$sql. " AND message.id = :message_id  ";
							$paramMsg["message_id"] = $message_id;
						  
						}
						 
						$st = $db->prepare ( $sql );
						 $st->execute ($paramMsg);
						$messageCount = $st->fetch();
					}
						foreach ( $messages as &$message ) {
						$message ['timestamp'] = strtotime ( $message ['timestamp'] );
						
				   
						
					}
	unset ( $message );

	if (! isset ( $_SESSION ['rooms'] ) || ! in_array ( $room_id, $_SESSION ['rooms'] )) {
		$_SESSION ['rooms'] [] = $room_id;
		
	 
	
	 
} // end of if (! $rangeArray) 
if (isset ( $room ))
	$output ["room"] = $room;
if (isset ( $users ))
	$output ["users"] = $users;
if (isset ( $messages ))
	$output ["messages"] = $messages;
if (isset ( $messageCount ))
	$output ["messageCount"] = $messageCount;
echo json_encode ( $output ); // output JSON data




 