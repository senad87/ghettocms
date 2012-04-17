<div class="headcont">
<h1 class="heading">Stories Trash</h1>

 
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

<input class="search" name="" type="text" />
<input class="button-1"  type="submit" value="Search">

</div>
</div>



<h5 style="margin-top: 15px;">Filter</h5>
<div class="box-right-panel">
<div class="box-right-panel-inbox">

By Category:
<select name="" class="filter">
	<option selected="selected">Select category...</option>
	<?php foreach($root_categories as $root_category){ ?>
		<option value="<?php echo $root_category->id; ?>"><?php echo $root_category->name; ?></option>
	<?php } ?>
</select>

</div>

<div class="box-right-panel-inbox">

By TAG:
<select name="" class="filter">
  <option selected="selected">Select TAG...</option>
  <option>Starcraft</option>
  <option>Diabolo</option>
</select>

</div>

<div class="box-right-panel-inbox">

By Author:
<select name="" class="filter">
<option selected="selected">Select author...</option>
<?php foreach($authors as $author){ ?>
	<option value="<?php echo $author->id; ?>"><?php echo $author->name; ?></option>
<?php } ?>
</select>

</div>


<div class="box-right-panel-inbox">

By State:
<select name="" class="filter">
  <option selected="selected">Select state...</option>
  <?php foreach($states as $state){ ?>
	<option value="<?php echo $state->id; ?>"><?php echo $state->state_name; ?></option>
  <?php } ?>
</select>

</div>

<div class="panel-link"><a href="#">RESET ALL FILTERS</a></div>

</div>



</div>



<div class="left-panel">

<div class="submenu">
<?php if(in_array(12, $this->session->userdata('user_privileges'))){ ?>
		<button class="button-1" id="unpublish_story_button">Restore</button>
<?php } ?>		
</div>
    
	<table class="data" border="0" cellpadding="0" cellspacing="0">
	<thead>
    <tr>
	<th width="35" style="text-align: center;">ID</th><th align="center" width="10">#</th><th width="300" align="left">Title</th><th width="180" style="text-align: center;">Creation date</th><th width="180" style="text-align: center;">Modified date</th><th width="176">Categories</th><th width="89" align="left">State</th>
	</tr>
    </thead>
	<?php 
	$i=0;
	if (isset($stories)){
	foreach($stories as $story) { ?>
	<tr class="rolover" <?php if ($i%2 == 0){ ?> bgcolor="#f3f3f3" <?php } ?>>
	<td align="right"><?php echo $story['id']; ?></td>
	<td align="center" width="20"><input type="checkbox" name="story_id" value="<?php echo $story['id']; ?>"></td>
	<td align="left"><?php echo $story['title']; ?></td>
	<td align="center"><?php echo $story['creation_date']; ?></td>
	<td align="center"><?php echo $story['modified_date']; ?></td>
	<td><?php echo $story['categories_names']; ?></td>
	<td align="left"><?php echo $story['story_state']; ?></td>
	</tr>
		<?php 
		$i++;
		 } ?>
    <?php } else { ?>
    <tr><td colspan="7"><?php echo $no_entries; ?></td></tr>
    <?php } ?>
		<tfoot>
			<tr>
            <th colspan="7"><?php echo $pagination; ?></th>
            </tr>
		</tfoot>
	</table>
</div>
   
<div class="clear"></div>       
</div>    
    
</body>
<script type="text/javascript">
//create ajax for deleting categories
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
				url: '<?=base_url(); ?>story/restore/',
				data: ({stories_array: stories_array}),
				success: function(data) {
					//alert ("Stories Published");
					location.reload();
				}
			});
			
		 }
	}else{	 
		alert("You must select story/stories to be restored!");
	} 
});
</script>
</html>