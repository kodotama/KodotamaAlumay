
<span  id="messageSpan"></span>
<p/>
<div id="title_def"><?php $lang('roompass_title'); ?></div>
 
<?php $lang('roompass_instructions'); ?>

 <label for="room_password"><?php $lang('roompass_label'); ?></label> <input
		type="password" name="room_password" id="room_password" /> 

 <input type="button" value="<?php $lang('continue_button'); ?>" 
		        id="roompass_button"
		       
		       />
		       
		       
 <script type="text/javascript">
	$("#roompass_button").click(function() {
		var pass = $('#room_password').val();

		RoomConstruction.setPass(pass);
		RoomConstruction.joinRoom(<?php  echo $room_id; ?>);		
 		return false;
	});
</script>