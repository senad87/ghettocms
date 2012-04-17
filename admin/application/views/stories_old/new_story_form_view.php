<div class="headcont">
<script type="text/javascript" src="<?php echo base_url(); ?>system/application/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	window.onload = function()
	{
		
		CKEDITOR.replace( 'editor1',{skin : 'v2',
			filebrowserBrowseUrl: '<?php echo base_url(); ?>system/application/filemanager/index.html'} );
	};
</script>
<h1 class="heading">Add New Story</h1>
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
<?php echo form_open_multipart('story/add_new/');?>
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
			<td width="8" align="center"><input type="checkbox" name="category_<?php echo $category->id; ?>" class="radio_category_id" value="<?php echo $category->id; ?>"/></td>
			<td><a href="<?=base_url(); ?>category/edit/<?php echo $category->id; ?>"><?php echo $category->name; ?></a></td>
			<? } else { ?>
			<td width="8" align="center"><input type="checkbox" name="category_<?php echo $category->id; ?>" class="radio_category_id" value="<?php echo $category->id; ?>" disabled></td>
			<td><a href="<?=base_url(); ?>category/edit/<?php echo $category->id; ?>"><?php echo $category->name; ?></a></td>
			<?php } ?>
			</tr>
			<?php 
			$level = $level = ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			recursion_categories_checkbox($category->id, $level); ?>
			<?php } ?>
	<tfoot></tfoot>
</table>
</div>
			</div><!--end of box-right-panel-inbox -->
		</div><!--end of box-right-panel -->        
	</div><!--end of right-panel -->
	<div class="left-panel">
		<label for="title"><strong>Title:</strong></label><br />
		<input class="lform2" style="width: 700px;" type="text" name="title" size="50" value=""><br />
		<label for="headline"><strong>Headline:</strong></label><br />
		<input class="lform2" style="width: 700px;" type="text" name="headline" size="50" value=""><br />
		<label for="lead"><strong>Lead:</strong></label><br />
		<textarea class="lform2-textarea" style="width: 700px;" name="lead" cols="50" rows="5"></textarea><br />
		<label for="title"><strong>Date:</strong></label><br />
		<input class="lform2" style="width: 150px;" id="datepicker" type="text" name="creation_date" size="20" value=""><br />
		<label for="body"><strong>Upload Poster Photo:</strong></label><br />
		<input type="file" name="image_file" size="30"><br />
		<label for="body"><strong>Dimensions: <?php echo $largest_image->width;?> x <?php echo $largest_image->height;?></strong></label><br />
		<label for="body"><strong>Body:</strong></label><br />
		<textarea name="editor1" cols="20" rows="10"></textarea><br />
		<!-- <div class="line">
			<label for="tags">Tags</label>
			<ul id="mytags"></ul>
		</div><br />-->
		<!-- system tags selection -->
		<div class="tag-filters">
		<?php if(isset($topics)){ ?>
			<?php if(count($topics) > 0) { ?>
			<?php 
			  $i = 0;
			  foreach ($topics as $topic) { ?>
			    <label for="privileges"><?php echo $topic->name; ?>:</label><br />
			    <select class="filter" name="tag_<?php echo $i; ?>">
				  <option value="0">Please choose:</option>
			  	  <?php foreach($tags[$topic->id] as $tag) { ?>
				  <option value="<?php echo $tag->id; ?>"><?php echo $tag->tag; ?></option>
				  <?php } ?>
			    </select><br />
			  <?php $i++; } ?>
	        <?php } ?>
        <?php } ?>
        </div>
        <!-- system tags selection -->
		<input class="button-1" type="submit" id="submit_story_button" value="Add story" disabled="disabled">
        <input type="button" class="button-1" id="btnCancel"  value="Cancel" />
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
	
	$('#btnCancel').click(function (){
	    $(window.location).attr("href", "<?php echo base_url(); ?>story");
	});
	
	$('.radio_category_id').click(function(){
		
		var number_of_checked_categories = $("input:checked").length;
		
		if(number_of_checked_categories > 0){
			$('#submit_story_button').removeAttr("disabled");
		} else {
			$('#submit_story_button').attr("disabled","disabled");
		}	 
	});
	
	function getTopicByTag(){
		//TODO: Create JS array with tags as keys and topic name as value
	}
});	
</script>
</html>