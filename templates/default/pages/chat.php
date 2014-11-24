<?php

/**
 * 
 */

$display ( 'layout/header' );
$root = realpath ( $_SERVER ["DOCUMENT_ROOT"] );
require_once $root . '/includes/Util.php';
Util::startSession ();
$is_guest=isset ( $_SESSION["is_guest"] ) ? $_SESSION["is_guest"] : "";

if(!isset($open_room_name))
$open_room_name=isset ( $_GET["open_room_name"] ) ? $_GET["open_room_name"] : "";
if(!isset($usage_type_id))
$usage_type_id=isset ( $_GET["usage_type_id"] ) ? $_GET["usage_type_id"] : "";
$open_content_area=isset ( $_GET["open_content_area"] ) ? $_GET["open_content_area"] : "";


?>

<link rel="stylesheet" href="./css/styles.css">
 <style type="text/css">
<!--
.messageInput {
	margin: 0px;
	width: 558px;
	height: 89px;
	resize: none;
}

 
.extracted_thumb {
	float: left;
	margin-right: 10px;
}

#loading_indicator {
	position: absolute;
	margin-left: 480px;
	margin-top: 8px;
	display: none;
}

#results {
	display: none;
}

a:link {
	color: #0066CC;
}
.classMsgButtons  {
 	width:50px;
	padding: 0px 0px;
}


.thumb_sel {
	float: left;
	height: 22px;
	width: 55px;
}

.thumb_sel .prev_thumb {
	background: url(images/thumb_selection.gif) no-repeat -50px 0px;
	float: left;
	width: 26px;
	height: 22px;
	cursor: hand;
	cursor: pointer;
}

.thumb_sel .prev_thumb:hover {
	background: url(images/thumb_selection.gif) no-repeat 0px 0px;
}

.thumb_sel .next_thumb {
	background: url(images/thumb_selection.gif) no-repeat -76px 0px;
	float: left;
	width: 24px;
	height: 22px;
	cursor: hand;
	cursor: pointer;
}

.thumb_sel .next_thumb:hover {
	background: url(images/thumb_selection.gif) no-repeat -26px 0px;
}

.small_text {
	font-size: 10px;
}
-->
</style>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


