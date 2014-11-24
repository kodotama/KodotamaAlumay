 <?php
 
 $x7->display("layout/header"); 
 if(!$_SESSION["langFile"]){
 
 	$langFile=substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
 		
 	if(empty($langFile))
 		$_SESSION["langFile"]="en-us";
 }
 ?> 
    
<script>
$(document).ready(function() {
  	langFile= "<?php echo	$x7->langFile  ?>";
	if(langFile=="")
		langFile="en-us";
	        RoomConstruction.getLanguages(langFile);
	  

});
function goToLink(strLink){
	window.location=	window.location.origin+strLink;
}
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
 <script type="text/javascript" src="./scripts/jquery.ddslick.js"></script> 
 <link href='http://fonts.googleapis.com/css?family=Gilda+Display' rel='stylesheet' type='text/css'></link>
 
    
 <select id="selectLang">
    
  </select>
<div id="box-list">
            <ul id="list"> 

				            
				<li class="liBoxes" data-markerid="0" style="background-color: rgb(255, 255, 255); background-position: initial initial; background-repeat: initial initial;">
				 	<div class="list-details">
						<div class="list-content">
							<div class="loc-name">
							 <img  src="images/boxes/company.png"/>
							 <span onclick="goToLink('/index.php?page=comaps')"><?php echo $x7->lang( 'company'); ?></span>
							</div> 
						
						 </div>
					</div>
				</li>
				 
				
				<li class="liBoxes" data-markerid="1" style="background-color: rgb(238, 238, 238); background-position: initial initial; background-repeat: initial initial;">
				 	<div class="list-details">
						<div class="list-content">
							<div class="loc-name">
							<img  src="images/boxes/mission.png"/>
							<span onclick="goToLink('/index.php?page=chat&usage_type_id=1')"><?php echo $x7->lang( 'mission'); ?></span>
							</div>
				        </div>
					</div>
				</li>
				 
				
				<li class="liBoxes" data-markerid="2" style="background-color: rgb(255, 255, 255); background-position: initial initial; background-repeat: initial initial;">
				 	<div class="list-details">
						<div class="list-content">
							<div class="loc-name">
							<img  src="images/boxes/dictionary.png"/>
							<span  onclick="goToLink('/index.php?page=chat&usage_type_id=2')"><?php echo $x7->lang( 'dictionary'); ?></span>
							</div>
						 	
						</div>
					</div>
				</li>
				 
				
				<li class="liBoxes" data-markerid="3" style="background-color: rgb(238, 238, 238); background-position: initial initial; background-repeat: initial initial;">
				 	<div class="list-details">
						<div class="list-content">
							<div class="loc-name">
							<img  src="images/boxes/chat.png"/>
							<span  onclick="goToLink('/index.php?page=chat&usage_type_id=3')"><?php echo $x7->lang( 'ircchat'); ?></span>
							</div>
				 	 	 
				 	 
							
						</div>
					</div>
				</li>
				 
				
				<li class="liBoxes" data-markerid="4" style="background-color: rgb(255, 255, 255); background-position: initial initial; background-repeat: initial initial;">
				 	<div class="list-details">
						<div class="list-content">
							<div class="loc-name">
							 <img  src="images/boxes/blog.png"/>
							 <span  onclick="goToLink('/index.php?page=chat&usage_type_id=4')"><?php echo  $x7->lang( 'personal'); ?></span>
							</div>
				 		 	
						</div>
					</div>
				</li>
				 
				
</ul>


        </div>  
 
 
 
 
<?php  $x7->display('layout/footer',  array()); ?>
 