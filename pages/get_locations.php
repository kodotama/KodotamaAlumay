<?php
	$root = realpath ( $_SERVER ["DOCUMENT_ROOT"] );
	require_once $root . '/includes/Util.php';
 	$db = Util::getDb ();
	$confige= Util::getConfig ();
    $dbprefix =$confige['prefix'];
	 
	 
	$output="";

    $sql = " SELECT *  FROM {$dbprefix}locations loca";
					
						$st = $db->prepare ( $sql );
				    	$st->execute ();
						
				    	$locations = $st->fetchAll ();
					    echo json_encode ( $locations );
	
 
 
 // output JSON data


 