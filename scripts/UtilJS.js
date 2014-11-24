var  UtilJS = new function(){
	this.spanToShowMsg='';

	this.usageTypes={
			   "compa": 0,
			   "miss": 1,
			   "dict": 2,
			   "hash": 3,
			   "pblog": 4
				};
	// Native implementation
	this.isNaN=function(x) {
	  // Coerce into number
	  x = Number(x);
	  // if x is NaN, NaN != NaN is true, otherwise it's false
	  return x != x;
	};
	
	this.getUrlParamString=function(urlParamArray){
		var urlParamString="";
		i=0;
		for(var k in urlParamArray) {
			if(i>0)
			urlParamString=urlParamString+"&";
			
			urlParamString=urlParamString+k+ "=" +  urlParamArray[k];
			i++;
			};
		 return	urlParamString;
	};
	
	this.replaceAt=function(index, eraseChar, character, text){
		 if(text.substr(index, index+1)!=eraseChar) return text;
		 var returnStr=text.substr(0, index) + character + text.substr(index+1, text.length);
	      return returnStr;
	};
	
 
	this.showMessages= function(type, message,navigate,urlRoom){
		 
		 if(this.spanToShowMsg=='')
			 this.spanToShowMsg='#msgModal';
			 
		var messageSpan = $(this.spanToShowMsg);
		messageSpan.addClass(type);
 		if(navigate>=0) // if usage_type is DICTIONARY
		{
			message=message.trim();
			var roomNameStr=message.replace(/\s+/g, '+').toLowerCase();
			urlRoom=urlRoom
			+"&usageTypeId="+navigate
			+"&roomNameStr="+ roomNameStr;
		 
			urlRoom='<a href="#" onclick=open_content_area("'+urlRoom+'")>'+ youcreate+'</a>';
			
 			messageSpan.html(message+":"+urlRoom);
        }else{
        	messageSpan.text(message);
        }
 		messageSpan.dialog();
	};
	
	//For todays date;
	Date.prototype.today = function(){ 
	    return ((this.getDate() < 10)?"0":"") + this.getDate() +"/"+(((this.getMonth()+1) < 10)?"0":"") + (this.getMonth()+1) +"/"+ this.getFullYear() 
	};
	//For the time now
	Date.prototype.timeNow = function(){
	     return ((this.getHours() < 10)?"0":"") + this.getHours() +":"+ ((this.getMinutes() < 10)?"0":"") + this.getMinutes() +":"+ ((this.getSeconds() < 10)?"0":"") + this.getSeconds();
	};
  this.getCurrentDateTime =function(){
		 var newDate = new Date();
		 var dateTime = newDate.today() + " " + newDate.timeNow();
		 return dateTime;
	}
  
};