<div class="headcont">
<h1 class="heading">Category Manager</h1>

 
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
<?php if(in_array(3, $this->session->userdata('user_privileges'))){ ?>
	<a class="button" id="edit_category_button">Edit</a>
<?php } ?>
<?php if(in_array(4, $this->session->userdata('user_privileges'))){ ?>	
	<a href="#" class="delete_category_button button" >Delete</a>
<?php } ?>
<?php if(in_array(2, $this->session->userdata('user_privileges'))){ ?>
	<a class="button" href="<?=base_url(); ?>category/new_category/">New</a>
<?php } ?>	
	</div>
    <table class="data" border="0" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
		<th width="18" style="text-align: center;">ID</th><th width="10" style="text-align: center;">#</th><th align="left">Category Item</th>
		</tr>
		</thead>
		<?php 
		$item_counter = 0;
		foreach ($root_categories as $category) { ?>
		<?php if (check_category_entries($category->id) == 0 && check_category_kids($category->id) == 0){ ?>
			<tr class="rolover" <?php if ($item_counter%2 == 0){ ?>bgcolor="#f3f3f3" <?php } ?>>
			<td align="center"><?php echo $category->id; ?></td><td align="center"><input type="radio" name="category_id" class="radio_category_id" value="<?php echo $category->id; ?>"></td>
			<?php if(in_array(3, $this->session->userdata('user_privileges'))){ ?>
			<td align="left"><a href="<?=base_url(); ?>category/edit/<?php echo $category->id; ?>"><?php echo $category->name; ?></a></td>
			<?php }else{ ?>
			<td align="left"><?php echo $category->name; ?></td>
			<?php } ?>
			</tr>
		<?php } else { ?>
			<tr class="rolover" <?php if ($item_counter%2 == 0){ ?>bgcolor="#f3f3f3" <?php } ?>>
			<td align="center"><?php echo $category->id; ?></td>
			<td align="center"><input type="radio" name="category_id" class="radio_category_id" value="<?php echo $category->id; ?>" disabled></td>
			<?php if(in_array(3, $this->session->userdata('user_privileges'))){ ?>
			<td align="left"><a href="<?=base_url(); ?>category/edit/<?php echo $category->id; ?>"><?php echo $category->name; ?>&nbsp;&nbsp;</a></td>
			<?php } else{ ?>
			<td align="left"><?php echo $category->name; ?></td>
			<?php } ?>
			</tr>
		<?php } ?>
		<?php $level = ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		$item_counter++;
		      if (check_category_kids($category->id) > 0){
	              recursion_categories_table($category->id, $level, &$item_counter, $this->session->userdata('user_privileges'));
	          } ?>
		<?php } ?>	
       
		<tfoot>
			<tr>
		<th colspan="3"><div></div></th>
		</tr>
		</tfoot>
	</table>
    
</div>

<div class="clear"></div>    
</div>


    
</body>
<script type="text/javascript">
//on click add href attribut to the Edit link
$('.radio_category_id').click(function() {
	var category_id = $(this).val();
	var url_edit = "<?=base_url(); ?>category/edit/"+category_id;
        $("#edit_category_button").attr("href", url_edit);
        $(".delete_category_button").attr("id", category_id);
});
//create ajax for deleting categories, remove href from 
$('.delete_category_button').click(function() {
	var category_id = $(this).attr('id');
	if(category_id > 0){
		var answer = confirm("Are you sure?");
		if (answer == true){
			var url = "<?php echo base_url(); ?>category/delete/"+category_id;
			top.location.href = url;
		}
	}
});

</script>
</html>
