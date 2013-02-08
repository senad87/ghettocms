<div class="headcont">
<h1 class="heading">Menu Manager</h1>

 
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
<?php if(in_array(26, $this->session->userdata('user_privileges'))){ ?>
	<a class="button" id="edit_category_button">Edit</a>
<?php } ?>
<?php if(in_array(22, $this->session->userdata('user_privileges'))){ ?>
	<a href="#" class="delete_category_button button" >Delete</a>
<?php } ?>
<?php if(in_array(23, $this->session->userdata('user_privileges'))){ ?>
	<a class="button" href="<?=base_url(); ?>menu/new_menu/">New</a>
<?php } ?>
	</div>
    <table class="data" border="0" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
		<th width="18" style="text-align: center;">ID</th><th width="10" style="text-align: center;">#</th><th align="left">Menu</th><th align="left">Items</th>
		</tr>
		</thead>
		<?php $item_counter = 0;
		foreach ($root_menus as $menu) { ?>
			<tr class="rolover" <?php if ($item_counter%2 == 0){ ?>bgcolor="#f3f3f3" <?php } ?>>
			<td align="center"><?php echo $menu->id; ?></td>
			<td align="center"><input type="radio" name="category_id" class="radio_category_id" value="<?php echo $menu->id; ?>"></td>
			<?php if(in_array(26, $this->session->userdata('user_privileges'))){ ?>
			<td align="left"><a href="<?=base_url(); ?>menu/edit/<?php echo $menu->id; ?>"><?php echo $menu->name; ?></a></td>
			<td align="left"><a href="<?=base_url(); ?>menu/items_list/<?php echo $menu->id; ?>">Manage Item(s)</a></td>
			<?php }else{ ?>
			<td align="left"><?php echo $menu->name; ?></td>
			<td align="left">Manage Item(s)</td>
			<?php } ?>
			</tr>
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
<script type="text/javascript" src="<?php echo base_url(); ?>system/application/style/js/jquery-1.4.2.min.js"></script>
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