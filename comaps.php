 <?php
 
 $x7->display("layout/header"); 

 ?>
 <div id="store-locator-container">
    <div id="map-container">
        <div id="loc-list">
            <ul id="list"></ul>
        </div>
              <div id="form-container">
        <form id="user-location" method="post" action="#">
            <div id="form-input">
               
      			<ul>
                 <li>
                 <input type="text" id="address"  name="address" placeholder="<?php echo  $x7->lang('address_or_zip');?>"  />
                 <br/>
                  <button type="button"  id="buttonSearch" onclick="searchForComp();"  style= "padding:5px 0px 5px; margin-left: 10px; margin-top: 2px">
                  <?php echo  $x7->lang('search_for_company');?>
                  </button>
                 </li>
 
				</ul>
             </div>
        
        
      </form>
      </div>
			
			
        
        <div id="map"></div>
      </div>

      
      </div>
   
     <script src="js/handlebars-1.0.0.min.js"></script>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyBSektaEH2ANfxrV_9mgXzrQX6Omjl2y1I&sensor=false"></script>
    <script src="js/jquery.storelocator.js"></script>
      <script>
        function searchForComp(){
			address=$("#address").val();
            
         	if(address==""){
         		 $('#msgModal').text("<?php echo  $x7->lang('enter_req_info');?>");
         		 $('#msgModal').dialog();
         	     return false;
         		}else {
        			 $('#buttonSearch').submit(); 			
         			}
            }
   
        $(function() {
          $('#map-container').storeLocator({'dataType': 'json', 'dataLocation': '/pages/get_locations.php'});
        });
       function setUpCompany()
		{
      		
    	   <?php	$token = isset ($_SESSION ['token']) ? $_SESSION ['token']: 0;?>
            token="<?php	echo $token; ?>";
            userId="<?php echo  $_SESSION["user_id"]; ?>";
            if(!userId){
            	showLoginModal();
             }

			address=$("#addressTemplate").val();
            lat=$("#lat").val();
			lng=$("#lng").val();
			alert(address);
            companyName=$("#companyNameTemplate").val();
        	alert(companyName);
    		if(address=="" || companyName==""){
			 $('#msgModal').text("<?php echo  $x7->lang('enter_req_info');?>");
			 $('#msgModal').dialog();
				
			}else {
				RoomConstruction.setUpCompany(companyName, address, lat, lng, token, userId);
				
				}


		    
			
		};
	function openPageURL(pageName, extraStr)
		{ 
			window.location= window.location.origin="/?page="+pageName+extraStr;

			  
		};
	
$(document).ready(function() {
       		
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
      </script>
     
  <?php  $x7->display('layout/footer',  array()); ?>
 