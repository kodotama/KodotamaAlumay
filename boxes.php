  <?php
              $x7->display("layout/header"); 

 ?>
 
 <script type="text/javascript" src="./scripts/jquery.ddslick.js"></script> 
 <link href='http://fonts.googleapis.com/css?family=Gilda+Display' rel='stylesheet' type='text/css'></link>
 
 <?php

 
 
  if(!$_SESSION["langFile"]){
 
 		$langFile=substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		 
		 if(empty($langFile))
		 	$_SESSION["langFile"]="en-us";
		 } 
		 
 ?>

  
    <script type="text/javascript">
      $(document).ready(function() {
          	langFile= "<?php echo	$x7->langFile  ?>";
        	if(langFile=="")
        		langFile="en-us";
      	        RoomConstruction.getLanguages(langFile);
        	  
       
        });
    </script>

 
<style>
<!--
li {list-style: none;}
#register_button
 {
	 
	padding-left: 10px;
	 
 }
#login_menu
 {
	width:200px;
	margin:0px auto;
	text-align:left;
	padding-top:5px;
 	padding-left:5px;
 	padding-right:5px;
 	background-color:#eee;
 }
#logout_menu
 {
	width:30px;
	margin:0px auto;
	text-align:left;
	padding-top:5px;
 	padding-left:5px;
 	padding-right:5px;
 	background-color:#eee;
 }
 
#selectLang {
margin-top:10px;
margin-top:10px;
margin-left:auto;
margin-right:auto;
 
 }
#box-list span { display:inline-block; position:absolute; margin-left: 20px; margin-top: 20px;}

#box-list{
width:260px;
margin-left:auto;
margin-right:auto;
margin-top:20px;
height: 500px
}
#loc-list ul{
 
	display: block;
 	list-style: none;
    padding: 0;
}

#box-list .list-label{
 	margin: 10px 0 0 6px;
	padding: 2px 3px;
	width: 17px;
	text-align: center;
	background: #451400;
	color: #fff;
	font-weight: bold;
}

#box-list .list-details{
 	margin-left: 6px;
	width: 165px;
}

#box-list .list-content{
	padding: 10px;
}

#box-list .loc-dist{
	font-weight: bold;
	font-style: italic;
	color: #8e8e8e;
}

.liBoxes{
	font-family: 'Gilda Display', serif;
	font-size:large;
	font-weight:bold;
	color:rgba(7,64,73,0.7);
	box-shadow: 0 0 8px rgba(82,168,236,0.7);
	display: block;
	clear: left;
	float: left;
	margin: 6px 8px;
	cursor: pointer;
	width: 210px;
	height: 80px;
	border: 1px solid #fff; /* Adding this to prevent moving li elements when adding the list-focus class*/
}

#box-list .list-focus{
	border: 1px solid rgba(82,168,236,0.9);
	-moz-box-shadow: 0 0 8px rgba(82,168,236,0.7);
	-webkit-box-shadow: 0 0 8px rgba(82,168,236,0.7);
	box-shadow: 0 0 8px rgba(82,168,236,0.7);
	transition: border 0.2s linear 0s, box-shadow 0.2s linear 0s;
}



-->
</style>

<script>

function goToLink(strLink){
	window.location=	window.location.origin+strLink;
}
 </script>
</head>
<body>
	
<span id="msgModal"></span>
 

  <select id="selectLang">
    
  </select>
 
         
    <div id="registerPart"  style="display: none;">
    		<p><?php echo  $x7->lang('register_instructions'); ?></p>
					<form action="<?php  echo  $x7->url('doregister'); ?>" method="post">
					 <ul>
					  	<li>
					  	 <br/>
					  	<input
							type="text" name="username" id="username"
							  
							placeholder="<?php  echo  $x7->lang('username_label'); ?>"
							/>
					  	</li>
					  	
					  	<li>
				 
					  	 <br/>
						<input type="text" name="email" id="email"
							placeholder="<?php echo  $x7->lang('email_label'); ?>"
							/>
					  	</li>
					 
					  	<li>
					 
					  	 <br/>
						<input type="password" name="password" id="password" value="" 
							placeholder="<?php  echo  $x7->lang('password_label'); ?>"
						/> 
					  	</li>
					   
					   <li>
					    
					 
							<br/>
							 <input
							type="password" name="repassword" id="repassword" value="" 
								placeholder="<?php  echo  $x7->lang('retype_password_label'); ?>"
							/>
					   
					   </li>
					   
					   <li>
					   <input
								type="submit" id="register_button" name="register_button"
								value="<?php  echo  $x7->lang('register_button'); ?>" 
								 
								/> 
							
 					   </li>
					 </ul>
					 
					</form>
     
        </div>
    
  <?php  $x7->display('layout/footer',  array()); ?>
        