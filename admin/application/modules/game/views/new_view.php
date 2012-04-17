<div class="headcont">
<script type="text/javascript" src="<?php echo base_url(); ?>application/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	window.onload = function()
	{
		
		CKEDITOR.replace( 'editor1',{skin : 'v2',
			filebrowserBrowseUrl: '<?php echo base_url(); ?>application/filemanager/index.html'} );
	};
</script>
<h1 class="heading">Add New Game</h1>
<?php echo modules::run('toolbar', 'game_title', 'game', array('save', 'cancel')); ?>
<div class="clear"></div>
</div>
<?php echo form_open_multipart('game/createNew_post/', array('id'=>'game_form'));?>
<div class="container">
	<div class="right-panel">
	<h5>Choose category:</h5>
		<div class="box-right-panel">
			<div class="box-right-panel-inbox" style="padding:0;">
				<div class="table-minicat">
					<table class="data" border="0" cellpadding="0" cellspacing="0">
						<thead></thead>
							<?php foreach ($root_categories as $category) { ?>
							<tr class="rolover">
							<?php if (check_category_kids($category->id) == 0) {?>
							<td width="8" align="center"><input type="radio" name="category_id" class="radio_category_id" value="<?php echo $category->id; ?>"/></td>
							<td><a href="<?=base_url(); ?>category/edit/<?php echo $category->id; ?>"><?php echo $category->name; ?></a></td>
							<? } else { ?>
							<td width="8" align="center"><input type="radio" name="category_id" class="radio_category_id" value="<?php echo $category->id; ?>" disabled></td>
							<td><a href="<?=base_url(); ?>category/edit/<?php echo $category->id; ?>"><?php echo $category->name; ?></a></td>
							<?php } ?>
							</tr>
							<?php 
							$level = $level = ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							recursion_categories_checkbox($category->id, $level); ?>
							<?php } ?>
						<tfoot></tfoot>
					</table>
				</div><!--end of table-minicat -->
			</div><!--end of box-right-panel-inbox -->
		</div><!--end of box-right-panel -->    
	</div><!--end of right-panel -->
	<div class="left-panel">
	
		<label for="title"><strong>Game official name:</strong></label><br />
		<input class="lform2" style="width: 700px;" type="text" name="title" size="50" value=""><br />
		<?php if (isset($linked_topics[0]->id)){?>
		<input type="checkbox" class="" checked="checked" name="linked_topic_id" value="<?php echo $linked_topics[0]->id; ?>"> <label for="title">Add name as tag in topic <?php echo $linked_topics[0]->name; ?></label>
  
		<br /><br />
		<?php } ?>
		<label for="title"><strong>Game Release date:</strong></label><br />
		<input class="lform2" style="width: 150px;" id="datepicker" type="text" name="release_date" size="20" value=""><br />
		<label for="lead"><strong>Lead:</strong></label><br />
		<textarea class="lform2-textarea" style="width: 700px;" name="lead" cols="50" rows="5" value=""></textarea><br />
		<label for="body"><strong>Upload Poster Photo:</strong></label><br />
		<input type="file" name="image_file" size="30"><br />
		<label for="body"><strong>Dimensions: <?php echo $largest_image->width;?> x <?php echo $largest_image->height;?></strong></label><br />
		<label for="body"><strong>Body:</strong></label><br />
		<textarea name="editor1" cols="20" rows="10" value=""></textarea>
		
	  <div class="tag-filters">
		<?php if(isset($topics) && count($topics) > 0) { ?>
        <?php 
		  $i = 0;
		  foreach ($topics as $topic) { ?>
		  <?php if(count($tags[$topic->id]) > 0){ ?>
		    <label for="privileges"><?php echo $topic->name; ?>:</label><br />
		    <select class="filter" name="tag_<?php echo $i; ?>">
			  <option value="0">Please choose:</option>
		  	  <?php foreach($tags[$topic->id] as $tag) { ?>
			  <option value="<?php echo $tag->id; ?>"><?php echo $tag->tag; ?></option>
			  <?php } ?>
		    </select><- uraditi validaciju?<br />
		  <?php } ?>
		  <?php $i++; } ?>
		  
        <?php } ?></div>
	</div><!--end of left-panel-->
	<div class="clear"></div>        
</div>
</form>    
</body>
<script type="text/javascript">
$(document).ready(function(){

	$( "#datepicker" ).datepicker({
		showButtonPanel: true
	});
	$( "#datepicker" ).datepicker('setDate', new Date());
});	
</script>
</html>
