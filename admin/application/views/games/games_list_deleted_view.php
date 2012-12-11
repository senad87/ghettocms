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
<h5>Properties</h5>
<div class="box-right-panel">
<div class="box-right-panel-inbox">
There is no properties for this item.

</div>
</div>
</div>
<div class="left-panel">



<div class="submenu">
		
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
$('#delete_group_button').click(function() {
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
				url: '<?=base_url(); ?>group/delete/',
				data: ({stories_array: stories_array}),
				success: function(data) {
				//alert ("Stories deleted");
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
