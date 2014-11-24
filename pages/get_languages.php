<?php
	$root = realpath ( $_SERVER ["DOCUMENT_ROOT"] );
	require_once $root . '/includes/Util.php';
 	$db = Util::getDb ();
	$confige= Util::getConfig ();
    $dbprefix =$confige['prefix'];
    $langFile = isset ( $_POST ['lang_file'] ) ? $_POST ['lang_file'] : '';
    
    $_SESSION["langFile"]=$langFile;
	$output="";

    $sql = " SELECT *  FROM {$dbprefix}languages ";
					
						$st = $db->prepare ( $sql );
				    	$st->execute ();
						
				    	$languages = $st->fetchAll ();
					    echo json_encode ($languages);
	
 
 
 // output JSON data


 