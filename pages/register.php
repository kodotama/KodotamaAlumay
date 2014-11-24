<?php if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]!=""){
	echo "<script>window.location = window.location.origin+'/?page=logout';</script>";
 }else {
 	$x7->display ( 'pages/register' );
} 
?>