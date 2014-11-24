<?php
/*
 * @author hunoglumurat 1-ÞÝRKET KURMA Þirket kurmak için: - Çeri kaydý yapmýþ olmak. -	 En az er rütbesinde olmak. -	 Sisteme giriþ yapmýþ olmak gereklidir. Bunlarýn kontrolünün yapýldýðý sayfalar: admin_edit_room.php, edit_room.php Rütbelerin bulunduðu tablo: groups Kontrol kriteri: Yeni bir oda yaratabilme yetkisi için create_room deðerinin 1 olmasý gerekirken, hâlihazýrda var olan odanýn bilgilerini düzenleme yetkisi 'access_edit_room' deðerinin 1 olmasý gerekmektedir.
 */
 
$x7->load ( 'user' );
$x7->load ( 'admin' );

$db = $x7->db ();

if (empty ( $_SESSION ['user_id'] )) {
	$x7->fatal_error ( $x7->lang ( 'login_required' ) );
}

$user = new x7_user ();
$perms = $user->permissions ();

$page = array ();
$page_id= isset ( $_GET ['page_id'] ) ? $_GET ['page_id'] : 0;


if ($page_id) {

$sql = "
		SELECT
	 
		FROM {$x7->dbprefix}pages page
	 
		WHERE
			page.id = :page_id
	";
	
	$st = $db->prepare ( $sql );
	$st->execute ( array (
			':page_id' => $page_id 
	) );
	$room = $st->fetch ();
	$st->closeCursor ();
}

if (! $page && $page_id) // If there is room_id but no room related to the id.
{
	$x7->set_message ( $x7->lang ( 'page_not_found' ) );
} else if ($page && $page_id) { // If there are both room_id and a room related to id.
	$page_perms = $user->pageAuthorityTypes ( $page_id );
	if (empty ( $page_perms ['access_edit_page'] ) && empty ( $perms ['access_admin_panel'] )) { // If the user neither has edit access nor admin access.
		
		$x7->fatal_error ( $x7->lang ( 'access_denied' ) );
	}
}

$vars = $x7->get_vars ();
if (! empty ( $vars ['page'] )) {
	$page = array_merge ( $page, $vars ['page'] );
}

$x7->display ( 'pages/admin/setpage', array (
		'page' => $page,
		'hashtags' =>	$hashtags
 ) );