var  RoomConstruction = new function(){
var	roomConstruction=this;
this.pass="";
this.msg="";
this.info="";
this.messageId="";
this.refresh=0;
this.setPass=function(pass){
 
	roomConstruction.pass=pass;
};
this.getPass=function(){
	return roomConstruction.pass;
};

this.openPageURL=function(pageName, extraStr)
{ 
	window.location= window.location.origin="/?page="+ pageName+extraStr;

	  
};

this.openRoom=function(name)
{ 
	window.location= window.location.origin="/?page=chat&open_room_name="+ name+"&usage_type_id=1";

	  
};
this.deleteMessage=function(messageId, token, userId) {
	 
  
    var joinRoomFunctionURL = window.location.origin+ "/pages/deleteMessage.php";
   
	var argJson = {
		'message_id' : messageId,
		'token':token,
		'userId': userId
	};
    
 

	$.ajax({
		type : "POST",
		url : joinRoomFunctionURL,
		dataType : "json",
		data : argJson,
		success : function(jSonMessageComponents) {

			 deleteMessagesAjaxFunc(jSonMessageComponents);
	 
   
		},
		error : function(xhr, ajaxOptions, thrownError) {
			 
			alert('joinroom.js:1:' + xhr.status);
			alert(thrownError);
		}
	});

	// AJAX ICINDEN CAGRILAN FONKSIYONLAR

	function deleteMessagesAjaxFunc(jSonMessageComponents) {
		 deleteInfo= jSonMessageComponents.deleteInfo;
	 
   }
	
};



this.getLanguages=function(langFile) {
	 
  
    var joinRoomFunctionURL = window.location.origin+"/pages/get_languages.php";
	var argJson = {
			'lang_file' : langFile,
		 
		};
    
    $.ajax({
		type : "POST",
		url : joinRoomFunctionURL,
		data : argJson,
		dataType : "json",
 		success : function(jSonLanguageComponents) {

			getLanguagesAjaxFunc(jSonLanguageComponents);
	 
   
		},
		error : function(xhr, ajaxOptions, thrownError) {
			 
			alert('joinroom.js:1:' + xhr.status);
			alert(thrownError);
		}
	});

	// AJAX ICINDEN CAGRILAN FONKSIYONLAR

	function getLanguagesAjaxFunc(jSonLanguageComponents) {
     
		var langList=jSonLanguageComponents;
		var options = $("#selectLang");
	    if(langList!=undefined)
		$.each(langList, function() {
			var opt=new Option(this.language,this.lang_file_name);

			opt.setAttribute("id", this.lang_file_name);
			if(langFile==this.lang_file_name){
			 	options.prepend(opt);
   			}else{
			
			    options.append(opt);
			    }
			var jsonData ={ "en-us": [{"use": "Use", "dev": "Develop"}],
							"tr": [{"use": "Kullan!", "dev": "Geliştir"}],
							"de": [{"use": "Use", "dev": "Develop"}],
							"it": [{"use": "Use", "dev": "Develop"}],
							"es": [{"use": "Use", "dev": "Develop"}],
							"ar-sy": [{"use": "Use", "dev": "Develop"}],
							"kr": [{"use": "사용!", "dev": "개발할"}],
							"ru": [{"use": "Используйте!", "dev": "Ты разработай"}],
							"fr": [{"use": "Use", "dev": "Develop"}], 
							"mn": [{"use": "хэрэглэх", "dev": "хөгжүүлэх"}]
							};
 
			
		    $("#"+this.lang_file_name).attr("data-imagesrc", "http://www.alumay.com/images/flags/"+this.lang_file_name+".png")
 		     var jsonLang=jsonData[this.lang_file_name];
		     var j1=jsonLang[0];
		     var useString="<span  onclick=\"RoomConstruction.setSession('" +
				this.lang_file_name+"');\"><u>"+j1["use"]+"<\/u></span>";
		     
		  
		     
		     var devOnclick="onclick='RoomConstruction.openRoom(\"" +j1["dev"]+"\")'";
		    
		     var devString="<span style='margin-left:5px;'"+devOnclick+ "><u>!"+j1["dev"]+"<\/u></span>";
		     
		     
		     var linkString=useString+devString;
		    $("#"+this.lang_file_name).attr("data-description", linkString)


		});
	    
	    $('#selectLang').ddslick();
	  
          //	        RoomConstruction.setSession($(this).attr('value'));

	    
	}
	
};



this.getMessage=function(messageId, userId) {
	 
  
    var joinRoomFunctionURL = window.location.origin+"/pages/get_message.php";
   
	var argJson = {
		'message_id' : messageId,
		'userId': userId
		
	};
    
 

	$.ajax({
		type : "POST",
		url : joinRoomFunctionURL,
		dataType : "json",
		data : argJson,
		success : function(jSonMessageComponents) {

		 getMessagesAjaxFunc(jSonMessageComponents);
	 
   
		},
		error : function(xhr, ajaxOptions, thrownError) {
			 
			alert('joinroom.js:1:' + xhr.status);
			alert(thrownError);
		}
	});

	// AJAX ICINDEN CAGRILAN FONKSIYONLAR

	function getMessagesAjaxFunc(jSonMessageComponents) {
	    msg= jSonMessageComponents.message[0].message;
		var dbValue=msg;
	 
		dbValue= dbValue.replace(/<i\s/g,'[i ');
		dbValue= dbValue.replace(/<v\s/g,'[v ');
		dbValue= dbValue.replace(/<c\s/g,'[c ');
		dbValue= dbValue.replace(/><\/i>/g,'][/i] ');
		dbValue= dbValue.replace(/><\/v>/g,'][/v]');
		dbValue= dbValue.replace(/><\/c>/g,'][/c]');
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
		
		
		
		var option = {dbValue:dbValue, type : "textarea", action :"none"};
		$("#oneMsg"+messageId).editable(option, function(e){
		 
		});
   }
	
};

this.updateMessage=function(messageId, newText, token, userId) {
	 
  
    var joinRoomFunctionURL = window.location.origin+"/pages/updateMessage.php";
   
	var argJson = {
		'message_id' : messageId,
		'newText':newText,
		'token':token,
		'userId': userId
	};
    
 

	$.ajax({
		type : "POST",
		url : joinRoomFunctionURL,
		dataType : "json",
		data : argJson,
		success : function(jSonMessageComponents) {

			updateMessagesAjaxFunc(jSonMessageComponents);
	 
   
		},
		error : function(xhr, ajaxOptions, thrownError) {
			 
			alert('joinroom.js:1:' + xhr.status);
			alert(thrownError);
		}
	});

	// AJAX ICINDEN CAGRILAN FONKSIYONLAR

	function updateMessagesAjaxFunc(jSonMessageComponents) {
	    info= jSonMessageComponents.info[0].info;
        UtilJS.showMessages('', info,'','');
   }
	
};




this.setUpCompany=function(companyName,address, lat, lng, token, userId, telNo, web) {
	 
  
    var joinRoomFunctionURL = window.location.origin+"/pages/set_company.php";
   
	var argJson = {
		'companyName':companyName,	
		'address': address,
		'lat': lat,
		'lng': lng,
 	    'token':token,
		'userId': userId,
	    'telNo':telNo,
	    'web':web
	};
    
 

	$.ajax({
		type : "POST",
		url : joinRoomFunctionURL,
		dataType : "json",
		data : argJson,
		success : function(jSonMessageComponents) {

			setUpCompanyAjaxFunc(jSonMessageComponents);
	 
   
		},
		error : function(xhr, ajaxOptions, thrownError) {
			 
			alert('joinroom.js:1:' + xhr.status);
			alert(thrownError);
		}
	});

	// AJAX ICINDEN CAGRILAN FONKSIYONLAR

	function setUpCompanyAjaxFunc(jSonMessageComponents) {
	    info= jSonMessageComponents.info;
        UtilJS.showMessages('', info,-1,'');
   }
	
};




this.setSession=function(value) {
	 
  
    var joinRoomFunctionURL = window.location.origin+"/pages/set_session.php";
   
	var argJson = {
		'langFile':value,	
	 
	};
    
 

	$.ajax({
		type : "POST",
		url : joinRoomFunctionURL,
		dataType : "json",
		data : argJson,
		success : function(jSonMessageComponents) {

			setSessionAjaxFunc(jSonMessageComponents);
	 
   
		},
		error : function(xhr, ajaxOptions, thrownError) {
			 
			alert('joinroom.js:1:' + xhr.status);
			alert(thrownError);
		}
	});

	// AJAX ICINDEN CAGRILAN FONKSIYONLAR

	function setSessionAjaxFunc(jSonMessageComponents) {
	    info= jSonMessageComponents.info;
	 
        window.location=   window.location.origin;
    }
	
};


this.login=function(email, password, isAjax) {
	 
  
    var joinRoomFunctionURL = window.location.origin+"/pages/dologin.php";
   
	var argJson = {
		'email': email,
		'password': password,
		'isAjax':isAjax
		
	};
    
 

	$.ajax({
		type : "POST",
		url : joinRoomFunctionURL,
		dataType : "json",
		data : argJson,
		success : function(jSonMessageComponents) {

			setUpCompanyAjaxFunc(jSonMessageComponents);
	 
   
		},
		error : function(xhr, ajaxOptions, thrownError) {
			 
			alert('joinroom.js:1:' + xhr.status);
			alert(thrownError);
		}
	});

	// AJAX ICINDEN CAGRILAN FONKSIYONLAR

	function setUpCompanyAjaxFunc(jSonMessageComponents) {
	    info= jSonMessageComponents.info;
	    var success=jSonMessageComponents.success;
	    if(success){
	    	$("#form-login").dialog('close');
	    	location.reload();
	    }
 	 
	    
	    UtilJS.spanToShowMsg='#loginMsg';
        UtilJS.showMessages('', info,-1,'');
   }
	
};






this.joinRoom=function(roomId, roomName, usageTypeId, limit) {
      
	    
	    var room= App.get_room(roomId, 'room');
	   
	    if(!this.refresh){
				    if(room){
				    	 return	goToRoom(room);
				    }else if(roomName!="" && usageTypeId>-1){
				    	room= App.get_room_by_name(roomName, 'room', usageTypeId);
				    	  if(room){
				 	    	 return	goToRoom(room);
			
				    	  }
				    }
	    }
	    	 
	    var joinRoomFunctionURL =window.location.origin+ "/pages/joinroom.php";
       
		var argJson = {
			'room_id' : roomId,
			'roomName': roomName,
			'usageTypeId':usageTypeId,
			'limit':limit,
			'message_id':this.messageId
		};
       if(this.messageId)
    	   {
    	   
     	   $("#divShowPast20Msg").hide();
    	   $("#divShowAll").show();
    	   }
         
		if(RoomConstruction.getPass()){
			argJson["password"]=RoomConstruction.getPass();
        
		}
		
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

		// AJAX ICINDEN CAGRILAN FONKSIYONLAR

		var users ='';
		var messages = '';
		function getRoomFromPHPtoJS(jSonRoomComponents) {
				var url=jSonRoomComponents.url;
				if(url){
					open_content_area(url);
					return false;
				}
				
				var type=jSonRoomComponents.type;
				if(type){
					var message=jSonRoomComponents.message;
					var urlRoom=jSonRoomComponents.urlRoom;
					var navigate=jSonRoomComponents.navigate;
 					UtilJS.showMessages(type, message,navigate,urlRoom );
 					
 					return false;
				}
			    users = jSonRoomComponents.users;
				room =  new App.Room(jSonRoomComponents.room);
				messages = jSonRoomComponents.messages;
               
				room.type = 'room';
			    if (typeof jSonRoomComponents.messageCount!= 'undefined') {
		 				room.messageCount=jSonRoomComponents.messageCount.messageCount;

						}else{
							room.messageCount=0;	
						}
			   
			    var key=room.usage_type_id;

			    
				App.add_room(room);

     		    for ( var key in users) {
					App.add_user_room(users[key], 1);
				}
	 
				for (var key in messages) {
			
					var message = new App.Message(messages[key]);
					 if(message.hashtag_room_id)
					    	message.dest_id=message.hashtag_room_id
					App.add_message(message);
				}
				
				
				usageTypeText="";
                var key=room.usage_type_id;
			    switch (key) {
							case "0":
								 usageTypeText="$";
							     break;
							case "1":
								 usageTypeText="!";
						     break;
							case "2":
								 usageTypeText="~";
							    break;
							case "3":
								 usageTypeText="#";
			                 	break;
							case "4":
								 usageTypeText="@";
			                   break;
						
						}
			 
				
				 
			    room.currentMsgCountInit=messages.length;
			    room.usageTypeText= usageTypeText;
				
			 	goToRoom(room);
		}
		
		
		
		
       function goToRoom(room){
   		App.set_active_room(room);
   		close_content_area();
   		if(room.usage_type_id==1)
   		$("#usageContent").slideDown();
   		        return false;
       }  
		
		}; 
};