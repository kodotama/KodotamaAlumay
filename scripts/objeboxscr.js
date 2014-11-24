
function getInputSelection(el) {
    var start = 0, end = 0, normalizedValue, range='', text='',
        textInputRange, len, endRange;

    if (typeof el.selectionStart == "number" && typeof el.selectionEnd == "number") {
        start = el.selectionStart;
        end = el.selectionEnd;
        text=el.value.substring(start, end);
    } else {
        range = document.selection.createRange();
        text=range.text;
        if (range && range.parentElement() == el) {
            len = el.value.length;
            normalizedValue = el.value.replace(/\r\n/g, "\n");

            // Create a working TextRange that lives only in the input
            textInputRange = el.createTextRange();
            textInputRange.moveToBookmark(range.getBookmark());

            // Check if the start and end of the selection are at the very end
            // of the input, since moveStart/moveEnd doesn't return what we want
            // in those cases
            endRange = el.createTextRange();
            endRange.collapse(false);

            if (textInputRange.compareEndPoints("StartToEnd", endRange) > -1) {
                start = end = len;
            } else {
                start = -textInputRange.moveStart("character", -len);
                start += normalizedValue.slice(0, start).split("\n").length - 1;

                if (textInputRange.compareEndPoints("EndToEnd", endRange) > -1) {
                    end = len;
                } else {
                    end = -textInputRange.moveEnd("character", -len);
                    end += normalizedValue.slice(0, end).split("\n").length - 1;
                }
            }
        }
    }

    return {
        start: start,
        text: text,
        end: end
    };
}

function replaceSelectedText(el, text1, text2) {
    var sel = getInputSelection(el), val = el.value;
    var newValue=text1 +sel.text+text2;
    el.value = val.slice(0, sel.start) + newValue +val.slice(sel.end);
    var returnArray={
    		"newValue":newValue,
             "len": sel.text.length
    }
    return returnArray;
}



