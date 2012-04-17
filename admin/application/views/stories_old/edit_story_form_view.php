<div class="headcont">
<script type="text/javascript" src="<?php echo base_url(); ?>system/application/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	window.onload = function()
	{
		CKEDITOR.replace( 'editor1',{skin : 'v2',
			filebrowserBrowseUrl: '<?php echo base_url(); ?>system/application/filemanager/index.html'} );
	};
</script>
	<h1 class="heading">Edit Story</h1>
	<?php if (isset($message)) {
		if($message <> ""){ ?>
			 <div class="message" id="message"><?php echo $message; ?></div>
		<?php } ?>
	<?php } ?>
	<div class="clear"></div>
</div>
<div class="container">
<?php echo form_open_multipart('story/update_data/');?>
	
	<div class="right-panel">
	<h5>Choose category:</h5>
		<div class="box-right-panel">
			<div class="box-right-panel-inbox">
			<ul class="categories_list_rc">
					<?php foreach ($root_categories as $category) { ?>
					<li>
					<?php
					if (check_category_kids($category->id) == 0) {?>
					<input <?php if(in_array($category->id, $set_categories)) {?>checked="yes"<?php } ?> type="checkbox" name="category_<?php echo $category->id; ?>" class="radio_category_id" value="<?php echo $category->id; ?>"/>
					<? } ?>
					<a href="#"><?php echo $category->name; ?></a>
					<?php recursion_categories_edit_checkbox($category->id, $set_categories); ?>
					</li>
					<?php } ?>
			</ul>
			</div><!--end of box-right-panel-inbox -->
		</div><!--end of box-right-panel -->
	</div><!--end of right-panel -->
	<div class="left-panel">
		<label for="title"><strong>Title:</strong></label><br />
		<input class="lform2" style="width: 700px;" type="text" name="title" size="50" value="<?php echo $story->title; ?>"><br />
		<label for="headline"><strong>Headline:</strong></label><br />
		<input class="lform2" style="width: 700px;" type="text" name="headline" size="50" value="<?php echo $story->headline; ?>"><br />
		<input  type="hidden" name="entry_id" value="<?php echo $entry_id; ?>"><br />
		<label for="lead"><strong>Lead:</strong></label><br />
		<textarea class="lform2-textarea" style="width: 700px;" name="lead" cols="50" rows="5"><?php echo $story->lead; ?></textarea><br />
		<label for="title"><strong>Date:</strong></label><br />
		<input class="lform2" style="width: 150px;" id="datepicker" type="text" name="creation_date" size="20" value="<?php echo $modified_date; ?>"><br />
		<?php if(isset($thumb_image) && $thumb_image[0]->id > 0){ ?>
			<div id="thumb_image">
				<label for="body"><strong>Poster photo:</strong></label><br />
				<img alt="thumb_image" src="<?php echo base_url(); ?><?php echo $thumb_image[0]->path; ?>" /><br />
				<input type="hidden" name="image_id" value="<?php echo $thumb_image[0]->id; ?>"/>
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
		<label for="body"><strong>Body:</strong></label><br />
		<textarea class="lform2-textarea" style="width: 700px;" name="editor1" cols="20" rows="10"><?php echo $story->body; ?></textarea><br />
		<div class="tag-filters">
		<?php if(count($topics) > 0) { ?>
		  <?php 
		  $i = 0;
		  foreach ($topics as $topic) { ?>
		    <label for="privileges"><?php echo $topic->name; ?>:</label><br />
		    <select class="filter" name="tag_<?php echo $i; ?>">
		    <option value="0">PLEASE CHOOSE:</option>
			  <?php foreach($tags[$topic->id] as $tag) { ?>
				  <?php if(isset($set_tags[$topic->id])) {?>
				  <option <?php if($set_tags[$topic->id] == $tag->id){?>selected="selected"<?php } ?> value="<?php echo $tag->id; ?>"><?php echo $tag->tag; ?></option>
				  <?php }else{ ?>
				  <option value="<?php echo $tag->id; ?>" ><?php echo $tag->tag; ?></option>
				  <?php } ?>
			  <?php } ?>
		    </select><br />
		  <?php $i++; } ?>
        <?php } ?>
        </div>
		<input type="hidden" name="story_id" value="<?php echo $story->id; ?>">
		<input class="button-1" type="submit" value="Save changes" style="float: left;"><input class="button-1" id="btnCancel" type="button" value="Cancel">
		</div><!--end of left-panel-->
		<div class="clear"></div>
		</form>
</div>
	
	
</body>
<script type="text/javascript">
$( "#datepicker" ).datepicker({
	showButtonPanel: true
});

$('#btnCancel').click(function ()
    {
        $(window.location).attr("href", "<?php echo base_url(); ?>story");

    });
$('#btnRemovePhoto').click(function ()
	{
		$("#upload_photo").removeAttr("style");
		$("#thumb_image").empty();
	});
</script>   
</html>