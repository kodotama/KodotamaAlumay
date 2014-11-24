<?php
 
$open_room_name=isset ( $_GET ['open_room_name'] ) ? $_GET ['open_room_name'] : "";
$usage_type_id=isset ( $_GET ['usage_type_id'] ) ? $_GET ['usage_type_id'] : 0;


$room_id=isset ( $_GET ['room_id'] ) ? $_GET ['room_id'] : 0;
$message_id=isset ( $_GET ['message_id'] ) ? $_GET ['message_id'] : 0;

$vars=  isset ( $_SESSION ['vars'] ) ? $_SESSION ['vars'] : array();
$forwardParams=  isset ($vars["forward_params"]) ? $vars["forward_params"] : array();

 if(!$room_id)
	$room_id=  isset ($forwardParams["room_id"] ) ? $forwardParams["room_id"]  : 0;
 
 if(!$open_room_name)
 	
 	$open_room_name=  isset ($forwardParams["open_room_name"] ) ? $forwardParams["open_room_name"]  : "";

 if(!$usage_type_id)
 	
 	$usage_type_id=  isset ( $forwardParams["usage_type_id"] ) ? $forwardParams["usage_type_id"]  : 0;

if(!$message_id)
	$message_id=  isset ( $forwardParams["message_id"] ) ? $forwardParams["message_id"]  : 0;

 if (isset ( $x7 )) {
	$x7->load ( 'user' );
	
	$db = $x7->db ();
	
	if (!$_SESSION ['user_id']) {
		echo "chat";
		$vars["forward_params"]=array(
									 "room_id"=> 	$room_id,		
									 "message_id"=> 	$message_id,
									 "open_room_name"=> $open_room_name,
									 "usage_type_id"=> $usage_type_id
				
				 
		);
		
 		$x7->go ( 'dologin', $vars);
		
      }
	
	$user_id = $_SESSION ['user_id'];
	
	$sql = "
		SELECT
			*
		FROM {$x7->dbprefix}word_filters
		ORDER BY
			LENGTH(word) DESC
	";
	$st = $db->prepare ( $sql );
	$st->execute ();
	$filters = $st->fetchAll ();
	
	$user = new x7_user ();
	
	$user_ob = new x7_user ();
	$perms = $user_ob->permissions ();
	$access_acp = ! empty ( $perms ['access_admin_panel'] );
	
	$auto_join = 0;
	if (empty ( $_SESSION ['rooms'] )) {
		$auto_join = $x7->config ( 'auto_join' );
	}
	
	$x7->display ( 'pages/chat', array (
			'room_id' => $room_id,
			'message_id' => $message_id,
			'open_room_name' => $open_room_name,
			'user' => $user->data (),
			'settings' => $user->get_settings (),
			'access_acp' => $access_acp,
			'auto_join' => $auto_join,
			'filters' => $filters 
	) );
} 