function render(){


var $t = {};
var i = 0;   
  

$('compa').each(function(){

    $t[i] = $(this).text();
    
    var valueStr=$t[i].trim();
    valueStr=valueStr.replace("'","&#39;");
    valueStr=valueStr.replace("\"","&#34;");
    
    var strLink="<a href=\"#\" onclick='RoomConstruction.joinRoom(0,\""+valueStr+"\",0)'>$"+valueStr+"</a>";
	$(this).replaceWith(strLink);
    i++;

});

$t = {};
i = 0;   
$('miss').each(function(){

    $t[i] = $(this).text();
    
    var valueStr=$t[i].trim();
    valueStr=valueStr.replace("'","&#39;");
    valueStr=valueStr.replace("\"","&#34;");

    var strLink="<a href=\"#\" onclick='RoomConstruction.joinRoom(0,\""+valueStr+"\",1)'>!"+valueStr+"</a>";
	$(this).replaceWith(strLink);
    i++;

});

$t = {};
i = 0;   

$('dict').each(function(){

    $t[i] = $(this).text();
    
    var valueStr=$t[i].trim();
    valueStr=valueStr.replace("'","&#39;");
    valueStr=valueStr.replace("\"","&#34;");

    var strLink="<a href=\"#\" onclick='RoomConstruction.joinRoom(0,\""+valueStr+"\",2)'>~"+valueStr+"</a>";
	$(this).replaceWith(strLink);
    i++;

});


$t = {};
i = 0;   

$('hash').each(function(){

    $t[i] = $(this).text();
    
    var valueStr=$t[i].trim();
    valueStr=UtilJS.replaceAt(0,"#","",valueStr);
    valueStr=valueStr.replace("'","&#39;");
    valueStr=valueStr.replace("\"","&#34;");

    var strLink="<a href=\"#\" onclick='RoomConstruction.joinRoom(0,\""+valueStr+"\",3)'>#"+valueStr+"</a>";
	$(this).replaceWith(strLink);
    i++;

});

$t = {};
i = 0;   

$('pblog').each(function(){

    $t[i] = $(this).text();
    
    var valueStr=$t[i].trim();
    valueStr=valueStr.replace("'","&#39;");
    valueStr=valueStr.replace("\"","&#34;");

    var strLink="<a href=\"#\" onclick='RoomConstruction.joinRoom(0,\""+valueStr+"\",4)'>@"+valueStr+"</a>";
	$(this).replaceWith(strLink);
    i++;

});


 	

 $('v').each(function(){
		var dataTitle=  $(this).attr("dt");
		var dataContent=$(this).attr("dc");
		var source = $(this).attr("s");
		var imgUrl=  $(this).attr("i");
        var imgStr='';
        if(!(typeof imgUrl === 'undefined')){
     	   // your code here.
         	
        	imgStr= '<ul class="gallery clearfix">'
				+'<li>'
				+'<a href="'+source+ '" rel="prettyPhoto">'

                  +'<img  onclick="callPrettyPhoto();" src="'+imgUrl+'" width="60" alt="" />'
			    +'</a></li>'
            
				+'</ul>';	
 
     	   
     	 }
         
		
		
			var htmlInput=
	    '<div>'
	    + imgStr
        +'</div>'
        +'<div>'
        	+'<div><a href='+ source +'>'+dataTitle+'</a></div>'
        	+'<div>'+dataContent+'</div>'
        +'</div>';
    	
						
			$(this).replaceWith("<p>"+htmlInput+"</p>");
		 
	});
	
	
	$('i').each(function(){
		var value = $(this).attr("s");
		var htmlInput='<ul class="gallery clearfix"><li><a href='+value+' rel="prettyPhoto[gallery1]">'
        +'<img width="60px"  height="60px" onclick="callPrettyPhoto();" src='+value+'></img></a></li></ul>';
						
			$(this).replaceWith("<p>"+htmlInput+"</p>");
		 
	});

	$('c').each(function(){
		var imgUrl=  $(this).attr("i");
        var imgStr='';
        if(!(typeof imgUrl === 'undefined')){
     	   // your code here.
        	imgStr=  '<img width="60px"  height="60px" onclick="callPrettyPhoto();" src='+imgUrl+'></img>';
     	   
     	 }
         
		var dataTitle=  $(this).attr("dt");
		var dataContent=$(this).attr("dc");
		var source = $(this).attr("s");
		
			var htmlInput=
	    '<div> <a href='+source+'  target="_blank">'
	    + imgStr
        +'</a></div>'
        +'<div>'
        	+'<div><a href='+ source +' target="_blank">'+dataTitle+'</a></div>'
        	+'<div>'+dataContent+'</div>'
        +'</div>';
    	
						
			$(this).replaceWith("<p>"+htmlInput+"</p>");
		 
	});

	
}
function callPrettyPhoto() {

    $("area[rel^='prettyPhoto']").prettyPhoto();

    $(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({
        animation_speed: 'normal',
        theme: 'light_square',
        slideshow: 3000,
        autoplay_slideshow: true
    });
    $(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({
        animation_speed: 'fast',
        slideshow: 10000,
        hideflash: true
    });

    $("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
        custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
        changepicturecallback: function () {
            initialize();
        }
    });

    $("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
        custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
        changepicturecallback: function () {
            _bsap.exec();
        }
    });
}

 
var imgSrc='';
function chooseMsg(messageInput){
	var tempMsg='';
	   if (!isBlank(App.content)) {
 	    	// set the chosen image for message.
		    if(imgSrc!='')
		    App.content= App.content.replace('<c', '<c i="'+ imgSrc+'" ');
		    App.content= App.content.replace('<v', '<v i="'+ imgSrc+'" ');

	    	tempMsg= messageInput+'<br/>'+App.content;
		}  else{
			tempMsg=messageInput;
		} 	
	imgSrc='';
	return tempMsg;
}
function isBlank(str) {
    return (!str || /^\s*$/.test(str));
}

