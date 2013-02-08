<div class="headcont">
<h1 class="heading">Module Instances of <?php echo $module; ?> Module</h1>

 
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
	<a class="button" id="edit_category_button">Edit</a>
	<a href="#" class="delete_category_button button" >Delete</a>

	<a class="button" href="<?=base_url(); ?>module/new_module/<?php echo $module; ?>">New</a>

	</div>
    <table class="data" border="0" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
		<th width="18" style="text-align: center;">ID</th><th width="10" style="text-align: center;">#</th><th align="left">Module Instance</th><th align="left">Description</th>
		</tr>
		</thead>
		<?php $item_counter = 0;
		if (isset($instances)){
			if (count($instances) > 0){
				foreach ($instances as $instance) { ?>
					<tr class="rolover" <?php if ($item_counter%2 == 0){ ?>bgcolor="#f3f3f3" <?php } ?>>
					<td align="center"><?php echo $instance->id; ?></td>
					<td align="center"><input type="radio" name="category_id" class="radio_category_id" value="<?php echo $instance->id; ?>"></td><td align="left"><a href="<?=base_url(); ?>module/edit_instance/<?php echo $instance->id; ?>"><?php echo $instance->title; ?></a></td>
					<td align="left"><?php echo $instance->description; ?></td>
					</tr>
				<?php } 
			}else{ ?>
			<td colspan="4"><div>No module instances created. Create your first instance of this module.</div></td>
		<?php }	
		}?>
		<tfoot>
			<tr>
		<th colspan="4"><div></div></th>
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
	var menu_id = $(this).val();
	var url_edit = "<?=base_url(); ?>menu/edit/"+nemu_id;
        $("#edit_category_button").attr("href", url_edit);
        $(".delete_category_button").attr("id", menu_id);
});
//create ajax for deleting categories, remove href from 
$('.delete_category_button').click(function() {
	var menu_id = $(this).attr('id');
	if(menu_id > 0){
		var answer = confirm("Are you sure?");
		if (answer == true){
			var url = "<?php echo base_url(); ?>menu/delete/"+menu_id;
			top.location.href = url;
		}
	}
});

</script>
</html>
