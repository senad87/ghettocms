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
<form method="POST" action="<?=base_url(); ?>game/add/">
<div class="container">
	<div class="right-panel">
	<h5>Choose category:</h5>
		<div class="box-right-panel">
			<div class="box-right-panel-inbox">
			<ul class="categories_list_rc">
					<?php foreach ($root_categories as $category) { ?>
					<li>
					<?php 
				
					if (check_category_kids($category->id) == 0) {?>
					<input type="checkbox" name="category_<?php echo $category->id; ?>" class="radio_category_id" value="<?php echo $category->id; ?>"/>
					<? } ?>
					<a href="<?=base_url(); ?>category/edit/<?php echo $category->id; ?>"><?php echo $category->name; ?></a>
					<?php 
					$level= ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					recursion_categories_checkbox($category->id, $level); ?>
					</li>
					<?php } ?>
			</ul>
			</div><!--end of box-right-panel-inbox -->
		</div><!--end of box-right-panel -->
	</div><!--end of right-panel -->
	<div class="left-panel">
	
		<label for="title"><strong>Game official name:</strong></label><br />
		<input class="lform2" style="width: 700px;" type="text" name="title" size="50" value=""><br />
		<?php if (isset($linked_topics[0]->id)){?>
		<input type="checkbox" class="" checked="checked" name="linked_topic_id" value="<?php echo $linked_topics[0]->id; ?>"> <label for="title">Add name as tag in topic <?php echo $linked_topics[0]->name; ?>:</label>
  
		<br /><br />
		<?php } ?>
		<label for="title"><strong>Game Release date:</strong></label><br />
		<input class="lform2" style="width: 150px;" id="datepicker" type="text" name="release_date" size="20" value=""><br />
		<label for="lead"><strong>Lead:</strong></label><br />
		<textarea class="lform2-textarea" style="width: 700px;" name="lead" cols="50" rows="5" value=""></textarea><br />
		<label for="body"><strong>Body:</strong></label><br />
		<textarea name="editor1" cols="20" rows="10" value=""></textarea>
		
	  <div class="tag-filters">
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
		    </select><- uraditi validaciju?<br />
		  <?php $i++; } ?>
        <?php } ?></div>
		<input class="button-1" type="submit" id="submit_story_button" value="Add game" disabled="disabled"/>
		<input type="button" class="button-1" id="btnCancel"  value="Cancel" />
	</div><!--end of left-panel-->
	<div class="clear"></div>        
</div>
</form>    
</body>
<script type="text/javascript">
$(function() {
	$('#btnCancel').click(function (){
        $(window.location).attr("href", "<?php echo base_url(); ?>game");
    });
	$( "#datepicker" ).datepicker({
		showButtonPanel: true
	});
	$('.radio_category_id').click(function(){
		var number_of_checked_categories = $("input:checked").length;
		if(number_of_checked_categories > 0){
			$('#submit_story_button').removeAttr("disabled");
		} else {
			$('#submit_story_button').attr("disabled","disabled");
		}	 
	});
});
</script>
</html>