<script type="text/javascript">
		function htmlEncode(dbValue){
		    if (dbValue) {

				dbValue= dbValue.replace(/<i\s/g,'[i ');
				dbValue= dbValue.replace(/<v\s/g,'[v ');
				dbValue= dbValue.replace(/<c\s/g,'[c ');
				dbValue= dbValue.replace(/><\/i>/g,'][/i] ');
				dbValue= dbValue.replace(/><\/v>/g,'][/v]');
				dbValue= dbValue.replace(/><\/c>/g,'][/c]');
			 	dbValue=dbValue.replace(/<compa>/g,"[compa]");
				dbValue= dbValue.replace(/<compa>/g,"[compa]");
				dbValue= dbValue.replace( /<miss>/g,"[miss]");
				dbValue= dbValue.replace( /<dict>/g,"[dict]");
		        dbValue= dbValue.replace( /<hash>/g,"[hash]");
				dbValue= dbValue.replace(/<pblog>/g,"[pblog]");
				dbValue= dbValue.replace(/<\/compa>/g, "[/compa]");
				dbValue= dbValue.replace( /<\/miss>/g, "[/miss]");
				dbValue= dbValue.replace( /<\/dict>/g, "[/dict]");
		        dbValue= dbValue.replace( /<\/hash>/g, "[/hash]");
				dbValue= dbValue.replace(/<\/pblog>/g, "[/pblog]");		 

                 // Warning. We use Jquery Html Encode.
			    dbValue = jQuery('<div />').text(dbValue).html();


				return htmlDecode(dbValue);
		    } else {
		        return '';
		    }
		}

		function htmlDecode(renderValue) {
			  if (renderValue) {
				renderValue=renderValue.replace(/\[i\s/g,'<i ' );
		        renderValue=renderValue.replace(/\[v\s/g,'<v ');
		        renderValue=renderValue.replace(/\[c\s/g,'<c ');
		        renderValue=renderValue.replace(/]\[\/i]/g,'></i>');
		        renderValue=renderValue.replace(/]\[\/v]/g,'></v>');
		        renderValue=renderValue.replace(/]\[\/c]/g,'></c>');
		        renderValue= renderValue.replace(/\[compa]/g, "<compa>");
		        renderValue= renderValue.replace(/\[miss]/g, "<miss>");
		        renderValue= renderValue.replace(/\[dict]/g, "<dict>");
		        renderValue= renderValue.replace(/\[hash]/g, "<hash>");
		        renderValue= renderValue.replace(/\[pblog]/g, "<pblog>");
		        renderValue= renderValue.replace(/\[\/compa]/g, "</compa>");
		        renderValue= renderValue.replace(/\[\/miss]/g, "</miss>");
		        renderValue= renderValue.replace(/\[\/dict]/g, "</dict>");
		        renderValue= renderValue.replace(/\[\/hash]/g, "</hash>");
		        renderValue= renderValue.replace(/\[\/pblog]/g, "</pblog>");
		  
		        return renderValue ;
		    } else {
		        return '';
		    }
		}

		var App = new function()
		{
			var app = this;
			this.open_content_area = "<?php echo $open_content_area; ?>";
			this.usage_type_id="<?php echo $usage_type_id?>";
			this.open_room_name="<?php echo $open_room_name ?>";
			this.settings = <?php echo json_encode($settings); ?>;
			this.filters = <?php echo json_encode($filters); ?>;
			 
			this.content="";
        	this.activeRoomMinute = new Array();
			this.startTime =new Array();

			this.intervalArray =new Array();
		    this.anonymFuncArray=new Array();
			
			
		 
	       anonymFunc=function(roomId){
	                
					 if(app.activeRoomMinute[app.active_room().id]==0){
			        		$('#globalTextArea').attr("disabled", false);
						   	$('#globalTextArea').val("yaz");
					        clearInterval(app.intervalArray[app.active_room().id]);
					        return;
					    } 
						
		                   // time pass with same value for all room which started interval
		                     // $.each(app.activeRoomMinute, function( index, value ){
		                    	     
		                    //	});
		                     
	 						  if(!UtilJS.isNaN(app.activeRoomMinute[app.active_room().id])){
		                    	     app.activeRoomMinute[roomId]--;
			 					     $('#globalTextArea').attr("disabled", "disabled");
		 							  $('#spanCounter').text(app.activeRoomMinute[app.active_room().id]);
						  		} else{
						  			 $('#spanCounter').text();
				 					 $('#globalTextArea').attr("disabled", false);
												  
						  }
					  
	                 };

 
			
			function startAntiFlood(roomId)
	            
	            {


			        app.activeRoomMinute[roomId]=60;
			        app.startTime[roomId]= new Date().getTime();
			        app.anonymFuncArray[roomId]  =function(roomId){anonymFunc(roomId);};
 			 		app.intervalArray[roomId]= setInterval(function(){  app.anonymFuncArray[roomId](roomId); }, 1000);
	            }
				
            
			this.Room = function(room)
			{
				 
				this.id = room.id;			
				this.type = room.type;
				this.name = room.name;
				this.usage_text=room.usage_text;
				this.messageCount=room.messageCount;
				this.usageTypeText=room.usageTypeText;
				this.currentMsgCountInit=room.currentMsgCountInit;
				this.usage_type_id=room.usage_type_id;
				this.usage_deadline=room.usage_deadline;
			    this.messages = ko.observableArray();
				this.users = ko.observableArray();
				this.alert = ko.observable(0);
				
			}
			
			this.UserRoom = function(user)
			{
				this.user_id = user.user_id;
				this.room_id = user.room_id;
				this.user_name = user.user_name;
				this.refreshed = 1;
			}
			
			this.Message = function(message)
			{
				var dt = new Date();
				dt.setTime((parseInt(message.timestamp))*1000);
				
				var ampm = '';
				ampm = ' am';
				var hours = dt.getHours();
				if(hours >= 12)
				{
					ampm = ' pm';
				}
				
				if(!app.settings.ts_24_hour || app.settings.use_default_timestamp_settings)
				{
					if(hours > 12)
					{
						hours -= 12;
					}
					if(hours == 0)
					{
						hours = 12;
					}
				}
				
				if(!app.settings.ts_show_ampm && !app.settings.use_default_timestamp_settings)
				{
					ampm = '';
				}
				
				var minutes = ''+dt.getMinutes();
				if(minutes.length < 2)
				{
					minutes = '0' + minutes;
				}
				
				var seconds = ''+dt.getSeconds();
				if(seconds.length < 2)
				{
					seconds = '0' + seconds;
				}
				
				if(app.settings.enable_timestamps || app.settings.use_default_timestamp_settings)
				{
					this.timestamp = hours + ":" + minutes;
					if(app.settings.ts_show_seconds)
					{
						this.timestamp += ":" + seconds;
					}
					this.timestamp += ampm;
				}
				else
				{
					this.timestamp = '';
				}
				this.id=message.id;
				this.source_type = message.source_type;
				this.source_id = message.source_id;
				this.source_name = message.source_name;
				this.dest_type = message.dest_type;
				this.dest_id = message.dest_id;
				this.hashtag_room_id=message.hashtag_room_id;
				this.raw_message = message.message;
              //TODO "message" at righ side is database object 
				this.room_id=message.dest_id;
				this.user_id=message.source_id;
                
				this.font_size = '';
				if(!app.settings.enable_styles)
				{
					this.font_size = app.settings.message_font_size;
				}
				else if(message.font_size)
				{
					this.font_size = message.font_size;
				}
				
				this.font_face = '';
				if(!app.settings.enable_styles)
				{
					this.font_face = app.settings.message_font_face;
				}
				else if(message.font_face)
				{
					this.font_face = message.font_face;
				}
				
				this.font_color = '';
				if(!app.settings.enable_styles)
				{
					this.font_color = app.settings.message_font_color;
				}
				else if(message.font_color)
				{
					this.font_color = message.font_color;
				}
				
				var filtered_message = message.message;
				for(var key in app.filters)
				{
					var filter = app.filters[key];
					var find = filter.word.replace(/([.*+?^=!:${}()|[\]\/\\])/g, "\\$1");
					
					var repl = filter.replacement;
					if(!repl.length)
					{
						for(var len = 0; len < filter.word.length; len++)
						{
							repl += '*';
						}
					}
					
					if(filter.whole_word_only == "1")
					{
						find = "\\b" + find + "\\b";
					}
					
					var reg = new RegExp(find, "i");
					filtered_message = filtered_message.replace(reg, repl);
				}
				
				this.message = filtered_message;
			}
			
			this.add_room = function(room)
			{
  				app.rooms.push(room);
				app.room_count(app.rooms().length);
			}
			
			this.get_room = function(id, type)
			{
				var rooms = app.rooms();
				for(var key in rooms)
				{
					if(rooms[key].id == id && rooms[key].type == type)
					{
						return rooms[key];
					}
				}
				
				return 0;
			}
			this.get_room_by_name = function(name, type, usageTypeId)
			{
				var rooms = app.rooms();
				for(var key in rooms)
				{
					var nameStr=rooms[key].name.toLowerCase() ;
					var typeStr=rooms[key].type;
					var usageTypeStr=rooms[key].usage_type_id;
					
					if(nameStr == name.toLowerCase()  && typeStr == type && usageTypeStr ==usageTypeId )
					{
						return rooms[key];
					}
				}
				
				return 0;
			}

			/// Append Meta tags
			function setMT(metaName, name, value) {
			        var t = 'meta['+metaName+'="'+name+'"]';
			        var mt = $(t);
			        if (mt.length === 0) {
			            t = '<meta '+metaName+'="'+name+'" />';
			            mt = $(t).appendTo('head');
			        }
			        mt.attr('content', value);
			    }
			
			this.set_active_room = function(room)
			{

				
				document.title=room.name;
				setMT('property', "og:title", room.name);
				setMT('property', "og:type", "website");
				setMT('property', "og:description", "deneme");
				setMT('property',"og:site_name","www.alumay.com");
				setMT('property',"og:locale","tr_TR" );
				setMT('property',"og:image","http://www.gercekedebiyat.com/ckfinder/userfiles/images/od%20ana.jpg");
						
						
				
				app.active_room(room);
				$("#active_rooms_area").slideUp('fast');
				app.active_rooms_area_open = false;
				
				$("#message_scroll_wrapper").scrollTop($("#messages").height());
				setTimeout(function() {
					$("#message_scroll_wrapper").scrollTop($("#messages").height());
				}, 100);

			    $("#globalInput").slideDown();
				
			    if(room.usage_type_id==1){
			  		  $("#divToggler").show();  
			  		    }else{
			   		 $("#divToggler").hide();
			   		 $("#usageContent").hide();
			  		   }
			        	
			        	
			        if(room.usage_type_id==0) {
			    		 $("#divToggler").hide();
			    		 $("#divAboutUsToggler").show();
			        	 $("#divContactToggler").show();
			        }else{
			    		    $("#divAboutUsToggler").hide();
			      		    $("#divContactToggler").hide();
			    		    $("#contactContent").hide();
			    		    $("#aboutUsContent").hide();

			      		  }
			        

							
		}
			
			this.sync_room_users = function(data)
			{
				var rooms = app.rooms();
				for(var key in rooms)
				{
					for(var rkey in rooms[key].users())
					{
						var user = rooms[key].users()[rkey];
						user.refreshed = 0;
					}
				}
			
				var modified_rooms = [];
				for(var key in data)
				{
					var user_room = new App.UserRoom(data[key]);
					var room = app.get_room(user_room.room_id, 'room');
					if(room)
					{
						var user = 0;
						for(var rkey in room.users())
						{
							if(room.users()[rkey].user_id == user_room.user_id)
							{
								user = room.users()[rkey];
							}
						}
						
						if($.inArray(room.id, modified_rooms) == -1)
						{
							modified_rooms.push(room.id);
						}
						
						if(user)
						{
							user.refreshed = 1;
						}
						else
						{
							app.add_user_room(user_room);
						}
					}
				}
				
				for(var key in modified_rooms)
				{
					var room = app.get_room(modified_rooms[key], 'room');
					if(room)
					{
						for(var rkey in room.users())
						{
							var user = room.users()[rkey];
							if(!user.refreshed)
							{
								room.users.remove(user);
								
								var dt = new Date();
								var utc = Math.round(dt.getTime()/1000);
								
								var message = new App.Message({
									timestamp: utc,
									source_type: 'system',
									source_name: '',
									source_id: '0',
									dest_type: rooms[key].type, 
									dest_id: rooms[key].id, 
									message: <?php echo json_encode($x7->lang('leave_message')); ?>.replace(':user', user.user_name)
								});
								
								app.add_message(message);
							}
						}
					}
				}
			};
			
			this.add_user_room = function(user_room, supress_join_message)
			{
				var room = app.get_room(user_room.room_id, 'room');
				if(room)
				{
					room.users.push(user_room);
					
					if(!supress_join_message)
					{
						var dt = new Date();
						var utc = Math.round(dt.getTime()/1000);
						
						var message = new App.Message({
							timestamp: utc,
							source_type: 'system',
							source_name: '',
							source_id: '0',
							dest_type: room.type, 
							dest_id: room.id, 
							message: <?php echo json_encode($x7->lang('join_message')); ?>.replace(':user', user_room.user_name)
						});
						
						app.add_message(message);
					}
				}
			};
			this.add_message = function(message, supress_sounds)
			{


				var do_scroll = false;
				var messages_height = $("#messages").height();
				var messages_scroll = $("#message_scroll_wrapper").scrollTop();
				var message_pane_height = $("#message_scroll_wrapper").height();
				var at_bottom = (messages_height-messages_scroll <= message_pane_height);
				
				var room = 0;
				if(message.dest_type == 'user')
				{
					var check_id = message.dest_id;
					if(check_id == '<?php $esc($user['id']); ?>')
					{
						check_id = message.source_id;
					}
					
					if(message.source_type == 'system')
					{
						room = app.active_room();
					}
					else
					{
						room = app.get_room(check_id, message.dest_type);
					}
				}
				else
				{
					room = app.get_room(message.dest_id, message.dest_type);
				}
				
				if(!room.id)
				{
					if(message.dest_type == 'user' && message.source_type != 'system')
					{
						room = new App.Room({
							id: message.source_id,
							type: 'user',
							name: message.source_name
						});
						
						App.add_room(room);
					}
				}
				
				if(room)
				{
					 room.messages.push(message);
					if(app.active_room() && app.active_room().id == room.id)
						
					{
						
			 			    
					        
						do_scroll = true;
					}
					else
					{
						room.alert(room.alert()+1);
					}
				}
				
				if(do_scroll && at_bottom)
				{
					$("#message_scroll_wrapper").scrollTop($("#messages").height());
				}
				
				// play sounds
				if(app.settings.enable_sounds && !supress_sounds)
				{
					try
					{
						$('#message_sound')[0].play();
					}
					catch(ex)
					{
					}
				}

				 var  currentMsgCountInit=  $("#spanCurrentMsgCount"+room.id).text();
				 var  spanTotalMsgCount= $("#spanTotalMsgCount"+room.id).text();

                  if(currentMsgCountInit!="" && spanTotalMsgCount!=""){
				  currentMsgCountInit++;
				  spanTotalMsgCount++;

	 	            $("#spanCurrentMsgCount"+room.id).text(currentMsgCountInit);
				    $("#spanTotalMsgCount"+room.id).text(spanTotalMsgCount);
    
				    room.currentMsgCountInit=currentMsgCountInit;
				    room.messageCount=spanTotalMsgCount;
                  }
                   
			}

			
			this.send_message = function()
			{ 
  
				 
				is_guest= '<?php echo $is_guest ?>';
				if(is_guest==1){
					u_must_be_user= '<?php $lang('u_must_be_user'); ?>';
					$('#globalTextArea').val(u_must_be_user);
					return false;
					
			}
				
				$("#results").hide();

	          	var dt = new Date();
				var utc = Math.round(dt.getTime()/1000);

	             //Just for easy debugging, I create a new function.  
			    var tempMsg=chooseMsg($('#globalTextArea').val());
			    tempMsg=htmlEncode(tempMsg)
			    tempMsg=tempMsg.replace(/[\r\n]/gm, '<br />');
			    
				var message = new App.Message({
					timestamp: utc,
					source_type: 'user',
					source_name: <?php echo json_encode($x7->esc($user['username'])); ?>,
					source_id: '<?php $esc($user['id']); ?>',
					dest_type: app.active_room().type, 
					dest_id: app.active_room().id, 
					message: tempMsg,
					font_size: app.settings.message_font_size,
					font_color: app.settings.message_font_color,
					font_face: app.settings.message_font_face
				});
 				
				
			 
				$.ajax({
					url: '<?php $url('send'); ?>',
					cache: false,
					type: 'POST',
					dataType: 'json',
					data: {
						dest_type: message.dest_type,
						room: message.dest_id,
						message: message.message
						},
					success: function(data)
					{
						message["id"]= data.insertedId;
						app.add_message(message, 1);

	                    if(app.active_room().usage_type_id!=3 && app.active_room().usage_type_id!=undefined)
						startAntiFlood(message.dest_id);
                      				        
							
					},
					error : function(xhr, ajaxOptions, thrownError) {
						 
						alert('joinroom.js:1:' + xhr.status);
						alert(thrownError);
					}
				});
				 
			    $("#results").html("");
 				$('#globalTextArea').focus();
				$('#globalTextArea').val("");
			};

           
			this.message_key = function(p1, ev)
			{
				var alt_func = (ev.shiftKey || ev.ctrlKey || ev.altKey);
				var enter_key = (13 == ev.keyCode);
				if(enter_key && !alt_func)
				{
					app.send_message();
					return false;
				}
				
				return true;
			};
			
			this.show_rooms = function()
			{
				var top = $("#room_tab_bar").position().top+$("#room_tabs_button").height()+5;
				var left = $("#room_tabs_button").position().left-11;
				
				$("#active_rooms_area").css("top", top);
				$("#active_rooms_area").css("left", left);
				$("#active_rooms_area").slideDown('fast', function() {
					app.active_rooms_area_open = true;
				});
			};

		 

			this.showAll= function(data)
			{
				RoomConstruction.refresh=1;
				RoomConstruction.messageId=0;

				app.leave_room(data);

				$("#divShowPast20Msg").show();
				$("#divShowAll").hide();

 				RoomConstruction.joinRoom(data.id, 0, 0, 0);
				return false;
	
			};
			
			
			this.setEditable= function(data)
			{
				 
				
				 RoomConstruction.getMessage(data.id, data.source_id);
		 
				$("#update"+data.id).show();
			 
			};
			this.setMission= function(data)
			{
				var roomNameStr=App.active_room().name.replace(/\s+/g, '+').toLowerCase();
	               

                open_content_area(window.location.origin+"/?page=admin_edit_room&usageTypeId="+UtilJS.usageTypes["miss"]+"&roomNameStr="+roomNameStr+"-"+data.id)
 		 
 			 
			};

			this.updateMessage= function(data)
			{
				<?php	$token = isset ($_SESSION ['token']) ? $_SESSION ['token']: 0;
				 
				
				?>
				
 				
			RoomConstruction.updateMessage(data.id, $("#tempSpan").text(), "<?php	echo $token?>", data.source_id);
			$("#update"+data.id).hide();
			$("#tempSpan").text('');
			};


			this.deleteMessage= function(data)
			{
				<?php	$token = isset ($_SESSION ['token']) ? $_SESSION ['token']: 0;
		 
				
				?>
				
 				
			RoomConstruction.deleteMessage(data.id,   "<?php echo	$token?>" ,  data.source_id);
			$("#delete"+data.id).hide();
			
		    

            var he=$("#messages").height();
            $("#messages").height(he-$("#messageContainer"+data.id).height());
            $("#messageContainer"+data.id).hide();

			};
			this.showMsgTools= function(data)
			{
				$("#shareButton"+data.id).show();


				is_guest= '<?php echo $is_guest ?>';
				 
			if(App.active_room().usage_type_id==UtilJS.usageTypes["miss"]
			 && "<?php  echo $_SESSION["user_id"]; ?>"!=""
             &&	 (is_guest!=1))
	         	$("#setMission"+data.id).show();

 			 if((data.source_id== "<?php  echo $_SESSION["user_id"]; ?>") ||   ("<?php  echo $_SESSION["user_id"]; ?>"==1) )
				$("#"+data.id).show();

  	  			
				
             
			};

            this.showShareTools=function(data)
            {
    			if(!$("#divShareoneMsg"+data.id).length){
    					$('#oneMsg'+data.id).share({
    					        networks: ['facebook','pinterest','googleplus','twitter','linkedin','tumblr','in1','email','stumbleupon','digg']
    					    });
    			}else{
    				 	$("#divShareoneMsg"+data.id).show();
    						
    					}
            }

            
			
         this.hideMsgTools= function(data)
			{

				$("#shareButton"+data.id).hide();

				$("#setMission"+data.id).hide();
	        	 
		 		$("#"+data.id).hide();
 		 		
			};

			this.show_user_profile = function(data)
			{
				open_content_area('<?php $url('user_room_profile'); ?>' + '&user_id=' + data.user_id + '&room_id=' + data.room_id);
			};
			
			this.leave_room = function(data)
			{
				if(data.type == 'room')
				{
					$.ajax({
						url: '<?php $url('leaveroom'); ?>',
						cache: false,
						type: 'POST',
						dataType: 'json',
						data: {
							room: data.id
						}
					});
				}
				
				var need_switch = false;
				if(app.active_room() && app.active_room().id == data.id)
				{
					need_switch = true;
				}
				
				var rooms = app.rooms();
				for(var key in rooms)
				{
					if(rooms[key].id == data.id)
					{
						app.rooms.remove(rooms[key]);
					}
				}
				
				app.room_count(app.rooms().length);
				
				if(need_switch)
				{
					app.active_room(0);
					
					if(app.rooms().length > 0)
					{
						app.active_room(app.rooms()[0]);
					}
				}
				
				if(app.rooms().length == 0)
				{
					open_content_area('<?php $url('roomlist,-1'); ?>');
				}
			};
		
			this.active_rooms_area_open = false;
			this.room_count = ko.observable(0);
			this.active_room = ko.observable();
			this.rooms = ko.observableArray();
 
		};
     
		setInterval(function() {
            render();
			
			$.ajax({
				url: '<?php $url('sync'); ?>',
				cache: false,
				type: 'POST',
				dataType: 'json',
				data: {
				},
				success: function(data)
				{
					if(data['redirect'])
					{
						window.location = data['redirect'];
						return;
					}
					
					if(data['showcontent'])
					{
						open_content_area(data['showcontent']);
					}
						
					if(data['events'])
					{
						for(var key in data['events'])
						{
							if(data['events'][key].message_type == 'message')
							{
								var message = new App.Message(data['events'][key]);
								App.add_message(message);
							}
						}
					}
					
					if(data['users'])
					{
						App.sync_room_users(data['users']);
					}
					
					if(data['filters'])
					{
						App.filters = data['filters'];
					}
				}
			});
		}, 2000);  
	 
 	 
		$(function() {
			var chatAreaObj=$('#chat_area')[0];
			ko.applyBindings(App, chatAreaObj);
 			 
			//$("#send_button").attr('value', "Send");
			$("#send_button").bind('click', function() {
				App.send_message();
			});
			//$("#send_button").attr('value', "Send");
			$("#searchButton").bind('click', function() {
				  if (isSelectable()) return false;
 				urlParamArray={
						   "search": $("#searchInput").val(),
						   "urlParam": $("#chooseRoomType").val(),
					 };
			  
			   var urlParamString= '<?php $url('roomlist'); ?>'+'&';
				   urlParamString=  urlParamString+ UtilJS.getUrlParamString(urlParamArray);

				open_content_area(urlParamString);
                
			});
			$("#admin_create_room_button").bind('click', function() {
				open_content_area('<?php $url('admin_edit_room'); ?>');
			
			}); 
			$("#setpage_button").bind('click', function() {
				open_content_area('<?php $url('admin_edit_page'); ?>');
			}); 
			$("#chatrooms_menu").bind('click', function() {
				open_content_area('<?php $url('roomlist,-1'); ?>');
			});
			
			$("#admin_menu").bind('click', function() {
				open_content_area('<?php $url('admin_news'); ?>');
			});
			
			$("#settings_menu").bind('click', function() {
				open_content_area('<?php $url('settings'); ?>');
			});
		
			
			$("#close").bind('click', function() {
				close_content_area();
			});
 
			
			if(!App.active_room())
			{
				open_content_area('<?php $url('roomlist,-1'); ?>');
			}
			
			$('body').bind('click', function(ev) {
				if(App.active_rooms_area_open && $(ev.target).attr("id") !== 'active_rooms_area')
				{
					$("#active_rooms_area").slideUp('fast');
					App.active_rooms_area_open = false;
				}
			});
			
			$(window).bind('unload', function() {
				$.ajax({
					url: '<?php $url('leaverooms'); ?>',
					cache: false,
					type: 'POST',
					dataType: 'json',
					async: false
				});
			});

		

			if(App.open_room_name!="")

            RoomConstruction.joinRoom(0,App.open_room_name, App.usage_type_id);

		
			 
			if(App.usage_type_id!="")
				chooseRoomType(App.usage_type_id);
			
			<?php if(!empty($auto_join)): ?>
			 var roomId=<?php echo ($auto_join); ?>;
			 RoomConstruction.joinRoom(roomId);
			<?php endif; ?>

		
				 
		});

	    function toggleUsageDiv(){ 

				    	if(App.active_room() && App.active_room().usage_type_id!= 1)
						{
							 $("#divToggler").hide();
								
						}else{
							 $("#divToggler").show();
							 $("#usageContent").slideToggle("slow");
							 
				    	}

				}
	    function toggleContactDiv(){ 

				    	if(App.active_room() && App.active_room().usage_type_id!= 0)
						{
							 $("#divContactToggler").hide();
								
						}else{
							 $("#divContactToggler").show();
							 $("#contactContent").slideToggle("slow");
							 
				    	}

			}

   function  toggleAboutUsDiv(){ 
          if(App.active_room() && App.active_room().usage_type_id!=0)
			{
                    
			    $("#divAboutUsToggler").hide();
					
			}else{
				 $("#divAboutUsToggler").show();
				 $("#aboutUsContent").slideToggle("slow");
				 
 	    	}

			}
		function open_content_area(url, postdata)
		{
			$("#globalInput").hide();
 			
			$("#content_area").slideDown();
			$("#chat_area").slideUp();
			$('#close').show();
			
			var handle_page = function(data)
			{
				if(data)
				{
					$("#content_page").html(data);
				}
			
				var title = $('#content_page #title_def').text();
				$('#title').text(title);
				
				$("#content_page *[data-href]").each(function() {
					$(this).bind('click', function() {
						var url = $(this).attr('data-href');
						var page = url;
						var query = '';
						if(url.indexOf('?') >= 0)
						{
							page = url.substring(0, url.indexOf('?'));
							query = url.substring(url.indexOf('?')+1);
						}
						
						open_content_area('?page=' + page + '&' + query);
						return false;
					});
				});
				
				$("#content_page form[data-action]").each(function() {
					$(this).bind('submit', function() {
						open_content_area('?page=' + $(this).attr('data-action'), $(this).serialize());
						return false;
					});
				});
				
				if(!App.active_room())
				{
					$('#close').hide();
				}
				
				$('#content_page').scrollTop(0);
			}
			
			if(postdata)
			{
				$.post(url, postdata, function(data)
				{
					handle_page(data);
				});
			}
			else
			{
				$('#content_page').load(url, function()
				{
					handle_page();
				});
			}
			
 				
		}
		/*
		 * Function to load URL into certain div element.
		 */
		function closeIt(){
			$("#inputTools").slideUp();
		
			}
		
		function  loadURLIntoDiv(url, postdata)
		{
			$("#inputTools").slideDown();
		    $('#closeIt').show();
			
			var handle_page = function(data)
			{
				if(data)
				{
					$("#inputTools").html(data);
				}
			
			//	var title = $('#inputTools #title_def').text();
			//	$('#title').text(title);
				
				$("#inputTools *[data-href]").each(function() {
					$(this).bind('click', function() {
						var url = $(this).attr('data-href');
						var page = url;
						var query = '';
						if(url.indexOf('?') >= 0)
						{
							page = url.substring(0, url.indexOf('?'));
							query = url.substring(url.indexOf('?')+1);
						}
						
						open_content_area('?page=' + page + '&' + query);
						return false;
					});
				});
				
				$("#inputTools form[data-action]").each(function() {
					$(this).bind('submit', function() {
						open_content_area('?page=' + $(this).attr('data-action'), $(this).serialize());
						return false;
					});
				});
				
				 
				
				$('#inputTools').scrollTop(0);
			}
			
			if(postdata)
			{
				$.post(url, postdata, function(data)
				{
					handle_page(data);
				});
			}
			else
			{
				$('#inputTools').load(url, function()
				{
					handle_page();
				});
			}
		}

		function close_content_area()
		{
		
 			render();	
		    $("#globalInput").slideDown();
  			
			$("#content_area").slideUp();
			$("#chat_area").slideDown();
			setTimeout(function() {
				$("#message_scroll_wrapper").scrollTop($("#messages").height());
			}, 500);
		}
  
	  	
	</script>

