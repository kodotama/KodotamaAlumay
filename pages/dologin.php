<?php
$root = realpath ( $_SERVER ["DOCUMENT_ROOT"] );

 if(!isset($x7)){
 	require_once $root . '/includes/x7chat.php';
  
 	$x7=new x7chat();
 }
 $root = realpath ( $_SERVER ["DOCUMENT_ROOT"] );
 
 require_once $root . '/includes/Util.php';
 
  
 
$x7->load ( 'user' );
$vars=  isset ( $_SESSION ['vars'] ) ? $_SESSION ['vars'] : array();
$db = $x7->db ();
$token = md5(rand(1000,9999)); //you can use any encryption

$isAjax = isset ( $_POST ['isAjax'] ) ? $_POST ['isAjax'] : 0;


$email = isset ( $_POST ['email'] ) ? $_POST ['email'] : null;

if (! $email) {
	$email=$token;
	$password=null;
	$_SESSION["is_guest"]=1;
}else{
 	if (! filter_var ( $email, FILTER_VALIDATE_EMAIL )) {
		$x7->set_message ( $x7->lang ( 'invalid_email' ) );
		$x7->go ( 'login' );
	}
}

// Check IP bans
$ban_match = x7_check_ip_bans ();
if ($ban_match) {
	$x7->set_message ( $x7->lang ( 'login_failed_banned' ) );
	$x7->go ( 'login' );
}

$password = isset ( $_POST ['password'] ) ? $_POST ['password'] : null;

try {
	$user_ob = new x7_user ( $email, 'email' );
	$user = $user_ob->data ();
} catch ( x7_exception $ex ) {
	$user = array ();
}

require ($root.'/includes/libraries/phpass/PasswordHash.php');
$phpass = new PasswordHash ( 8, false );

if ($user && ! $user ['password'] && strtotime ( $user ['timestamp'] ) < time () - 120) {
	$sql = "DELETE FROM {$x7->dbprefix}users WHERE id = :del_id";
	$st = $db->prepare ( $sql );
	$st->execute ( array (
			':del_id' => $user ['id'] 
	) );
	$user = array ();
}


if (! $user && $x7->config ( 'allow_guests' )) {
	$sql = "INSERT INTO {$x7->dbprefix}users (username, email) VALUES (:username, :email)";
	$st = $db->prepare ( $sql );
	$st->execute ( array (
			':username' => $email,
			':email' => $email 
	) );
	$user_id = $db->lastInsertId ();
	$user = array (
			'id' => $user_id 
	);
} elseif (! $user || ! $user ['password'] || ! $phpass->CheckPassword ( $password, $user ['password'] )) {
	$x7->set_message ( $x7->lang ( 'login_failed' ) );
	$x7->go ( 'login', array (
			'email' => $email 
	) );
}

// Check user ID bans
if ($user_ob->banned ()) {
	$x7->set_message ( $x7->lang ( 'login_failed_banned' ) );
	$x7->go ( 'login' );
}
 
$_SESSION ['user_id'] = $user ["id"];
$_SESSION ['user_name'] = $user ["username"];
$_SESSION['token'] = $token; //store it as session variable

if(!$isAjax)
{
$x7->go ( 'chat', $vars);
}else{
	
	$info= Util::lang ( 'success' );
	$isSucces=1;
	$output ["success"]=1;
	$output ["info"] = $info;
	echo json_encode ( $output ); // output JSON data
}
