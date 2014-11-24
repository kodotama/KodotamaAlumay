<?php
/*
 * @author hunoglumurat roomAuthorityTypes() is used to list this user's access on certain rooms. If user is an admin, it lists all the rooms; if not, just lists the editable rooms for this user.
 */
$x7->load ( 'user' );
$x7->load ( 'admin' );

$db = $x7->db ();

if (empty ( $_SESSION ['user_id'] )) {
	$x7->fatal_error ( $x7->lang ( 'login_required' ) );
}

$user = new x7_user ();
$perms = $user->permissions ();
$room_id = isset ( $_POST ['room_id'] ) ? $_POST ['room_id'] : 0;
$room_perms = $user->roomAuthorityTypes ( $room_id );

if ($room_id && empty ( $room_perms ['access_edit_room'] ) && empty ( $perms ['access_admin_panel'] )) {
	
	$x7->fatal_error ( $x7->lang ( 'access_denied' ) );
}

$per_page = 10;
$page = 1;
if (isset ( $_GET ['page'] ) && ( int ) $_GET ['page'] >= 1) {
	$page = ( int ) $_GET ['page'];
}

$isAdmin = ! empty ( $perms ['access_admin_panel'] );

if ($isAdmin) { // If the user is an admin.
	$sql = "
		SELECT
		COUNT(*) as num
		FROM {$x7->dbprefix}rooms
		";
} else { // If the user has her own rooms.
	$sql = "
		SELECT
		COUNT(rooms.id) as num
		FROM  {$x7->dbprefix}room_author as author 
		INNER JOIN {$x7->dbprefix}rooms as rooms ON
	 
		    author.room_id = rooms.id 
		AND author.user_id = :user_id
		
		";
}

$st = $db->prepare ( $sql );

$id = $user->id ();
if (! $isAdmin)
	$st->execute ( array (
			':user_id' => $id 
	) );
$st->execute ();

$count = $st->fetch ();

$st->closeCursor ();

$pages = ceil ( $count ['num'] / $per_page );

if (! empty ( $perms ['access_admin_panel'] )) {
	
	$sql = "
		SELECT
			*
		FROM {$x7->dbprefix}rooms 
	";
} else {
	$sql = "
		SELECT
		*
		FROM  {$x7->dbprefix}room_author as author
			INNER JOIN {$x7->dbprefix}rooms as rooms ON
	
			author.room_id = rooms.id
			AND author.user_id = :user_id
		";
}

$st = $db->prepare ( $sql );
$user = new x7_user ();
$id = $user->id ();
if (! $isAdmin)
	$st->execute ( array (
			':user_id' => $id 
	) );
$st->execute ();
$rooms = $st->fetchAll ();

$pages = 5;

$x7->display ( 'pages/admin/rooms', array (
		'rooms' => $rooms,
		'paginator' => array (
				'per_page' => $per_page,
				'pages' => $pages,
				'page' => $page,
				'action' => 'admin_rooms' 
		),
		'menu' => generate_admin_menu ( 'list_rooms' ) 
) );