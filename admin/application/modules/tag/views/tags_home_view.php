<div class="headcont">
<h1 class="heading">Tags Management</h1>
<?php echo modules::run('toolbar', 'tag_title', 'tag', array('new', 'delete')); ?>
	<?php if (isset($message)) {
		if($message <> ""){ ?>
			 <div class="message" id="message"><?php echo $message; ?></div>
		<?php } ?>
	<?php } ?>
	
<div class="clear"></div>
</div>

<div class="container">
<div class="right-panel">
<h5>Search</h5>
<div class="box-right-panel">
<div class="box-right-panel-inbox">
Enter search term:
<input class="search" name="" type="text" />
<input class="button-1"  type="submit" value="Search">

</div>
</div>

<h5 style="margin-top: 15px;">Filter</h5>
<div class="box-right-panel">
        <div class="box-right-panel-inbox">
        By TOPIC:
        <select name="" class="filter">
          <option>Select TOPIC...</option>
          
          <?php foreach($topics as $topic){ ?>
			<option value="<?php echo $topic->id; ?>"><?php echo $topic->name; ?></option>
			<?php } ?>
        </select>
        </div>
        <div class="panel-link"><a href="<?=base_url(); ?>tag/">RESET ALL FILTERS</a></div>

</div>
</div> 
<div class="left-panel">
<div class="submenu">
</div>
	<!-- <table class="data" border="0" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
		<th width="16" style="text-align: center;">ID</th><th width="16" style="text-align: center;"><input id="all_stories" type="checkbox" value=""></th><th align="left">Tag</th><th width="300" align="left">Topic</th>
		</tr>
		</thead>
		<?php 
		$i=0;
		foreach($tags_data as $tag) { ?>
			<tr class="rolover" <?php if ($i%2 == 0){ ?> bgcolor="#f3f3f3" <?php } ?>>
			<td align="right"><?php echo $tag['id']; ?></td><td align="center"><input type="checkbox" name="story_id" value="<?php echo $tag['id']; ?>"></td><td align="left"><a href="<?=base_url(); ?>tag/edit/<?php echo $tag['id']; ?>"><?php echo $tag['tag']; ?></a></td><td align="left"><?php echo $tag['topic_name']; ?></td>
			</tr>
		<?php 
		$i++;
		 } ?>
		<tfoot>
			<tr>
		<th colspan="4"><div><?php echo $pagination; ?></div></th>
		</tr>
		</tfoot>
	</table>-->
	
	<?php echo modules::run('table', $tags_data, array('input|false|false|checkbox', 'text_link|tag|Tag', 'text|id|ID', 'text_link|topic_name|Topics'), 'tag'); ?>
</div>
   
<div class="clear"></div>      
</div>
</body>
<script type="text/javascript">
$("#all_stories").click(function()				
	{
		var checked_status = this.checked;
		$("input[name=story_id]").each(function()
		{
			this.checked = checked_status;
		});
	});
	
$('#delete_story_button').click(function() {
	 var number_of_checked_stories = $("input:checked").length;
	 var i;
	  stories_array;
	 stories_array = 0;
	 if(number_of_checked_stories > 0){
		 $("input:checked").each(function() {
		 if(stories_array == 0){
		    stories_array = $(this).val();
		 }else{   
		    stories_array = stories_array+','+$(this).val();
		 }
		 });
		 var answer = confirm("Are you sure?");
		 if (answer == true){
			$.ajax({
			        type: "POST",
				url: '<?=base_url(); ?>tag/delete/',
				data: ({tags_array: stories_array}),
				success: function(data) {
				//alert ("Stories deleted");
				location.reload();
				}
			});
			
		 }
	}else{	 
		alert("You must select stories to be deleted!");
	} 
});
$('.filter').change(function() {
	var filter_value = $(this).val();
	$(window.location).attr("href", "<?php echo base_url(); ?>tag/filter/"+filter_value);
});
</script>
</html>