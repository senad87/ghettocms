<?php $this->load->view("header_view"); ?>
<div class="headcont">
<h1 class="heading">Add New User</h1>

 
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
	<?php echo form_open('admin_user/add_new/'); ?>
		<label for="title"><strong>Name:</strong></label><br />
		<input class="lform2" type="text" name="name" size="20" value="<?php echo set_value('name'); ?>"><br />
		<label for="lead"><strong>Username:</strong></label><br />
		<input class="lform2" type="text" name="username" size="20" value="<?php echo set_value('username'); ?>"><br />
		<label for="lead"><strong>E-mail:</strong></label><br />
		<input class="lform2" type="text" name="email" size="20" value="<?php echo set_value('email'); ?>"><br />
		<label for="lead"><strong>Password:</strong></label><br />
		<input class="lform2" type="password" name="password" size="20"><br />
		<label for="lead"><strong>Retype password:</strong></label><br />
		<input class="lform2" type="password" name="repassword" size="20"><br />
		<label for="lead"><strong>Select user role:</strong></label><br />
		<select class="filter2" name="role">
			<?php foreach($roles as $role){ ?>
			<option value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
			<?php } ?>
		</select><br />
		<input class="button-1" type="submit" id="submit_story_button" value="Add user" style="float: left;"> 
	</form><input class="button-1" type="button" id="btnCancel" value="Cancel">
</div>
   
<div class="clear"></div>
</div>    
</body>
<script type="text/javascript">
$(document).ready(function(){
	
	$('#btnCancel').click(function (){
	    $(window.location).attr("href", "<?php echo base_url(); ?>admin_user");
	});

});	
</script>
</html>
