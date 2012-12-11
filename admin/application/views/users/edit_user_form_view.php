<?php $this->load->view("header_view"); ?>
<div class="headcont">
<h1 class="heading">Edit User</h1>

 
	<?php if (isset($message)) {
		if($message <> ""){ ?>
			 <div class="message" id="message"><?php echo $message; ?></div>
		<?php } ?>
	<?php } ?>
	
<div class="clear"></div>
</div>
<div class="container">
<div class="right-panel">
<h5>Properties</h5>
<div class="box-right-panel">
<div class="box-right-panel-inbox">
There is no properties for this item.

</div>
</div>

</div>
<div class="left-panel">


	<?php echo validation_errors('<div class="error">', '</div>'); ?>
	<?php echo form_open('admin_user/update_data/'); ?>
		<input type="hidden" name="id" size="20" value="<?php echo $user->id; ?>">
		<label for="title"><strong>Name:</strong></label><br />
		<input class="lform2" type="text" name="name" size="20" value="<?php echo $user->name; ?>"><br />
		<label for="lead"><strong>Username:</strong></label><br />
		<input class="lform2" type="text" name="username" size="20" value="<?php echo $user->username; ?>"><br />
		<label for="lead"><strong>E-mail:</strong></label><br />
		<input class="lform2" type="text" name="email" size="20" value="<?php echo $user->email; ?>"><br />
		<label for="lead"><strong>Password:</strong></label><br />
		<input class="lform2" type="password" name="password" size="20"><br />
		<label for="lead"><strong>Retype password:</strong></label><br />
		<input class="lform2" type="password" name="repassword" size="20"><br />
		<label for="lead"><strong>Select user role:</strong></label><br />
		<select class="filter2" name="role">
			<?php foreach($roles as $role){ ?>
			<option value="<?php echo $role->id; ?>" <?php if($user->group_id == $role->id){ echo "selected='selected'"; }?> ><?php echo $role->name; ?></option>
			<?php } ?>
		</select><br />
		<input class="button-1" type="submit" id="submit_user_button" value="Save changes" style="float: left;">	
	</form>
	<button type="submit" class="button-1" id="btnCancel">Cancel</button>
</div>
   
<div class="clear"></div>    
</div>    
</body>
<script type="text/javascript">
$('#btnCancel').click(function() {
	 $(window.location).attr("href", "<?php echo base_url(); ?>admin_user");
});
</script>
</html>
