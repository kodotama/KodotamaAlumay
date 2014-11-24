<div id="title_def"><?php $lang('roomlist_title'); ?></div>
<?php $lang('roomlist_instructions'); ?>
<table class="data_table" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th><?php $lang('room_name'); ?></th>
			<th><?php $lang('room_topic'); ?></th>
 		</tr>
	</thead>
	<tbody>
		<?php foreach($rooms as $room): ?>
			<tr>
						<?php 
				
				$usageTypeText="";
                $key=$room['usage_type_id'];
			    switch ($key) {
							case "0":
								 $usageTypeText="$";
							     break;
							case "1":
								 $usageTypeText="!";
						     break;
							case "2":
								 $usageTypeText="~";
							    break;
							case "3":
								 $usageTypeText="#";
			                 	break;
							case "4":
								 $usageTypeText="@";
			                   break;
						
						}
						?>
				
			<td> <a href='#' class='join_room_button'
		    	data-room-id='<?php echo $room['id']; ?>'> <?php $esc($usageTypeText).$esc($room['name']); ?></a> </td>
			<td><?php $esc($room['topic']); ?></td>
			 
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<script type="text/javascript">


$('.join_room_button').bind('click', function() {
	var room_id = $(this).attr('data-room-id');
	RoomConstruction.joinRoom(room_id, 0, 0, 0);
});


 
		 


	
</script>