var turnBack = false;

function IsValidImageUrl(url) {

    $("<img>", {

        src: url,
        error: function () {
            sertTurnBack(false);
        },
        load: function () {
            sertTurnBack(true);
        }
    });

    return turnBack;
}

function sertTurnBack(bool) {
    turnBack = bool;

}

function UrlGetir(gelenBilgi) {
	//var UrlRegex = new RegExp(/(((ftp|https?):\/\/)[\-\w@:%_\+.~#?,&\/\/=]+)|((mailto:)?[_.\w-]+@([\w][\w\-]+\.)+[a-zA-Z]{2,3})/g);
	var UrlRegex = new RegExp(/(\b(?:(https?|ftp):\/\/)?((?:www\d{0,3}\.)?([a-z0-9.-]+\.(?:[a-z]{2,4}|museum|travel)(?:\/[^\/\s]+)*))\b)/gi);
	var Dizi = gelenBilgi.split(/\s/g);
 
	var Sonuc = null;
	$.each(Dizi, function(Key, Value){
		Sonuc = Value.match(UrlRegex);
	});
	
	return Sonuc;
}
$(document).ready(function () {
 
    	startFunc();
   

});

function startFunc(){
    var getUrl = $('#globalTextArea'); //url to extract from text field
    var extracted_images;
   
    
    $('#globalTextArea').focus(function() {
    	 if(App.active_room().usage_type_id==1)
    	   		$("#usageContent").slideUp();
    });
    
    $("#searchInput").keyup(function(event){
    	
    	
    	
        if(event.keyCode == 13){
                $("#searchButton").click();
        }
    
    });
    $("#globalTextArea").keyup(function(ev){
     
    	App.message_key('', ev);
	
    });

    getUrl.bind('input propertychange', function()
    { //user types url in text field		
        //url to match in the text field
       if($("#results").html().length>0) return false;
        result = "";

      //  var match_url = new RegExp("\b(https?|ftp|file)://[-A-Z0-9+&@#/%?=~_|!:,.;]*[A-Z0-9+&@#/%=~_|]");
        extracted_url=UrlGetir($.trim(getUrl.val()));
        //returns true and continue if matched url is found in text field
        if (extracted_url!=null) {
            $("#loading_indicator").show(); //show loading indicator image
            extracted_url=extracted_url[0];
            
       //     var extracted_url = getUrl.val().match(match_url)[0]; //extracted first url from text filed
            if (IsValidImageUrl(extracted_url)) {

                turnBack = false;
                    
                   // 1- For database. 
                  App.content= '<i s="' + extracted_url + '"/></i>';

 

                    // 2-Just for demonstrate on results div.
                    var htmlInput = '<ul class="gallery clearfix"><li><a href=' + extracted_url + ' rel="prettyPhoto[gallery1]">' + '<img width="60px"  height="60px" onclick="callPrettyPhoto();" src=' + extracted_url + '></img></a></li></ul>';

                    $("#results").html("<p>" + htmlInput + "</p>");
                    $("#results").slideDown(); //show results with slide down effect
                    $("#loading_indicator").hide(); //hide loading indicator image  
                    

             } else //If it is not just image and has URL content...
                {

            	var htmlInput='';

                 

                var total_images ='';
                var img_arr_pos =1;
                var dataContent='';
                var dataTitle='';
                var imgSelect='';
               
                var functionUrl = window.location.origin+ '/templates/default/pages/extract-process.php';
                var argJson = {
                    'url': extracted_url
                };
                
                
                
                $.ajax({
    				type: "POST",
    				url: functionUrl,
    				dataType: "json",
    				data:argJson,
    				success:function (data) {

                        extracted_images = data.images;
                        if(extracted_images!='')
                        total_images = parseInt(extracted_images.length);
                 
                        if (total_images -1> 0) {
                            imgSrc=data.images[img_arr_pos-1];

                            inc_image = '<div class="extracted_thumb" id="extracted_thumb"><img src="' + imgSrc + '" width="100" height="100"></div>';
                        
                            imgSelect=  '<span class="prev_thumb" id="thumb_prev">&nbsp;</span>'
                 	       +'<span class="next_thumb" id="thumb_next">&nbsp;</span>'
                 	       +' </div><span class="small_text" id="total_imgs">' 
                 	       + img_arr_pos 
                 	       + ' of ' 
                 	       + total_images
                 	       + '</span>'
                 	       +'<span class="small_text">&nbsp;&nbsp;Choose a Thumbnail</span>'
                        
                        
                        } else {
                            inc_image = '';
                        }
                        //content to be loaded in #results element
                         dataContent=data.content;
                         dataTitle=data.title;

                         htmlInput = '<div class="extracted_url">'
                        	       + inc_image 
                        	       + '<div class="extracted_content"><h4><a href="'
                        	       + extracted_url
                        	       + '" target="_blank">'
                        	       + dataTitle
                        	       +  '</a></h4><p>'
                        	       + dataContent
                        	       + '</p>'
                        	       +'<div class="thumb_sel">'
                        	       + imgSelect
                        	       +'</div></div>';
     
                         
                     	
                          //user clicks previous thumbail
                         $("body").on("click", "#thumb_prev", function (e) {
                             if (img_arr_pos > 1) {
                                 img_arr_pos--; //thmubnail array position decrement

                                 //replace with new thumbnail
                                 //imgSrc to write selected img into database.
                                 imgSrc= extracted_images[img_arr_pos-1];
                                 $("#extracted_thumb").html('<img src="' + imgSrc + '" width="100" height="100">');
                                
                                 //show thmubnail position
                                 $("#total_imgs").html((img_arr_pos) + ' of ' + total_images);
                             }
                         });

                         //user clicks next thumbail
                         $("body").on("click", "#thumb_next", function (e) {
                             if (img_arr_pos < total_images) {
                                 img_arr_pos++; //thmubnail array position increment

                                 //replace with new thumbnail
                                 //imgSrc to write selected img into database. Murat.
                                 imgSrc= extracted_images[img_arr_pos-1];
                               
                                 $("#extracted_thumb").html('<img src="' + imgSrc + '" width="100" height="100">');

                                 //replace thmubnail position text
                                 $("#total_imgs").html((img_arr_pos) + ' of ' + total_images);
                             }
                         });
                     	var value = extracted_url;
                          
                        //If it is a video url.       
                     	if (value!=null)
                         if  ( value.match('(http(s)?://)?(www.)?youtube|youtu\.be')
         			
         			                    || value.match(/vimeo\.com/i)
         			
         			                    || value.match(/dailymotion\.com/i)
         			
         			                    || value.match(/zapkolik\.com/i)
         			
         			                    || value.match(/nytimes\.com/i)
         			
         			                    || value.match(/reuters\.com/i)
         			
         			                    || value.match(/ustream\.tv/i)
         			
         			                    || value.match(/ted\.com/i)
         			                )

                         {
                                      //v: video content
                         	App.content= '<v ';

                         	App.content=App.content   +'s="'
                             + value 
                 			+'" dc="' + dataContent
                 			+'" dt="' + dataTitle
                             + '"></v>';
                         } else { 
                         	
                              
                         	
                                     //c: Custom Content
                            App.content= '<c ';
                         	App.content=App.content   +'s="'
                             + value 
                 			+'" dc="' + dataContent
                 			+'" dt="' + dataTitle
                             + '"></c>';
                         }
                    
                         $("#results").html("<p>" + htmlInput + "</p>");  
                         $("#results").slideDown(); //show results with slide down effect
                         $("#loading_indicator").hide(); //hide loading indicator image  
                           
                    
                    
                    
                    }

    					
    			});
                
                
                
                
                 
            	
            	
               
             

            }



        }
    });

    }