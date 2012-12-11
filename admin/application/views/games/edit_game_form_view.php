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
	
<div class="clear"></div>
</div>
<div class="container">
<form method="POST" action="<?=base_url(); ?>game/update_data/">

	<div class="right-panel">
	<h5>Choose category:</h5>
		<div class="box-right-panel">
			<div class="box-right-panel-inbox">
			<ul class="categories_list_rc">
					<?php foreach ($root_categories as $category) { ?>
					<li>
					<?php 
				//var_dump($set_categories);
					if (check_category_kids($category->id) == 0) {?>
					<input <?php if(in_array($category->id, $set_categories)) {?>checked="yes"<?php } ?> type="checkbox" name="category_<?php echo $category->id; ?>" class="radio_category_id" value="<?php echo $category->id; ?>"/>
					<? } ?>
					<a href="<?=base_url(); ?>category/edit/<?php echo $category->id; ?>"><?php echo $category->name; ?></a>
					<?php recursion_categories_edit_checkbox($category->id, $set_categories); ?>
					</li>
					<?php } ?>
			</ul>
			</div><!--end of box-right-panel-inbox -->
		</div><!--end of box-right-panel -->
	</div><!--end of right-panel -->
	<div class="left-panel">
	
		<label for="title"><strong>Game official name:</strong></label><br />
		<input class="lform2" style="width: 700px;" type="title" name="title" size="50" value="<?php echo $game->game_name; ?>"><br />
		<input  type="hidden" name="id" value="<?php echo $game->id; ?>">
		<input  type="hidden" name="entry_id" value="<?php echo $entry_id; ?>">
		<label for="title"><strong>Game Release date:</strong></label><br />
		<input class="lform2" style="width: 150px;" type="text" id="datepicker" name="release_date" size="20" value="<?php echo mysql_to_human($game->release_date); ?>"><br />
		<label for="lead"><strong>Lead:</strong></label><br />
		<textarea class="lform2-textarea" style="width: 700px;" name="lead" cols="50" rows="5"><?php echo $game->lead; ?></textarea><br />
		<label for="body"><strong>Body:</strong></label><br />
		<textarea name="editor1" cols="20" rows="10" ><?php echo $game->body; ?></textarea>
		<div class="tag-filters">
		<?php if(count($topics) > 0) { ?>
		  <?php 
		  $i = 0;
		  foreach ($topics as $topic) { ?>
		    <label for="privileges"><?php echo $topic->name; ?>:</label><br />
		    <select class="filter" name="tag_<?php echo $i; ?>">
			  <?php foreach($tags[$topic->id] as $tag) { ?>
			  <option <?php if($set_tags[$topic->id] == $tag->id){?>selected="selected"<?php } ?> value="<?php echo $tag->id; ?>"><?php echo $tag->tag; ?></option>
			  <?php } ?>
		    </select><br />
		  <?php $i++; } ?>
        <?php } ?>
        </div>
		<input class="button-1" type="submit" id="submit_story_button" value="Save Changes" style="float: left;"><input class="button-1" id="btnCancel" type="button" value="Cancel">
	</div><!--end of left-panel-->
	</form>
	<div class="clear"></div>
</div>
</body>
<script type="text/javascript">
$(function() {
	$( "#datepicker" ).datepicker({
		showButtonPanel: true
	});
});
$('#btnCancel').click(function ()
    {
        $(window.location).attr("href", "<?php echo base_url(); ?>game");

    });
$('.radio_category_id').click(function(){
	var number_of_checked_categories = $("input:checked").length;
	if(number_of_checked_categories > 0){
		$('#submit_story_button').removeAttr("disabled");
	} else {
		$('#submit_story_button').attr("disabled","disabled");
	}	 
});
</script>
</html>