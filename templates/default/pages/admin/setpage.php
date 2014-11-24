 <div id="admin_content">
 
	<form class="standard_form" data-action="do_setpage">
	<?php $display( 'layout/messages'); ?>
 
 	   	<ul id="ulId">
		   <li>
		  <input type="text" name="pageName" id="pageName"  
	    	       />
	    	</li>
		   <li>
		  	
	    	 <textarea name="hashtags" id="hashtags"   style="width: 349px;"  placeholder="<?php $lang( 'hashtags'); ?>"  
	    	       ></textarea>
		  	
		  	</li>
		  	 
		</ul>
			<input type="submit" value="<?php $lang('save_room_button'); ?>" />
		
</form>
</div>