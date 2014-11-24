<?php
/*
 * @author hunoglumurat 1-��RKET KURMA �irket kurmak i�in: - �eri kayd� yapm�� olmak. -	 En az er r�tbesinde olmak. -	 Sisteme giri� yapm�� olmak gereklidir. Bunlar�n kontrol�n�n yap�ld��� sayfalar: admin_edit_room.php, edit_room.php R�tbelerin bulundu�u tablo: groups Kontrol kriteri: Yeni bir oda yaratabilme yetkisi i�in create_room de�erinin 1 olmas� gerekirken, h�lihaz�rda var olan odan�n bilgilerini d�zenleme yetkisi 'access_edit_room' de�erinin 1 olmas� gerekmektedir.
 */
 
$x7->load ( 'user' );
$x7->load ( 'admin' );

$db = $x7->db ();

if (empty ( $_SESSION ['user_id'] )) {
	$x7->fatal_error ( $x7->lang ( 'login_required' ) );
}

$user = new x7_user ();
$perms = $user->permissions ();

$room = array ();
$room_id = isset ( $_GET ['room_id'] ) ? $_GET ['room_id'] : 0;

if ($room_id) {

$sql = "
		SELECT
			room.*, usage_text, usage_deadline
		FROM {$x7->dbprefix}rooms room
		LEFT JOIN {$x7->dbprefix}room_usage room_usage
		ON room.id=room_usage.room_id
		WHERE
			room.id = :room_id
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

$vars = $x7->get_vars ();
if (! empty ( $vars ['room'] )) {
	$room = array_merge ( $room, $vars ['room'] );
}

$x7->display ( 'pages/admin/edit_room', array (
		'room' => $room,
		'menu' => generate_admin_menu ( $room_id ? 'edit_room' : 'create_room' ) 
) );