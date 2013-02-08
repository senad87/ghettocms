<h3>Create New User</h3>
       <form action="<?php echo base_url(); ?>users/createNew_post/" class="jNice" method="post">
          <?php echo $this->form_validation->error_string; ?>
          <fieldset>
         <p><label>Username: </label>
		<input name="username" type="text" class="text-long" value="<?php echo set_value('username'); ?>" />
		<span style="color: #C66653"><?php echo form_error('username'); ?></span></p>
	<!-- <p><label>First name: </label>
		<input name="firstName" type="text" class="text-long" value="<?php echo set_value('firstName'); ?>" />
		<span style="color: #C66653"><?php echo form_error('firstName'); ?></span></p>
	<p><label>Last Name: </label>
		<input name="lastName" type="text" class="text-long" value="<?php echo set_value('lastName'); ?>"/>
		<span style="color: #C66653"><?php echo form_error('lastName'); ?></span></p>-->
	<p><label>Email: </label>
		<input name="email" type="text" class="text-long" value="<?php echo set_value('email'); ?>" />
		<span style="color: #C66653"><?php echo form_error('email'); ?></span></p>
	<p><label>Password: </label>
		<input name="password" type="password" class="text-long" value="<?php echo set_value('password'); ?>"/>
		<span style="color: #C66653"><?php echo form_error('password'); ?></span></p>
	<p><label>Verify Password: </label>
		<input name="passconf" type="password" class="text-long" value="<?php echo set_value('passconf'); ?>" />
		<span style="color: #C66653"><?php echo form_error('passconf'); ?></span></p>
		<input type="submit" value="Create" />
         </fieldset>
</form>
