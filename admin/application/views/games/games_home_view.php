<div class="headcont">
<h1 class="heading">Games Management</h1>
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
<label>Set system topics:</label>
<select style="width: 270px; height: 100px;" multiple="multiple" size="30"  id="selections" name="topics[]">
	<?php foreach ($topics as $topic){ ?>
		<option value="<?php echo $topic->id;?>" <?php if(in_array($topic->id, $sys_topics_array)){?>selected="selected"<?php } ?> ><?php echo $topic->name;?></option>
	<?php } ?> 
</select>
</div>
</div>
</div>

<div class="left-panel">
<div class="submenu">
		<a class="button" href="<?=base_url(); ?>game/new_game/">New</a>
		<button class="button-1" id="delete_game_button">Delete</button>
</div>
<table class="data" border="0" cellpadding="0" cellspacing="0">
<thead>
        <tr>
        <th width="16" style="text-align: center;">ID</th><th style="text-align: center;">#</th><th align="left">Name</th>
        <th align="left">Categories</th>
        <th align="left">Author</th>
        <th align="left">State</th>
        </tr>
</thead>
<?php 
$i=0;
if (isset($games)){
foreach($games as $game) { ?>
<tr class="rolover" <?php if ($i%2 == 0){ ?> bgcolor="#f3f3f3" <?php } ?>>
<td style="text-align: center;"><?php echo $game['id']; ?></td>
<td width="16" style="text-align: center;"><input type="checkbox" name="group_id" value="<?php echo $game['id']; ?>"></td>
<td align="left"><a href="<?=base_url(); ?>game/edit/<?php echo $game['id']; ?>"><?php echo $game['game_name']; ?></a></td>
<td align="left"><?php echo $game['categories_names']; ?></td>
<td align="left"><?php echo $game['author_name']; ?></td>
<td align="left"><?php echo $game['game_state']; ?></td>
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
$('#delete_game_button').click(function() {
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
				url: '<?=base_url(); ?>game/delete/',
				data: ({entries_array: stories_array}),
				success: function(data) {
				location.reload();
				}
			});
			
		 }
	}else{	 
		alert("You must select group or groups to be deleted!");
	} 
});
</script>
</html>