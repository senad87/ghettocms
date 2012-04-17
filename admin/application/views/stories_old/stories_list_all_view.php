<div class="headcont">
<h1 class="heading">Stories Management</h1>
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
By Category:
<select name="" id="select_category" class="filter">
	<option selected="selected">Select category...</option>
	<?php foreach($root_categories as $root_category){ ?>
		<option value="<?php echo $root_category->id; ?>"><?php echo $root_category->name; ?></option>
	<?php } ?>
</select>
</div>

<div id="filter_by_category" class="box-right-panel-inbox">
</div>

<div class="box-right-panel-inbox">

Select Topic:
<select name="" id="select_topic" class="filter">
  <option selected="selected">Select TAG...</option>
  <option>Starcraft</option>
  <option>Diabolo</option>
</select>

</div>

<div class="box-right-panel-inbox">

By Tag:
<select name="" id="select_tag" class="filter">
  <option selected="selected">Select TAG...</option>
  <option>Starcraft</option>
  <option>Diabolo</option>
</select>

</div>

<div class="box-right-panel-inbox">

By Author:
<select name="" id="select_author" class="filter">
<option selected="selected">Select author...</option>
<?php foreach($authors as $author){ ?>
	<option value="<?php echo $author->id; ?>"><?php echo $author->name; ?></option>
<?php } ?>
</select>

</div>


<div class="box-right-panel-inbox">

By State:
<select name="" id="select_state" class="filter">
  <option selected="selected">Select state...</option>
  <?php foreach($states as $state){ ?>
	<option value="<?php echo $state->id; ?>"><?php echo $state->state_name; ?></option>
  <?php } ?>
</select>

</div>

<div class="panel-link"><a href="<?=base_url(); ?>story/">RESET ALL FILTERS</a></div>

<h5>Properties</h5>
<div class="box-right-panel-inbox">

Set system topics:
<select style="width: 270px; height: 100px;" multiple="multiple" size="30"  id="selections" name="topics[]">
	<?php foreach ($topics as $topic){ ?>
		<option value="<?php echo $topic->id;?>" <?php if(in_array($topic->id, $sys_topics_array)){?>selected="selected"<?php } ?> ><?php echo $topic->name;?></option>
	<?php } ?> 
</select>

</div><!-- end box-right-panel-inbox -->
</div>



</div> 
<div class="left-panel">
<div class="submenu">
<?php if(in_array(6, $this->session->userdata('user_privileges'))){ ?>
		<a class="button" href="<?=base_url(); ?>story/new_story/">New</a>
<?php } ?>
<?php if(in_array(6, $this->session->userdata('user_privileges'))){ ?>		
		<button class="button-1" id="delete_story_button">Delete</button>
<?php } ?>
<?php if(in_array(7, $this->session->userdata('user_privileges'))){ ?>			
		<button class="button-1" id="publish_story_button">Publish</button>
<?php } ?>
<?php if(in_array(8, $this->session->userdata('user_privileges'))){ ?>			
		<button class="button-1" id="unpublish_story_button">Unpublish</button>
<?php } ?>
</div>
    
   

	<table class="data" border="0" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
		<th width="35" style="text-align: center;">ID</th>
		<th style="text-align: center;" width="10"><input id="all_stories" type="checkbox" value=""></th>
		<th width="300" align="left">Title</th>
		<th width="180" style="text-align: center;">Creation date</th>
		<th width="180" style="text-align: center;">Modified date</th>
		<th width="180" style="text-align: center;">Author</th>
		<th width="176">Categories</th>
		<th width="89" align="left">State</th>
		</tr>
		</thead>
		<?php 
		$i=0;
		if (isset($stories)){
		foreach($stories as $story) { ?>
			<tr class="rolover" <?php if ($i%2 == 0){ ?> bgcolor="#f3f3f3" <?php } ?>>
			<td align="right"><?php echo $story['id']; ?></td>
			<td align="center" width="20"><input type="checkbox" name="story_id" value="<?php echo $story['id']; ?>"></td>
			<?php if(in_array(9, $this->session->userdata('user_privileges'))){ ?>
			<td align="left"><a href="<?=base_url(); ?>story/edit/<?php echo $story['id']; ?>"><?php echo $story['title']; ?></a></td>
			<?php }else{ ?>
			<td align="left"><?php echo $story['title']; ?></td>
			<?php } ?>
			<td align="center"><?php echo $story['creation_date']; ?></td>
			<td align="center"><?php echo $story['modified_date']; ?></td>
			<td align="center"><?php echo $story['author_name']; ?></td>
			<td><?php echo $story['categories_names']; ?></td>
			<td align="left"><?php echo $story['story_state']; ?></td>
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
	$("#all_stories").click(function()				
	{
		var checked_status = this.checked;
		$("input[name=story_id]").each(function()
		{
			this.checked = checked_status;
		});
	});					
});

//TODO:Create only one function with input params object(story, category, group) and action(delete, publish, unpublish)
$('#delete_story_button').click(function() {
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
				url: '<?=base_url(); ?>story/delete/',
				data: ({stories_array: stories_array}),
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
