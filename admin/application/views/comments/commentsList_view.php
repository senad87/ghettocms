


<div class="headcont">
<h1 class="heading">Comments Management</h1>
	<?php if (isset($message)) {
		if($message <> ""){ ?>
			 <div class="message" id="message"><?php echo $message; ?></div>
		<?php } ?>
	<?php } ?>
	
<div class="clear"></div>
</div>

<div class="container">
<div class="right-panel">
    <h5>Search Comments</h5> 
    <div class="box-right-panel">
        <div class="box-right-panel-inbox">
        Enter search term:
        <input class="search" name="" type="text" />
        <input class="button-1"  type="submit" value="Search">
        
        </div>
    </div>
    <- Trebalo bi dodati i IP adresu




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
		<th style="text-align: center;" width="20"><input id="all_stories" type="checkbox" value=""></th>
		<th width="301" style="text-align: center;">Title</th>
		<th width="179" >Name</th>
		<th width="180" style="text-align: center;">Email</th>
		<th width="270" style="text-align: center;">Body</th>
		<th width="230" style="text-align: center;">Created Date</th>
		<th width="40" style="text-align: center;">status</th>
		</tr>
		</thead>
		<?php 
		$i=0;
		if (isset($comments)){
		foreach($comments as $comment){ ?>
			<tr class="rolover" <?php if ($i%2 == 0){ ?> bgcolor="#f3f3f3" <?php } ?>>
			<td align="center"><?php echo $comment->id; ?></td>
			<td align="center" width="20"><input type="checkbox" name="story_id" value="<?php echo $comment->id; ?>"></td>
			<td align="left"> <?php echo $model->get_entry_title($comment->entry_id); ?></td>
			<td align="left"><?php echo $comment->name; ?></td>
			<td align="left"><?php echo $comment->email; ?></td>
			<td align="left"><a href="<?php echo base_url();?>comments/edit/<?php echo $comment->id;?>/<?php echo $offset;?>/" ><?php echo cut($comment->body, 50); ?></a></td>
			<td align="center"><?php echo $comment->createdDate; ?></td>
			<td align="center" width="40" ><?php echo $comment->status; ?></td>
			
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
				url: '<?=base_url(); ?>comments/delete/',
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
				url: '<?=base_url(); ?>comments/publish/',
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
				url: '<?=base_url(); ?>comments/unpublish/',
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

</script>
</html>



