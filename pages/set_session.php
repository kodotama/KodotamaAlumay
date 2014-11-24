<?php
 
  $langFile= isset ( $_POST ['langFile'] ) ? $_POST ['langFile'] : 0;
  
  if(session_id() == '') {
  	session_start();
  }
  
  $_SESSION["langFile"]=$langFile;
  
  
  $info= $langFile;
 
  if (isset ( $info )) $output ["info"] = $info;
  echo json_encode ( $output ); // output JSON data

 