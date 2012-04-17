<div class="headcont">
<h1 class="heading">Topics Management</h1>
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
		<a class="button" href="<?=base_url(); ?>topic/new_topic/">New</a>
		<button class="button-1" id="delete_topic_button">Delete</button>
</div>
<table class="data" border="0" cellpadding="0" cellspacing="0">
<thead>
        <tr>
        <th width="16" style="text-align: center;">ID</th><th width="16" style="text-align: center;">#</th><th width="300" align="left">Name</th><th align="left">Description</th>
        </tr>
</thead>
        <?php 
        $i=0;
        foreach($topics as $topic) { ?>
        <tr class="rolover" <?php if ($i%2 == 0){ ?> bgcolor="#f3f3f3" <?php } ?>>
        <td style="text-align: center;"><?php echo $topic->id; ?></td><td width="16" style="text-align: center;"><input type="checkbox" name="group_id" value="<?php echo $topic->id; ?>"></td><td align="left"><a href="<?=base_url(); ?>topic/edit/<?php echo $topic->id; ?>/"><?php echo $topic->name; ?></a></td><td><?php echo $topic->description; ?></td>
        </tr>
	<?php $i++; } ?>
<tfoot>
<tr>
<th colspan="7"><div><?php echo $pagination; ?></div></th>
</tr>
</tfoot>
</table>
</div>
   
<div class="clear"></div> 
</div>
</body>
<script type="text/javascript">
//create ajax for deleting categories
$('#delete_topic_button').click(function() {
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
				url: '<?=base_url(); ?>topic/delete/',
				data: ({topics_array: stories_array}),
				success: function(data) {
				//alert ("Stories deleted");
				location.reload();
				}
			});
			
		 }
	}else{	 
		alert("You must select topic or topics to be deleted!");
	} 
});
</script>
</html>
