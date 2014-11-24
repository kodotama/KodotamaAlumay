<?php
$x7->load ( 'user' );

try {
	$user_ob = new x7_user ();
	$user_ob->leave_rooms ();
} catch ( x7_exception $ex ) {
	die ( json_encode ( array (
			'redirect' => $x7->url ( 'login' ) 
	) ) );
}

$_SESSION ['is_guest'] = 0;
$_SESSION ['user_id'] = 0;
$_SESSION ['rooms'] = array ();

// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000,
	$params["path"], $params["domain"],
	$params["secure"], $params["httponly"]
	);
}

// Finally, destroy the session.
session_destroy();
 echo "<script>window.location = window.location.origin+'/';</script>";
