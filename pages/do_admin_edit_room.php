<?php
$x7->load ( 'user' );
$root = realpath ( $_SERVER ["DOCUMENT_ROOT"] );
require_once $root . '/includes/Util.php';
$db = $x7->db ();

if (empty ( $_SESSION ['user_id'] )) {
	$x7->fatal_error ( $x7->lang ( 'login_required' ) );
}

$user = new x7_user ();
$perms = $user->permissions ();
$room_id = isset ( $_POST ['room_id'] ) ? $_POST ['room_id'] : 0;

$room = array ();
 
$hashtags = isset ( $_POST ['hashtags'] ) ? $_POST ['hashtags'] : '';
if($hashtags!=""){
	$hashtags=explode(',', $hashtags);
}

$name = isset ( $_POST ['name'] ) ? $_POST ['name'] : '';
$topic = isset ( $_POST ['topic'] ) ? $_POST ['topic'] : '';
$greeting = isset ( $_POST ['greeting'] ) ? $_POST ['greeting'] : '';
$enable_password = isset ( $_POST ['enable_password'] ) ? $_POST ['enable_password'] : '';
$password = isset ( $_POST ['password'] ) ? $_POST ['password'] : '';
$usage_type_id = isset ( $_POST ['usage_type_id'] ) ? $_POST ['usage_type_id'] : '';
if($usage_type_id=='')
	$usage_type_id=	isset ( $_POST ['usage_type_id_hidden'] ) ? $_POST ['usage_type_id_hidden'] : 0;


$usageText = isset ( $_POST ['usageText'] ) ? $_POST ['usageText'] : '';

$usageDeadline = isset ( $_POST ['usageDeadline'] ) ? $_POST ['usageDeadline'] : '';

if ($room_id) {
	$sql = "
		SELECT
		*
		FROM {$x7->dbprefix}rooms
		WHERE
		id = :room_id
		";
	$st = $db->prepare ( $sql );
	$st->execute ( array (
			':room_id' => $room_id 
	) );
	$room = $st->fetch ();
	$st->closeCursor ();
}

if (! $room && $room_id) // If there is room_id but no room related to the id.
{
	$x7->set_message ( $x7->lang ( 'room_not_found' ) );
} else if ($room && $room_id) { // If there are both room_id and a room related to id.
	$room_perms = $user->roomAuthorityTypes ( $room_id );
	if (empty ( $room_perms ['access_edit_room'] ) && empty ( $perms ['access_admin_panel'] )) { // If the user neither has edit access nor admin access.
		
		$x7->fatal_error ( $x7->lang ( 'access_denied' ) );
	}
}

$fail = false;

if (empty ( $name )) {
	$x7->set_message ( $x7->lang ( 'missing_room_name' ) );
	$fail = true;
} elseif (empty ( $room ) || $room ['name'] != $name) {
	$sql = "
			SELECT
				1
			FROM {$x7->dbprefix}rooms
			WHERE
				name = :name
				and
				usage_type_id= :usage_type_id
		";
	$st = $db->prepare ( $sql );
	$st->execute ( array (
			':name' => $name,
			':usage_type_id'=> $usage_type_id
	) );
	$check_room = $st->fetch ();
	$st->closeCursor ();
	
	if ($check_room) {
		$x7->set_message ( $x7->lang ( 'room_name_in_use' ) );
		$fail = true;
	}
}

if (! empty ( $enable_password ) && empty ( $password ) && empty ( $room ['password'] )) {
	$x7->set_message ( $x7->lang ( 'room_password_required' ) );
	$fail = true;
}