<script>
	function chooseRoomType(value){


		  
			switch(value){
			case "-1":
			open_content_area('<?php $url('roomlist,-1'); ?>');
			break;
			case "0":
			open_content_area('<?php $url('roomlist,0'); ?>');
			break;
			case "1":
		    open_content_area('<?php $url('roomlist,1'); ?>');
		    break;
			case "2":
		    open_content_area('<?php $url('roomlist,2'); ?>');
		    break;
			case "3":
		    open_content_area('<?php $url('roomlist,3'); ?>');
			break;
			case "4":
			open_content_area('<?php $url('roomlist,4'); ?>');
		    break;
			case "5":
			open_content_area('<?php $url('roomlist,5'); ?>');
			break;
			}
			
		
          };
		
	
function showPast20Msg() {
	 			
                   room=App.active_room();
                   var currentCount=parseInt($("#spanCurrentMsgCount"+room.id).text());
                   var totalCount=parseInt($("#spanTotalMsgCount"+room.id).text());
                   if(!(currentCount<totalCount))
                       return false;
                   
                  
                   
                   var joinRoomFunctionURL = window.location.origin+ "/pages/joinroom.php";
        	       
           		var argJson = {
           			'room_id' : room.id,
           			'roomName': "",
           			'usageTypeId':0,
           			'limit':$("#spanCurrentMsgCount"+room.id).text()
           		};
                   
           	 
           		
           		$.ajax({
           			type : "POST",
           			url : joinRoomFunctionURL,
           			dataType : "json",
           			data : argJson,
           			success : function(jSonRoomComponents) {

           				getRoomFromPHPtoJS(jSonRoomComponents);
                          
           			},
           			error : function(xhr, ajaxOptions, thrownError) {
           				 
           				alert('joinroom.js:1:' + xhr.status);
           				alert(thrownError);
           			}
           		});

            
           		function getRoomFromPHPtoJS(jSonRoomComponents) {
  				    room=App.active_room();
             		var i=jSonRoomComponents.messages.length;
    			    var currentCount= $("#spanCurrentMsgCount"+room.id).text();
           			currentCount=parseInt(currentCount)+i;
           			$("#spanCurrentMsgCount"+room.id).text(currentCount);
           			
           			i=i-1;
           			 while(i>-1){
               		     room.messages.splice(0,0,jSonRoomComponents.messages[i]);
           			      i--;
               			 }
             			
           		  
           		}
					 
           		$("#message_scroll_wrapper").scrollTop(0);
			 
         }
			   

		  
  function	isSelectable(){
	 if($("#searchInput").val()==''){
		   selectable= true;
	 }else{
		  selectable=false;
		 }
		return selectable;
	}
			



	  var youcreate="";
  $(document).ready(function () {
		if(App.open_content_area)
			open_content_area(window.location.origin+"/?page="+App.open_content_area);
 		
	      roomIdGET="<?php echo $room_id; ?>";
	      messageIdGET="<?php echo $message_id; ?>";
	      if(messageIdGET!=0){
		    	 RoomConstruction.messageId=messageIdGET;
	 		     }
	      
	     if(roomIdGET!=0){
	    	 RoomConstruction.joinRoom(roomIdGET, 0, 0, 0);
 		     }
    
	 	  youcreate="<?php $lang('youcreate'); ?>";

        
 	 
      $('#chooseRoomType').on('change', function() {
    	  if (!isSelectable()) return false;
      
    	  chooseRoomType(this.value);   
    	} );
    	
		});

  function showPastButton(){
 	  if(!$("#divShowAll").is(":visible") &&  App.active_room().usage_type_id!=undefined)
		 $('#divShowPast20Msg').show();
  	}
  
	 function deneme(){
		 $("#page_header").slideToggle();
	}

	 $(function() {
			$( document ).tooltip({
			
				items: "[fonttype]",
				content: function() {
					var element = $( this );
					if ( element.is( "[fonttype]" ) ) {
						var text = element.text();
						return  "<img class='map' alt='" + text +
							"' src='http://maps.google.com/maps/api/staticmap?" +
							"zoom=11&size=350x350&maptype=terrain&sensor=false&center=" +
							text + "'>";
					}
					 
				}
			});
		});
	 
	
