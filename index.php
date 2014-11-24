<?php
date_default_timezone_set ( 'UTC' );
$config = require ('./config.php');

$root = realpath ( $_SERVER ["DOCUMENT_ROOT"] );

require_once $root . '/includes/Util.php';
require ('./includes/x7chat.php');
$x7 = new x7chat ();
 
$page = isset ( $_GET ['page'] ) ? $_GET ['page'] : '';

if(empty($page)){
	include 'roomtypes.php';
}else {
 
 $vars=  isset ( $_SESSION ['vars'] ) ? $_SESSION ['vars'] : array();

 if(!isset($vars["forward_params"])){
	$parts = parse_url(Util::getFullURL());
	
	if(isset($parts['query'])){
		parse_str($parts['query'], $query);
		
		if(!empty($query))
			$vars["forward_params"]=$query;
	}
 }

  
	if(isset($_SESSION ['user_id'])){

		    $page = isset ( $_GET ['page'] ) ? $_GET ['page'] : 'chat';
	}else{
				if (isset($_GET ['page']) &&  in_array ( $_GET ['page'], array ( 'sync' , 'login', 'logout', 'dologin', 'register', 'doregister'))) {
					
					$page =  $_GET ['page'];
						
				} elseif (!isset($_GET ['page'])){
					$page =  'register';
				} 
			
	}

 
if (preg_match ( '#[^a-z0-9_]#', $page ) || ! file_exists ( './pages/' . $page . '.php' )) 
{
		throw new exception ( 'Invalid page' );
	}
 
 global   $urlParam;
 $urlParam= isset ( $_GET ['urlParam'] ) ? $_GET ['urlParam'] : '';
 $search= isset ( $_GET ['search'] ) ? $_GET ['search'] : '';
 if ($search=='' & isset($paramArray['search']))
 $search=$paramArray['search'];
 
 
if (! in_array ( $page, array ( 'sync' , 'login', 'dologin', 'register', 'doregister') ) ) 
{
	$x7->load ( 'user' );
	try {
		$user = new x7_user ();
		$user_banned = $user->banned ();
	} catch ( x7_exception $ex ) {
		$user_banned = false;
		
		if (! empty ( $_SESSION ['user_id'] )) {
			$_SESSION = array ();
			session_destroy ();
			$x7->go ( 'login' );
		}
	}
	
	if (x7_check_ip_bans () || $user_banned) {
		$x7->set_message ( $x7->lang ( 'login_failed_banned' ) );
		$x7->go ( 'login' );
	}
}
require ('./pages/' . $page . '.php');
}
 