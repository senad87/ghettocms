<div class="headcont">
<script type="text/javascript" src="<?php echo base_url(); ?>application/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	window.onload = function()
	{
		
		CKEDITOR.replace( 'editor1',{skin : 'v2',
			filebrowserBrowseUrl: '<?php echo base_url(); ?>application/filemanager/index.html'} );
	};
</script>
<h1 class="heading">Edit Game</h1>
<?php echo modules::run('toolbar', 'game_title', 'game', array('save', 'cancel')); ?>
<div class="clear"></div>
</div>
<div class="container">
<?php echo form_open_multipart('game/edit_post/', array('id'=>'game_form'));?>
	<div class="right-panel">
	<h5>Choose category:</h5>
		<div class="box-right-panel">
			<div class="box-right-panel-inbox">
			<ul class="categories_list_rc">
					<?php foreach ($root_categories as $category) { ?>
					<li>
					<?php
					if (check_category_kids($category->id) == 0) {?>
					<input <?php if($category->id == $set_category) {?>checked="yes"<?php } ?> type="radio" name="category_id" class="radio_category_id" value="<?php echo $category->id; ?>"/>
					<? } ?>
					<a href="#"><?php echo $category->name; ?></a>
					<?php recursion_categories_edit_radio($category->id, $set_category); ?>
					</li>
					<?php } ?>
			</ul>
			</div><!--end of box-right-panel-inbox -->
		</div><!--end of box-right-panel -->
	</div><!--end of right-panel -->
	<div class="left-panel">
	
		<label for="title"><strong>Game official name:</strong></label><br />
		<input class="lform2" style="width: 700px;" type="title" name="title" size="50" value="<?php echo $entry->title; ?>"><br />
		<input  type="hidden" name="id" value="<?php echo $game->id; ?>">
		<input  type="hidden" name="entry_id" value="<?php echo $entry->id; ?>">
		<label for="title"><strong>Game Release date:</strong></label><br />
		<input class="lform2" style="width: 150px;" type="text" id="datepicker" name="release_date" size="20" value="<?php echo mysql_to_human($game->release_date); ?>"><br />
		<label for="lead"><strong>Lead:</strong></label><br />
		<textarea class="lform2-textarea" style="width: 700px;" name="lead" cols="50" rows="5"><?php echo $game->lead; ?></textarea><br />
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
		<textarea name="editor1" cols="20" rows="10" ><?php echo $game->body; ?></textarea>
		<div class="tag-filters">
		
		<?php if(count($topics) > 0) { ?>
		  <?php $i = 0;
		  foreach ($topics as $topic) { ?>
			  <?php if(count($tags[$topic->id]) > 0){ ?>
			    <label for="privileges"><?php echo $topic->name; ?>:</label><br />
			    <select class="filter" name="tag_<?php echo $i; ?>">
				<option>Please select tag ...</option>  
			  	<?php foreach($tags[$topic->id] as $tag) { ?>
				  <option <?php if(isset($set_tags[$topic->id]) && $set_tags[$topic->id] == $tag->id){?>selected="selected"<?php } ?> value="<?php echo $tag->id; ?>"><?php echo $tag->tag; ?></option>
				  <?php } ?>
			    </select><br />
			  <?php } ?>
		  <?php $i++; } ?>
        	<?php } ?>
        </div>
	</div><!--end of left-panel-->
	</form>
	<div class="clear"></div>
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