</script>
  
<div id="divToolBar" class="divToolBar">

	
	<ul>
		<li>
			 		      <select id="chooseRoomType" style="height: 30px"  name="chooseRoomType">
			         <option value="-1" selected="selected"><?php $lang( 'room_usage_type'); ?></option>
			   		 <option value="0"><?php $lang( 'company'); ?></option>
			  		 <option value="1"><?php $lang( 'mission'); ?></option>
			  		 <option value="2"><?php $lang( 'dictionary'); ?></option>
			  		 <option value="3"><?php $lang( 'ircchat'); ?></option>
			  		 <option value="4"><?php $lang( 'personal'); ?></option>
		
			       </select>
		    <a   href="#" id="searchButton" class="buttonStyle"   style="display:none; margin-left:205px; width:4px; color:grey; height:13px; margin-top:2px; position: fixed;" 
  				 >Go</a>
		</li>
	    <li>
	     <input id="searchInput" type="text"  style="margin-top:2px; font-size: 12px; position: absolute; "
     placeholder="<?php $lang("search"); ?>">
	    </li>
	       <li>
	   <a href="#" onclick="deneme()"> <img src="./images/toolbox.png"
		title="Araçlar" style="float: right;"></img>

	</a>
	</li>
	
   <li>
	<a href="#" onclick="RoomConstruction.joinRoom(0,'buradaydım',3)">
	     	<img alt="" src="images/hand-down.png" style="float: right;">
	</a>
	<li>
	</ul>

   
	
	
