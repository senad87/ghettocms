<div class="headcont">
<h1 class="heading">Add New Topic</h1>
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
	<?php echo form_open('topic/add/'); ?>
		<label for="title"><strong>Topic name:</strong></label><br />
		<input class="lform2" type="text" name="name" size="20" value=""><br />
		<label for="title"><strong>Topic description:</strong></label><br />
		<input class="lform2" type="text" name="description" size="20" value=""><br />
		<br />

		<input class="button-1" type="submit" id="submit_story_button" value="Add Topic"> <input class="button-1" type="button" id="btnCancel" value="Cancel">
	</form>    
</div>
<div class="clear"></div>     
</div>    
</body>
</html>
<script type="text/javascript">
$(document).ready(function(){
	$('#btnCancel').click(function (){
		    $(window.location).attr("href", "<?php echo base_url(); ?>topic");
	});
});
</script>	