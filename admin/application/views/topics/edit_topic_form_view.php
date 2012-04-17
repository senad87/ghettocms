<div class="headcont">
<h1 class="heading">Edit Topic</h1>
	<?php if (isset($message)) {
		if($message <> ""){ ?>
			 <div class="message" id="message"><?php echo $message; ?></div>
		<?php } ?>
	<?php } ?>	
<div class="clear"></div>
</div>
<div class="container">
<?php echo form_open('topic/update_data/'); ?>
<div class="right-panel">
	<h5>Properties</h5>
	<div class="box-right-panel">
		<div class="box-right-panel-inbox">
		Link topic to:
		<select class="filter" name="entry_type">
			<option value="0">NONE</option>
			  <?php foreach($entry_types as $entry_type) { ?>
			  <option value="<?php echo $entry_type->id; ?>" <?php if($used_entry_type == $entry_type->id){?>selected="selected"<?php } ?> > <?php echo $entry_type->type_name; ?></option>
			  <?php } ?>
		</select><br />
		</div>
	</div>
</div><!-- end of right panel -->
<div class="left-panel">
	<?php echo validation_errors('<div class="error">', '</div>'); ?>
	
		<label for="title"><strong>Topic name:</strong></label><br />
		<input class="lform2" type="text" name="name" size="20" value="<?php echo $topic->name; ?>"><br />
		<label for="title"><strong>Topic description:</strong></label><br />
		<input class="lform2" type="text" name="description" size="20" value="<?php echo $topic->description; ?>"><br />
		<input type="hidden" name="id" id="topic_id" value="<?php echo $topic->id; ?>">
		<br />
		<input class="button-1" type="submit" id="submit_story_button" value="Save changes">
		<input class="button-1" type="button" id="btnCancel" value="Cancel">  
<br />
</div>
<div class="clear"></div>     
</div>
</form>
</body>
<script type="text/javascript">
$('#btnCancel').click(function ()
{
	$(window.location).attr("href", "<?php echo base_url(); ?>topic");

});
</script>
</html>
