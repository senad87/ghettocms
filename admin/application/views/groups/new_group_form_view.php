<?php $this->load->view("header_view"); ?>
<h1>Add New User</h1>
	<?php echo validation_errors('<div class="error">', '</div>'); ?>
	<?php echo form_open('admin_user/add_new/'); ?>
		<label for="title">Group Name:</label>
		<input type="text" name="name" size="20" value=""><br />
		
		<label for="privileges">Select group privileges:</label>
		<select name="privileges">
			<?php foreach($roles as $role){ ?>
			<option value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
			<?php } ?>
		</select><br />
		<input type="submit" id="submit_story_button" value="Add user">
	</form>
</body>
</html>