</div>
<span id="messageSpan">

</span>
<!-- Start: content_area --><div id="content_area">
	<div id="content_title_bar">
		<div id="title"></div>
		<div id="close">
			<a href="#"><?php $lang('close_content_button'); ?></a>
		</div>
		<div style="clear: both;"></div>
	</div>
	<div id="content_page"></div>
<!-- E: chat_area --></div>

<!-- Start: chat_area --><div id="chat_area">

<!-- Start: active_rooms_area -->	<div id="active_rooms_area" class="genericDiv">
		<p><?php $lang('all_rooms_text'); ?></p>
		<br />
		<ul data-bind="foreach: rooms">

			<li><a href="#" data-bind="text: name, click: $root.set_active_room"></a>

				<span data-bind="if: type == 'user'" class="private_chat_text">(private)</span>
				- <a href="#" data-bind="click: $root.leave_room"><?php $lang('leave_room'); ?></a></li>
		</ul>
		<br />
		<p><?php $lang('all_rooms_join_other_rooms'); ?></p>
<!-- End: active_rooms_area -->	</div>
	 	
<!-- Start: room_tab_bar --><div id="room_tab_bar">

	
		<div id="current_room_button">
			<!-- ko if: active_room() -->
			 <span  id="usageTypeText" data-bind="text:active_room().usageTypeText"  style="float: left;"></span>	
    				 <span id="roomNameSpan" data-bind="text: active_room().name" style=""></span>
				<!-- ko if: active_room().type == 'user' -->
					<b><?php $lang('private_chat'); ?> </b>
				<!-- /ko -->
				<!-- ko if: active_room().type == 'room' -->
					<b><?php $lang('current_room'); ?> </b>
				<!-- /ko -->
				 
				   
    				
					 
			<!-- /ko -->

		</div>

		<div id="room_tabs_button">

			<a href="#" data-bind="click: show_rooms"><?php $lang('all_rooms'); ?></a>
			(<span data-bind="text: room_count()"></span>)
		</div>
		<div id="alert_rooms">

			<ul data-bind="foreach: rooms">
				<!-- ko if: alert -->
				<li data-bind="click: $root.set_active_room"><a href="#"
					data-bind="text: name"></a> <span data-bind="if: type == 'user'"
					class="private_chat_text"> - private</span> (<span
					data-bind="text: alert"></span>)</li>
				<!-- /ko -->
			</ul>
				
		</div>
		<div  id="divShowPast20Msg"  data-bind="with:active_room()"    class="genericDiv" style="margin-left: 364px">
		   <a href="#" onclick="showPast20Msg()"  > <?php $lang('past_msg'); ?>
				<span id="spanCurrentMsgCount"   data-bind="attr:{id:'spanCurrentMsgCount'+id }, text: currentMsgCountInit"  class="spanCurrentMsgCount"></span>
					/
				<span id="spanTotalMsgCount"  data-bind="attr:{id:'spanTotalMsgCount'+id}, text: messageCount" class="spanTotalMsgCount"></span>
	     	</a>
	     </div>
	     
	    	<div  id="divShowAll"  data-bind="with:active_room()"    class="genericDiv" style="display:none; margin-left: 364px">
		  		 <a href="#" data-bind="click: $root.showAll"  > <?php $lang('show_all'); ?></a>
	     	</div>
		
		<div style="clear: both;"></div>

