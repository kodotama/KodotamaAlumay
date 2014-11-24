<?php
  $root = realpath ( $_SERVER ["DOCUMENT_ROOT"] );
  require_once $root . '/includes/Util.php';
  Util::startSession ();
  $db = Util::getDb ();
  $confige= Util::getConfig ();
  $dbprefix =$confige['prefix'];
  $output="";
  $telNo = isset ( $_POST ['telNo'] ) ? $_POST ['telNo'] : 0;
  $web = isset ( $_POST ['web'] ) ? $_POST ['web'] : 0;
  $lat = isset ( $_POST ['lat'] ) ? $_POST ['lat'] : 0;
  $lng = isset ( $_POST ['lng'] ) ? $_POST ['lng'] : 0;
  $address = isset ( $_POST ['address'] ) ? $_POST ['address'] : '';
  $token = isset ( $_POST ['token'] ) ? $_POST ['token'] : 0;
  $sessionToken = $_SESSION ['token'];
  $userId = isset ( $_POST ['userId'] ) ? $_POST ['userId'] : 0;
  $sessionUserId = $_SESSION ['user_id'];
  $companyName = isset ( $_POST ['companyName'] ) ? $_POST ['companyName'] : '';
 

try {

	if(($token==$sessionToken) & ($userId==$sessionUserId)){
		Util::startSession ();
	
		$sql = " INSERT {$dbprefix}locations
		SET
	    name = :name,
		address = :address,
		lat = :lat,
		lng = :lng,
	    phone = :phone,
		web = :web ";
			
		$st = $db->prepare ( $sql );
		$st->execute ( array (
				':name' => $companyName,
				':address' => $address,
				':lat' => $lat,
				':lng' => $lng,
				':phone' => $telNo,
				':web' => $web
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


 