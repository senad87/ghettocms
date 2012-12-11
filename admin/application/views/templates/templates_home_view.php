<div class="headcont">
<h1 class="heading">Templates Management</h1>
	<?php if (isset($message)) {
		if($message <> ""){ ?>
			 <div class="message" id="message"><?php echo $message; ?></div>
		<?php } ?>
	<?php } ?>
	
<div class="clear"></div>
</div>

<div class="container">
<div class="right-panel">

</div> 
<div class="left-panel">
<div class="submenu">
<?php if(in_array(29, $this->session->userdata('user_privileges'))){ ?>
		<a class="button" href="<?=base_url(); ?>template/new_template/">New</a>
<?php } ?>
<?php if(in_array(30, $this->session->userdata('user_privileges'))){ ?>
		<button class="button-1" id="delete_button">Delete</button>
<?php } ?>
</div>

	<table class="data" border="0" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
		<th width="35" style="text-align: center;">ID</th>
		<th style="text-align: center;" width="10"><input id="all_items" type="checkbox" value=""></th>
		<th width="300" align="left">Name</th>
		<th width="180" style="text-align: center;">Positions</th>
		<th width="180" style="text-align: center;">File name</th>
		<th width="180" style="text-align: center;">File Path</th>
		</tr>
		</thead>
		<?php 
		$i=0;
		if (isset($templates)){
		foreach($templates as $template) { ?>
			<tr class="rolover" <?php if ($i%2 == 0){ ?> bgcolor="#f3f3f3" <?php } ?>>
			<td align="right"><?php echo $template->id; ?></td>
			<td align="center" width="20"><input type="checkbox" name="item_id" value="<?php echo $template->id; ?>"></td>
			<?php if(in_array(29, $this->session->userdata('user_privileges'))){ ?>
			<td align="left"><a href="<?=base_url(); ?>template/edit/<?php echo $template->id; ?>"><?php echo $template->name; ?></a></td>
			<?php } ?>
			<td align="center"><?php echo $template->num_of_positions; ?></td>
			<td align="center"><?php echo $template->file_name; ?></td>
			<td align="center"><?php echo $template->file_path; ?></td>
			</tr>
		<?php 
		$i++;
		 } ?>
		 <?php } else { ?>
    <tr><td colspan="8"><?php echo $no_entries; ?></td></tr>
    <?php } ?>
		<tfoot>
			<tr>
		<th colspan="8"><div><?php echo $pagination; ?></div></th>
		</tr>
		</tfoot>
	</table>
</div>
   
<div class="clear"></div>      
</div>
</body>
<script type="text/javascript">
//select all checkboxes in the list
$(document).ready(function()
{
	$("#all_items").click(function()				
	{
		var checked_status = this.checked;
		$("input[name=item_id]").each(function()
		{
			this.checked = checked_status;
		});
	});					
});

//TODO:Create only one function with input params object(story, category, group), action(delete, publish, unpublish), and you must check items message
$('#delete_button').click(function() {
	 var number_of_checked_items = $("input:checked").length;
	 var i;
	 var items_array;
	 items_array = 0;
	 if(number_of_checked_items > 0){
		 $("input:checked").each(function() {
		 if(items_array == 0){
			 items_array = $(this).val();
		 }else{   
			 items_array = items_array+','+$(this).val();
		 }
		 });
		 var answer = confirm("Are you sure?");
		 if (answer == true){
			$.ajax({
			    type: "POST",
				url: '<?=base_url(); ?>template/delete/',
				data: ({items_array: items_array}),
				success: function(data) {
				location.reload();
				}
			});
			
		 }
	}else{	 
		alert("You must select items to be deleted!");
	} 
});
$('#publish_story_button').click(function() {
	 var number_of_checked_stories = $("input:checked").length;
	 var i;
	 var stories_array;
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
				url: '<?=base_url(); ?>story/publish/',
				data: ({stories_array: stories_array}),
				success: function(data) {
					//alert ("Stories Published");
					location.reload();
				}
			});
			
		 }
	}else{	 
		alert("You must select stories to be published!");
	} 
});
$('#unpublish_story_button').click(function() {
	 var number_of_checked_stories = $("input:checked").length;
	 var i;
	 var stories_array;
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
				url: '<?=base_url(); ?>story/unpublish/',
				data: ({stories_array: stories_array}),
				success: function(data) {
					//alert ("Stories Published");
					location.reload();
				}
			});
			
		 }
	}else{	 
		alert("You must select stories to be unpublished!");
	} 
});

$('#select_topic').change(function() {
	var topic_id = $(this).val();
	
	//$(window.location).attr("href", "<?php echo base_url(); ?>story/filter/"+filter_value);
});

$('.filter').change(function() {
	var category_id = $("#select_category").val();
	var tag_id = $("#select_tag").val();
	alert("category"+category_id+"tag"+tag_id);
	//$(window.location).attr("href", "<?php echo base_url(); ?>story/filter/"+filter_value);
});
</script>
</html>

