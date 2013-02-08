<div class="headcont">
<script type="text/javascript" src="<?php echo base_url(); ?>system/application/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	window.onload = function()
	{
		CKEDITOR.replace( 'editor1',{skin : 'v2'} );
	};
</script>
<h1 class="heading">Add New Game</h1>
	<?php if (isset($message)) {
		if($message <> ""){ ?>
			 <div class="message" id="message"><?php echo $message; ?></div>
		<?php } ?>
	<?php } ?>
	<?php if(isset($error)){ 
	echo $error;
	}?>
<div class="clear"></div>
</div>
<div class="container">
	<div class="right-panel">
	<h5>Choose category:</h5>
		<div class="box-right-panel">
			<div class="box-right-panel-inbox">
			</div><!--end of box-right-panel-inbox -->
		</div><!--end of box-right-panel -->
	</div><!--end of right-panel -->
	<div class="left-panel">
	<?php echo form_open_multipart('template/add');?>
		<label for="title"><strong>Template name:</strong></label><br />
		<input class="lform2" style="width: 700px;" type="text" name="name" size="50" value=""/><br />
		<label for="lead"><strong>Number of positions:</strong></label><br />
		<input class="lform2" style="width: 700px;" type="text" name="num_of_positions" size="50" value=""/><br />
		<label for="body"><strong>Upload file:</strong></label><br />
		<input type="file" name="template_file" size="30"><br />
	  <div class="tag-filters">
		<input class="button-1" type="submit" id="submit_story_button" value="Add template">
		<input class="button-1" type="button" id="" value="Cancel">
	</div><!--end of left-panel-->
	<div class="clear"></div>        
</div>
</form>    
</body>
</html>