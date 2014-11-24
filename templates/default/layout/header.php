<?php 
$placeHolderCompany=  $x7->lang('companyname');  
$setUpCompanyButtonLabel= $x7->lang('set_up_company'); 
$info_setting_comp= $x7->lang('info_setting_comp');
$telNoTemplate=$x7->lang('tel_no');
$webTemplate=$x7->lang('web_address');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="fb:app_id" content="736752569682374"></meta>
<meta property="fb:admins" content="100001389600297"></meta>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="./scripts/jquery.share.js"></script>
<script src="scripts/jquery.ui.position.js"></script>
<script src="scripts/jquery.ui.core.js"></script>
<script src="./scripts/jquery.ui.widget.js"></script>
<script src="scripts/jquery.ui.datepicker.js"></script>
<script src="scripts/jquery-ui-timepicker-addon.js"></script>
<script src="./scripts/jquery.editable.js"></script>
<script src="scripts/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="scripts/ko.js"></script>
<script type="text/javascript" src="scripts/joinroom.js"></script>
<script type="text/javascript" src="scripts/objeboxscr.js"></script>
<script type="text/javascript" src="./scripts/UtilJS.js"></script>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="./scripts/jquery.share.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/map.css" />
 
 

<script>
var placeHolderCompany=  "";
var setUpCompanyButtonLabel="";




 $(document).ready(function () {
       placeHolderCompany=  "<?php echo  $placeHolderCompany ?>";
	   setUpCompanyButtonLabel="<?php echo $setUpCompanyButtonLabel   ?>";
	   info_setting_comp="<?php echo $info_setting_comp ?>";
	   telNoTemplate="<?php echo $telNoTemplate?>";
	   webTemplate="<?php echo $webTemplate?>";
	   
	   $("#logout_menu").bind('click', function() {
	   		window.location = '<?php echo $x7->url('logout'); ?>';
	   	});

	   	$("#admin_create_room_button").bind('click', function() {
	   		openPageURL("chat", "&open_content_area=admin_edit_room");
			}); 
			$("#setpage_button").bind('click', function() {
				openPageURL("chat", "&open_content_area=admin_edit_page");
			}); 
			$("#chatrooms_menu").bind('click', function() {
				openPageURL("chat", "&open_content_area=roomlist");
			});
			
			$("#admin_menu").bind('click', function() {
				openPageURL("chat","&open_content_area=admin_news");
			});
			
			$("#settings_menu").bind('click', function() {
				openPageURL("chat", "&open_content_area=settings");
			});
 
	});
	function openPageURL(pageName, extraStr)
	{ 
		window.location= window.location.origin="/?page="+pageName+extraStr;

		  
	};
 function showLoginModal() {
		$("#form-login").show();
	    $("#form-login").dialog();
	    return false;
	  };
	function regTest(){
	    userId= "<?php echo $_SESSION["user_id"]?>";
	    if(userId=="")
	    {
	   	 window.location=window.location.origin+"?page=register";
	        
	   
	    }else{
	            
	        UtilJS.showMessages('error', "Log-out!",-1);
	       
	        
	        return false;
	    }
	};
	
function login()
	{
	 email=$("#email").val();
    password=$("#password").val();
    isAjax=1;
	 RoomConstruction.login(email, password, isAjax);
     };


</script> 


 
<link rel="stylesheet" type="text/css"
	href="themes/<?php echo $x7->config('theme'); ?>/style.css" />
<link rel="stylesheet" href="css/prettyPhoto.css" type="text/css"
	media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<link rel="stylesheet" href="css/ui-lightness/jquery.ui.all.css">

</head>
<body>
 <span id="msgModal"></span>
<span id="loginMsg"></span>
 	<div id="form-login" style="display: none;">
 	           
               <ul>
	                 <li>
	                 <input type="text" id="email"  name="email" placeholder="<?php echo  $x7->lang('email_label');?>"  />
	          
	                 </li>
	                 <li>
	                 <input type="password" id="password" placeholder="<?php echo  $x7->lang('password_label');?>" >
	                 <br/>
				     <button  id="button"  onclick="login()" style= "padding:5px 0px 5px; margin-left: 10px; margin-top: 2px;">
	                  <?php echo  $x7->lang('login_button');?>
	                  </button>
	                 </li>
        
				</ul>
    </div>
	
	
	<div id="page_wrapper">
		<div id="page_header" class="wrap">
			<div id="header_inner">
				<div id="page_logo">
						<?php $esc($x7->config('title')); ?>
					</div>
 				<div id="header_menu">
					<ul>
					<li id="reg_button">
					 
					 	 	<a href="#" id="register_button" onclick="javascript:regTest();" style="color: blue"><?php $lang('register_button'); ?></a>
					
					</li>
					
							<?php if(!empty($_SESSION['user_id'])): ?>
						<li id="setpage_button" style="display: none"><a href="#"><?php $lang('setpage_button'); ?></a></li>
						    <?php  if(empty($_SESSION['is_guest'])): ?>
								<li id="admin_create_room_button"><a href="#"><?php $lang('admin_rooms_button'); ?></a></li>
							<?php endif; ?>
						<li id="chatrooms_menu"><a href="#"><?php $lang('chatrooms_menu'); ?></a></li>
						<li id="settings_menu"><a href="#"><?php $lang('settings_menu'); ?></a></li>
								<?php if(isset($access_acp) && !empty($access_acp)): ?>
									<li id="admin_menu"><a href="#"><?php $lang("admin_control_panel_button"); ?></a></li>
								<?php endif; ?>
								<li id="liUserName"><a href="#"><?php echo $_SESSION["user_name"] ?></a></li>
							 	<li id="logout_menu"><a href="#"><?php $lang('logout_menu'); ?></a></li>
							<?php else: ?>
								<li id="login_menu"><a href="#" onclick="showLoginModal();"><?php $lang('login_button'); ?></a></li>
							<?php endif; ?>
						</ul>
				</div>
				<div style="clear: both;"></div>
			</div>
		</div>
		<div id="page_content">
			<div id="page_content_inner">
				<div class="wrap">
						<?php $display('layout/messages'); ?>