<div class="headcont">
<script type="text/javascript" src="<?php echo base_url(); ?>application/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	window.onload = function()
	{
		CKEDITOR.replace( 'editor1',{skin : 'v2',
			filebrowserBrowseUrl: '<?php echo base_url(); ?>application/filemanager/index.html'} );
	};
</script>
	<h1 class="heading">Edit Story</h1>
<?php echo modules::run('toolbar', 'banners_title', 'banners', array('save', 'cancel')); ?>
	<div class="clear"></div>
</div>
<div class="container">
<div style="display:none" id="message"></div>
<?php echo form_open_multipart( 'banners/edit_post/', array( 'id'=>'banners_form' ) );?>
	
	<div class="right-panel">
	
	</div><!--end of right-panel -->
	<div class="left-panel">
		<label for="title"><strong>Title:</strong></label><br />
		<input class="lform2 required"  type="text" name="title" size="50" value="<?php echo $item->name; ?>"><br />
		<input  type="hidden" name="item_id" value="<?php echo $item->id; ?>"><br />
		<label for="lead"><strong>Description:</strong></label><br />
		<textarea class="lform2-textarea required" style="width: 700px;" name="lead" cols="50" rows="5"><?php echo $item->description; ?></textarea><br />
                <label for="title"><strong>Url:</strong></label><br />
                <input class="lform2" style="width: 700px;" type="text" name="url" size="50" value="<?php echo $item->url; ?>"><br />
		<label for="title"><strong>Activation Date:</strong></label><br />
		<input class="lform2" style="width: 150px;" id="datepicker" type="text" name="activation_date" size="20" value="<?php echo $modified_date; ?>"><br />
		<?php if( isset( $item->file_location ) && $item->file_location != ""){ ?>
			<div id="thumb_image">
				<label for="body"><strong>Poster photo:</strong></label><br />
				<img alt="thumb_image" src="<?php echo base_url(); ?><?php echo $item->file_location; ?>" /><br />
				<input type="hidden" name="file_location" value="<?php echo $item->file_location; ?>"/>
				<input class="button-1" id="btnRemovePhoto" type="button" value="Remove Photo"><br />
			</div>
			<div id="upload_photo" style="display:none;">
				<label for="body"><strong>Upload Poster Photo:</strong></label><br />
				<input type="file" name="image_file" size="30"><br />
			</div>
		<?php }else{ ?>
			<label for="body"><strong>Upload Poster Photo:</strong></label><br />
			<input type="file" name="image_file" size="30"><br />
		<?php } ?>
	</div><!--end of left-panel-->
	<div class="clear"></div>
	</form>
</div>	
</body>
<script type="text/javascript">
$( "#datepicker" ).datepicker({
	showButtonPanel: true
});
$('#btnRemovePhoto').click(function ()
{
	$("#upload_photo").removeAttr("style");
	$("#thumb_image").empty();
});
</script>
</html>