<!-- End: room_tab_bar -->	</div>

	
	<div style="clear: both;"></div>
	<!-- ko if: active_room() -->
 
	
	 <div id="message_scroll_wrapper"  onclick="$('#divShowPast20Msg').hide();" onmouseover="showPastButton();" >
 		   	           
		   	           <div id="usageContent" data-bind="with:active_room()" style="position: fixed;">
		   	         		<span data-bind="text:usage_deadline" style="vertical-align:top; font-weight:bold;"></span>
							<br>
							<span data-bind="html:usage_text" id="spanUsage"></span>
							 
		 			   </div>

					   <div style="clear: both; position: fixed; display: none;" id="divToggler">
	                 		 <a href="#" onclick="toggleUsageDiv()"> <img  src="./images/usagetext.png"
		                		 ></img>

	                  		 </a>
	                  </div>
		 
			 
		   	           
		   	          <div id="contactContent" style="position: fixed;">
		   	         		<span  style="vertical-align:top; font-weight:bold;"></span>
							<br>
							<span   id="spanContact"></span>
							 
		 			   </div>
		   	           
		   	           <div id="aboutUsContent" style="position: fixed;">
		   	         		<span  style="vertical-align:top; font-weight:bold;"></span>
							<br>
							<span   id="spanAboutUs"></span>
							 
		 			   </div>

					   <div style="clear: both; position: fixed ; display: none;" id="divAboutUsToggler">
	                 		 <a href="#" onclick="toggleAboutUsDiv()"> <img  src="./images/aboutus.png"></img>

	                  		 </a>
	                  </div>
					
					  <div style="clear: both; position:fixed; left: 358px; display: none;" id="divContactToggler">
	                 		 <a href="#" onclick="toggleContactDiv()"> <img  src="./images/contactmap.png"></img>

	                  		 </a>
	                  </div>
 

		<div id="messages" data-bind="foreach: active_room().messages()">

			<div class="message_container"  data-bind=" attr:{id:'messageContainer'+id}, event: { mouseover: $root.showMsgTools, mouseout:$root.hideMsgTools }" >
 		
				<span class="timestamp" data-bind="text: timestamp"></span>
						<!-- ko if: source_type != 'system' -->
						<span class="classMsgTools" style="float:right; display: none" data-bind="attr:{id:id}"> 				
 						  <input type="button" value="<?php echo  $x7->lang('edit'); ?>"  class="classMsgButtons" style= "padding:5px 0px" data-bind="click: $root.setEditable, attr:{id:'edit'+id}" />
 					 	  <input type="button" value="<?php echo  $x7->lang('update'); ?> " class="classMsgButtons" style="padding:5px 0px; display: none;" data-bind="click: $root.updateMessage, attr:{id:'update'+id}" />
 					 	  <input type="button" value="<?php echo  $x7->lang('delete'); ?>" class="classMsgButtons"  style="padding:5px 0px"  data-bind="click: $root.deleteMessage, attr:{id:'delete'+id}" />
 					    </span>
 						<input  id="shareButton" style="float:right; padding:5px 0px;display: none" data-bind="click: $root.showShareTools, attr:{id:'shareButton'+id}"  type="button" value="<?php echo  $x7->lang('share'); ?>" class="classMsgButtons"   />
 						<input style= "width:60px; float:right; padding:5px 0px;display: none" type="button" value="<?php echo  $x7->lang('set_mission'); ?>"  class="classMsgButtons"   data-bind="click: $root.setMission, attr:{id:'setMission'+id}" />
 						
						<div class="onlineuser" data-bind="click: $root.show_user_profile">
							<a href='#' data-bind="text: source_name"></a>
						</div>
 				
 						<span  
 						    class="oneMsg"
							data-bind=" attr:{id:'oneMsg'+id, room_id:dest_id}, html: message, style: { color: font_color ? '#' + font_color : '', fontSize: font_size > 0 ? font_size + 'px' : '', fontFamily: font_face ? font_face : ''}"></span> 
 						 
 				
				 
							
						<!-- /ko -->
		
						<!-- ko if: source_type == 'system' -->
						<span class="sender system_sender"><?php $lang('system_sender'); ?>: </span>
						<span class="message system_message" data-bind="text: message"></span>
						<!-- /ko -->
 			</div>
 			<br>
	        </div>

	  </div>
				<div id="onlinelist" data-bind="foreach: active_room().users()">
						<div class="onlineuser" data-bind="click: $root.show_user_profile">
							<a href='#' data-bind="text: user_name"></a>
						</div>
			   </div>
				<div style="clear: both;"></div>

	<!-- /ko -->

