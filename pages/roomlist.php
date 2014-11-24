<?php
$db = $x7->db ();

if (empty ( $_SESSION ['user_id'] )) {
	$x7->fatal_error ( $x7->lang ( 'login_required' ) );
}

	$sql = "SELECT * FROM {$x7->dbprefix}rooms ";
    $whereAnd=" where ";
    $sqlParams = array ();
   
	if ($urlParam!="-1" )
	{
		$sqlParams = array (
				':usage_type_id' => $urlParam
		
		);
		$sql = 	$sql .$whereAnd. "usage_type_id=:usage_type_id ";
		$whereAnd=" and ";
	 
	}
   
	if($search){
		$sqlParams[':search'] =  "%".$search."%";
		$sqlParams[':page_name'] =  $search;
		
		$sql =  $sql . $whereAnd  ." name like :search  or id in (SELECT hashtag_id FROM {$x7->dbprefix}page_hashtags where page_id in(SELECT id FROM {$x7->dbprefix}pages where page_name=:page_name))  ";
			
		 
	}
   
 
 	

	$st = $db->prepare ( $sql );
	$st->execute ($sqlParams);
 

$rooms = $st->fetchAll ();

$x7->display ( 'pages/roomlist', array (
		'rooms' => $rooms 
) );