<?php $display('layout/header');
$_SESSION ['forward_url']="";
?>
<div id="loginPart">
<?php if(!empty($news)): ?>
<div class='login_page_news' >
			<?php echo nl2br($news); ?>
		</div>
<?php endif; ?>
<p><?php $lang('login_instructions'); ?></p>
<form action="<?php $url('dologin'); ?>" method="post">
 <ul>
 	<li>
 	<label for="email"><?php $lang('email_label'); ?></label>
 		 <br/>
 	 <input
		type="text" name="email" id="email"
		value="<?php $var('email'); ?>" />
 	</li>
 	
 	<li>
 	 <label for="password"><?php $lang('password_label'); ?></label>
 	 	 <br/>
	<input type="password" name="password" id="password" value="" />
 	</li>
 	
 	<li>
 	 <input
		type="submit" id="login_button" name="login_button"
		value="<?php $lang('login_button'); ?>" />
 	</li>
 	<li>
 	 	<a href="<?php $url('register'); ?>" id="register_button" style="color: blue"><?php $lang('register_button'); ?></a>
		 <a href="<?php $url('resetpassword'); ?>" id="resetpass_button" style="color: blue"><?php $lang('resetpass_button'); ?></a>
 	</li>
 	
	
 </ul>

</form>



</div>

<?php $display('layout/footer'); ?>