<!-- End: "chat_area" --></div>
	
	
<!-- Start: globalInput -->	<div id="globalInput" style="display: none">
    <div id="inputTools"></div>
    <div id="input_form">
		<input type="button" id="send_button"
		 width="0px" height="0px" style="display: none"  />
		<div style="clear: both;"></div>

	</div>
	
	<!-- Start: extract_url -->	<div class="extract_url">

	  <img id="loading_indicator" src="images/ajax-loader.gif">
 
	    <div  style="margin-top: 0px;">
	      <span class="globalTextAreaToolBox">
	        
		        <a href="#"  class="classname">
	    	      A
		        </a>
		      <a href="#"  class="classname" >
	    	      T
		        </a>
		        
		        <a href="#"  class="classname" onclick="wrapSelection(0)">
	    	      $
		        </a>
		        
		        <a href="#" class="classname" onclick="wrapSelection(1)">
		          !
		        </a> 	
		        
		        <a href="#"  class="classname" onclick="wrapSelection(2)">
				  ~		       
				</a>
		        
		        <a href="#" class="classname" onclick="wrapSelection(3)">
		          #
		       	</a>
		       
		       	<a href="#" class="classname" style="border-bottom-right-radius:10px;
												-webkit-border-bottom-left-radius:10px;
												-moz-border-radius-bottomleft:10px;
												border-bottom-left-radius:0px;" 
												onclick="wrapSelection(4)">
		       	  @
		       	</a>
	     
	        </span>
			 
					<textarea cols='1' class="globalTextAreaStyleClass"   id="globalTextArea"></textarea>
			        <span id="spanCounter" style="color: red; font-size: large; "></span>
	 
		 </div>
		 <script>
	
	 
		 function wrapSelection(usageCase){
 				 
				$(function() {
                      
				    var el = document.getElementById("globalTextArea");
				    var returnArray={};
				    switch(usageCase){
				    case 0:
	 				     returnArray= replaceSelectedText(el, " <compa>", "</compa> ");
					break;
				    case 1:
	 				     returnArray= replaceSelectedText(el, " <miss>", "</miss> ");
					break;
				    case 2:
				        returnArray= replaceSelectedText(el, " <dict>", "</dict> ");

		 			break;
				    case 3:
				    	returnArray= replaceSelectedText(el, " <hash>", "</hash> ");
					break;
				    case 4:
	 				     returnArray= replaceSelectedText(el, " <pblog>", "</pblog> ");
					break;
				    }
				 
						   
 				    	
					 
				});				 
		 }
		</script>
		
		<div id="results"></div>

		<!-- End: extract_url --></div>
<!-- End: globalInput -->
		
		
		
		
		
		
		
		
		
		</div>
<audio id="message_sound">
	<source src="sounds/enter.ogg" type='audio/ogg; codecs="vorbis"'>
	<source src="sounds/enter.mp3" type='audio/mpeg; codecs="mp3"'>
</audio>
<audio id="enter_sound">
	<source src="sounds/enter.ogg" type='audio/ogg; codecs="vorbis"'>
	<source src="sounds/enter.mp3" type='audio/mpeg; codecs="mp3"'>
</audio>
		<span id="tempSpan"   style="display: none;"></span>
		 
		
<?php $display('layout/footer'); ?>
 