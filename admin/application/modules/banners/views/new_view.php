<div class="headcont">
<script type="text/javascript" src="<?php echo base_url(); ?>application/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	window.onload = function()
	{
		
                var currentInstance = CKEDITOR.replace( 'editor1', {skin : 'v2',
			filebrowserBrowseUrl: '<?php echo base_url(); ?>application/filemanager/index.html'} );

	};

</script>
<h1 class="heading">Add New Banner</h1>
<?php echo modules::run('toolbar', 'banners_title', 'banners', array('save', 'cancel')); ?>
<div class="clear"></div>
</div>
<?php echo form_open_multipart('banners/createNew_post/', array('id'=>'banners_form'));?>
<div class="container">
	<div class="right-panel">
	 
	</div><!--end of right-panel -->
<div class="left-panel">
    
	<label for="title"><strong>Title:</strong></label><br />
	<input class="lform2" style="width: 700px;" type="text" name="title" size="50" value=""><br />
	<label for="lead"><strong>Description:</strong></label><br />
	<textarea class="lform2-textarea" style="width: 700px;" name="lead" cols="50" rows="5"></textarea><br />
	<label for="title"><strong>Url:</strong></label><br />
	<input class="lform2" style="width: 700px;" type="text" name="url" size="50" value=""><br />
        <label for="title"><strong>Activation Date:</strong></label><br />
	<input class="lform2 required" style="width: 150px;" id="datepicker" type="text" name="activation_date" size="20" value=""><br />
	<label for="body"><strong>Upload Photo:</strong></label><br />
	<input type="file" name="image_file" size="30"><br />
	<label for="body"><strong>Dimensions: </strong></label><br />
        
</div><!--end of left-panel-->
<div class="clear"></div>        
</div>
</form>    
</body>
<script type="text/javascript" src="<?php echo base_url(); ?>system/application/style/js/tag-it.js"></script>
<script type="text/javascript">
$(document).ready(function(){

	$( "#datepicker" ).datepicker({
		showButtonPanel: true
	});
	$( "#datepicker" ).datepicker('setDate', new Date());
        
});	
</script>
</html>