if (empty ( $fail )) {
	if ($enable_password) {
		if ($password) {
			require ('./includes/libraries/phpass/PasswordHash.php');
			$phpass = new PasswordHash ( 8, false );
			$password = $phpass->HashPassword ( $password );
		} else {
			$password = $room ['password'];
		}
	} else {
		$password = "";
	}
	
	$params = array (
			':name' => $name,
			':topic' => $topic,
			':greeting' => $greeting,
			':password' => $password,
			':usage_type_id' => $usage_type_id 
	);
	
	//ROOM UPDATE 
	if ($room) {
		$sql = "
				UPDATE {$x7->dbprefix}rooms SET
					name = :name,
					topic = :topic,
					greeting = :greeting,
					password = :password,
					usage_type_id =:usage_type_id 
				WHERE
					id = :room_id
			";
		$params [':room_id'] = $room_id;
	}
	//ROOM INSERT
	 else {
		$sql = "
				INSERT INTO {$x7->dbprefix}rooms SET
				    name = :name,
					topic = :topic,
					greeting = :greeting,
					password = :password,
					usage_type_id= :usage_type_id
			";
	}
	
	try {
		$db->beginTransaction ();
		
		$st = $db->prepare ( $sql );
		$st->execute ( $params );
		
		if (!$room) {	//if it was an INSERT	
				 	$lastInsertId = $db->lastInsertId ();
					if ($usage_type_id == 1) {
						
								$parame = array (
										':lastInsertId' => $lastInsertId,
										':usageText' => $usageText, 
										':usage_deadline' =>$usageDeadline
								);
							
								$sql = "
										INSERT INTO {$x7->dbprefix}room_usage SET
										room_id = :lastInsertId,
										usage_text = :usageText,
										usage_deadline=:usage_deadline
									    ";
								
								$st = $db->prepare ( $sql );
								$st->execute ( $parame );
								
						
								
							}		
							
							
			              // For room authorities 	

							$parame = array (
									':lastInsertId' => $lastInsertId,
									':userId' => $_SESSION["user_id"]
							);
								
							$sql = "
							INSERT INTO {$x7->dbprefix}room_author SET
							room_id = :lastInsertId,
							user_id = :userId,
							author_type=1, 
							access_edit_room=1
							
							";
							
							$st = $db->prepare ( $sql );
							$st->execute ( $parame );
							
							
							
							
			              
		}
						//if it was an UPDATE
		else {
			
			if ($usage_type_id == 1) {
				$parame = array (
						':usageText' => $usageText,
						':usage_deadline' =>$usageDeadline
				);
					
				$sql = "
				UPDATE  {$x7->dbprefix}room_usage SET
		        usage_text = :usageText,
				usage_deadline=:usage_deadline
					WHERE
					room_id = :room_id
					";
				$parame [':room_id'] = $room_id;
			
				$st = $db->prepare ( $sql );
				$st->execute ( $parame );
			
		}
		}


		$i=0;
		$hashtagsWithName[]= array ();
		if ( $hashtags!='' && sizeOf($hashtags)!=0){
		foreach ($hashtags as $key) {
				
			$hashtagsWithName[$i]=str_replace("#","<hash>",$key);
			if($hashtagsWithName[$i]!=$key){
				$hashtagsWithName[$i]=trim($hashtagsWithName[$i]);
				$hashtagsWithName[$i]=	$hashtagsWithName[$i]."</hash>";
				$matchesArray["hash"][$i]=$hashtagsWithName[$i];
				$i++;
			}
			$pageName=Util::getPageName();
			if($pageName)
			$hashtagsWithName[$i]=$pageName;
		}
		
		
		$tagnameArray= array ('hash');
		
		$commaSeperatedString=Util::convertArrayCommaSeperatedString($matchesArray, $tagnameArray);
		$commaSeperatedString=str_replace("<hash>","",$commaSeperatedString);
		$commaSeperatedString=str_replace("</hash>","",$commaSeperatedString);
		if(!empty($commaSeperatedString)){
			$sql="Select id from {$x7->dbprefix}rooms where name in(".$commaSeperatedString.")";
			$st = $db->prepare ( $sql );
			$st->execute ();
			$idArray=$st->fetchAll();
			$valueString="";
		
		
		}
		
		
		
		
		$i=sizeof($idArray);
		
		if($i){
		
			foreach ($idArray as $value) {
		
				$valueString=$valueString." (".$lastInsertId.",".$value["id"].")";
				$valueString=$valueString.",";
					
			}
			$valueString=substr($valueString, 0, -1);
		
			$sql="insert into {$x7->dbprefix}room_hashtags  (room_id, hashtag_id) values ".$valueString;
		
		}
		
		
		
		$st = $db->prepare ( $sql );
		
		$st->execute ();
	 
		
		
		
		}

	$db->commit ();

	$x7->set_message ( $x7->lang ( 'room_updated' ), 'notice' );
	$x7->go ( 'admin_list_rooms' );
	} catch ( Exception $e ) {
		
		$db->rollback ();
	
		throw $e;
		 
	}

	
} else {
	$x7->go ( 'admin_edit_room?room_id=' . $room_id, array (
			'room' => $_POST 
	) );
}
 