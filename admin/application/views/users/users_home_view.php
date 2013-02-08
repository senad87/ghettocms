<?php $this->load->view("header_view"); ?>
<div class="headcont">
<h1 class="heading">User manager</h1>

 
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
111

</div>
</div>

</div>
<div class="left-panel">





<div class="submenu">
<?php if(in_array(14, $this->session->userdata('user_privileges'))){ ?>
		<a class="button" href="<?=base_url(); ?>admin_user/new_user/">New</a>
<?php } ?>
<?php if(in_array(13, $this->session->userdata('user_privileges'))){ ?>
		<button class="button-1" id="delete_user_button">Delete</button>
<?php } ?>
</div>
<div id="message">
	<?php if (isset($message)) {
		if($message <> ""){ ?>
			<?php echo $message; ?>
		<?php } ?>
	<?php } ?>
</div>
<table class="data" border="0" cellpadding="0" cellspacing="0">
	<thead>
    <tr>
	<th width="18" style="text-align: center;">ID</th><th width="16" style="text-align: center;">#</th><th width="316" align="left">Name</th><th width="537">Username</th><th width="255" align="left">Group</th>
	</tr>
    </thead>
	<?php 
	$i=0;
	foreach($users as $user) { ?>
	<tr class="rolover" <?php if ($i%2 == 0){ ?> bgcolor="#f3f3f3" <?php } ?>>
	<td align="right"><?php echo $user['id']; ?></td>
	<td width="16" style="text-align: center;"><input type="checkbox" name="user_id" value="<?php echo $user['id']; ?>"></td>
	<?php if(in_array(15, $this->session->userdata('user_privileges'))){ ?>
	<td align="left"><a href="<?=base_url(); ?>admin_user/edit/<?php echo $user['id']; ?>/"><?php echo $user['name']; ?></a></td>
	<?php }else{ ?>
	<td align="left"><?php echo $user['name']; ?></td>
	<?php } ?>
	<td><?php echo $user['username']; ?></td><td align="left"><?php echo $user['role_name']; ?></td>
	
	</tr>
		<?php 
		$i++;
		 } ?>
		<tfoot>
			<tr>
            <th colspan="7"><div><?php echo $pagination; ?></div></th>
            </tr>
		</tfoot>
	</table>
</table>
</div>
   
<div class="clear"></div> 
</div>
</body>
<script type="text/javascript">
//create ajax for deleting categories
$('#delete_user_button').click(function() {
	 var number_of_checked_stories = $("input:checked").length;
	 var i;
	 var users_array;
	 users_array = 0;
	 if(number_of_checked_stories > 0){
		 $("input:checked").each(function() {
		 if(users_array == 0){
		    users_array = $(this).val();
		 }else{   
		    users_array = users_array+','+$(this).val();
		 }
		 });
		 var answer = confirm("Are you sure?");
		 if (answer == true){
			$.ajax({
			        type: "POST",
				url: '<?=base_url(); ?>admin_user/delete/',
				data: ({users_array: users_array}),
				success: function(data) {
				location.reload();
				}
			});
			
		 }
	}else{	 
		alert("You must select stories to be deleted!");
	} 
});
</script>
</html>
