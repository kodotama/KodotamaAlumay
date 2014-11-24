<?php if(isset($menu)): ?>
<ul <?php if(isset($class)) echo "class='{$class}'"; ?>>
		<?php foreach($menu as $key => $item): ?>
		    <?php 
		     $user = new x7_user ();
			 $perms = $user->permissions ();
		     if(isset($perms ['access_admin_panel']) && 
		      !empty($perms ['access_admin_panel']) || 
		       $item['href']=='admin_edit_room' ||
		       $item['href']=='admin_list_rooms'): ?>
			<?php if(!$item['hidden']): ?>
				<li data-href="<?php echo $item['href']; ?>"
		<?php if($item['active']) echo "class='active'"; ?>>
					<?php echo $item['label']; ?>
					<?php if($item['items'] && $item['active']): ?>
						<?php
				
$display ( 'components/admin/submenu', array (
						'menu' => $item ['items'],
						'class' => '' 
				) );
				?>
					<?php endif; ?>
				</li>
			<?php endif; ?>
		 <?php endif; ?>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>