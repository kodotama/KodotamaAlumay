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
 
$page = array ();
$page_id = isset ( $_POST ['page_id'] ) ? $_POST ['page_id'] : 0;
$pageName = isset ( $_POST ['pageName'] ) ? $_POST ['pageName'] : '';
$hashtags = isset ( $_POST ['hashtags'] ) ? $_POST ['hashtags'] : '';
if($hashtags!=""){
	$hashtags=explode(',', $hashtags);
}
 

if ($page_id) {
	$sql = "
		SELECT
		*
		FROM {$x7->dbprefix}pages
		WHERE
		id = :page_id
		";
	$st = $db->prepare ( $sql );
	$st->execute ( array (
			':page_id' => $page_id
	) );
	$page = $st->fetch ();
	$st->closeCursor ();
}

if (! $page && $page_id) // If there is room_id but no room related to the id.
{
	$x7->set_message ( $x7->lang ( 'page_not_found' ) );
} else if ($page && $page_id) { // If there are both room_id and a room related to id.
	$page_perms = $user->pageAuthorityTypes ( $page_id );
	if (empty ( $page_perms ['access_edit_page'] ) && empty ( $perms ['access_admin_panel'] )) { // If the user neither has edit access nor admin access.
		
		$x7->fatal_error ( $x7->lang ( 'access_denied' ) );
	}
}

$fail = false;

if (empty ( $pageName )) {
	$x7->set_message ( $x7->lang ( 'missing_page_name' ) );
	$fail = true;
} elseif (empty ( $page ) || $page ['name'] != $pageName) {
	$sql = "
			SELECT
				1
			FROM {$x7->dbprefix}pages
			WHERE
				page_name = :name
 
		";
	$st = $db->prepare ( $sql );
	$st->execute ( array (
			':name' => $pageName 
	) );
	$check_page = $st->fetch ();
	$st->closeCursor ();
	
	if ($check_page) {
		$x7->set_message ( $x7->lang ( 'page_name_in_use' ) );
		$fail = true;
	}
}

if (empty ( $fail )) {

	$params = array (
			':name' => $pageName,
 	);
	
	if ($page) {
				$sql = "UPDATE {$x7->dbprefix}pages SET
						page_name = :name
					    WHERE
						id = :page_id";
				 $params [':page_id'] = $page_id;

	} else {
		$sql = "
				INSERT INTO {$x7->dbprefix}pages SET
					page_name = :name
				    ";
	}
	
	try {
		$db->beginTransaction ();
		
		$st = $db->prepare ( $sql );
		$st->execute ( $params );

		$insertedId = $db->lastInsertId();

		
		$i=0;
		$hashtagsWithName[]= array ();
		
		foreach ($hashtags as $key) {
			
 			$hashtagsWithName[$i]=str_replace("#","<hash>",$key);
			if($hashtagsWithName[$i]!=$key){
			$hashtagsWithName[$i]=trim($hashtagsWithName[$i]);
			$hashtagsWithName[$i]=	$hashtagsWithName[$i]."</hash>";
			$matchesArray["hash"][$i]=$hashtagsWithName[$i];
			$i++;
			}
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
				
				$valueString=$valueString." (".$insertedId.",".$value["id"].")";
				$valueString=$valueString.",";
					
			}
			$valueString=substr($valueString, 0, -1);
		
			$sql="insert into {$x7->dbprefix}page_hashtags  (page_id, hashtag_id) values ".$valueString;
		
		}
		
		
		
		$st = $db->prepare ( $sql );
		
		$st->execute ();
		$db->commit ();
        $x7->set_message ( $x7->lang ( 'page_saved' ), 'notice' );
		$x7->go ( 'admin_edit_page' );

	
	
	
	
	} catch ( Exception $e ) {
		
		$db->rollback ();
	
		throw $e;
		 
	}

}else {
	$x7->go ( 'admin_edit_page' );
	
}
// fail=null	
 