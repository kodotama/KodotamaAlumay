<?php $display('layout/header'); ?>
<p><?php $lang('register_instructions'); ?></p>
<form action="<?php $url('doregister'); ?>" method="post">
 <ul>
  	<li>
  	<label for="username"><?php $lang('username_label'); ?></label> 
  	 <br/>
  	<input
		type="text" name="username" id="username"
		value="<?php $var('username'); ?>" />
  	</li>
  	
  	<li>
  	 <label for="email"><?php $lang('email_label'); ?></label>
  	 <br/>
	<input type="text" name="email" id="email"
		value="<?php $var('email'); ?>" />
  	</li>
 
  	<li>
  	 <label for="password"><?php $lang('password_label'); ?></label>
  	 <br/>
	<input type="password" name="password" id="password" value="" /> 
  	</li>
   
   <li>
    
	<label
		for="repassword"><?php $lang('retype_password_label'); ?></label>
		<br/>
		 <input
		type="password" name="repassword" id="repassword" value="" />
   
   </li>
   
   <li>
   <input
		type="submit" id="register_button" name="register_button"
		value="<?php $lang('register_button'); ?>" /> <a
		href="<?php $url('login'); ?>" id="login_button"><?php $lang('login_link'); ?></a>
   </li>
 </ul>
 
</form>
<?php $display('layout/footer'); ?>