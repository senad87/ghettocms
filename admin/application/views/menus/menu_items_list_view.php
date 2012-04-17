<div class="headcont">
<h1 class="heading">Menu Items for <?php echo $parent_menu[0]->name; ?></h1>
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
	<!-- <a class="button" id="edit_category_button">Edit</a> -->
	<button class="button-1" id="publish_story_button">Publish</button>
	<button class="button-1" id="unpublish_story_button">Unpublish</button>
	<a href="javascript:;" class="delete_category_button button" >Delete</a>
	<a class="button" href="<?=base_url(); ?>menu/new_menu_item/<?php echo $parent_menu[0]->id; ?>">New</a>
	<input type="button" class="set-as-home button" value="Set As Home" > 
	
	</div>
    <table class="data" border="0" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
		<th width="18" style="text-align: center;">ID</th><th width="10" style="text-align: center;">#</th>
		<th align="left">Menu Items</th>
		<th align="left">Page</th>
		<th align="left">Home</th>
		<th align="left">State</th>
		<th align="left">Order</th>
		</tr>
		</thead>
		<?php 
		if (!isset($no_items)){
			$item_counter = 0;
			foreach ($menu_items as $menu) { 
			//var_dump($menu->ordering);
				?>
			<?php if (check_menu_kids($menu->id) == 0){ ?>
				<tr class="rolover" <?php if ($item_counter%2 == 0){ ?>bgcolor="#f3f3f3" <?php } ?>>
				<td align="center"><?php echo $menu->id; ?></td>
				<td align="center"><input type="radio" name="menu_id" class="radio_category_id" value="<?php echo $menu->id; ?>"></td>
				<td align="left"><?php echo $menu->name; ?></td>
			    <td align="left"><a href="<?=base_url(); ?>menu/create_layout/<?php echo $menu->id; ?>">Create/Edit Layout</a></td>
			    <td align="left"><?php echo $menu->home; ?></td>
			    <td align="left"><?php echo get_state_name($menu->menu_state_id); ?></td>
			    <td align="left">
			    <?php if($maxorder == $menu->ordering){ ?>
			    <a href="<?=base_url(); ?>menu/up/<?php echo $parent_menu[0]->id; ?>/<?php echo $menu->id; ?>">Up</a>			    
			    <?php }elseif($minorder == $menu->ordering){ ?>
			    <a href="<?=base_url(); ?>menu/down/<?php echo $parent_menu[0]->id; ?>/<?php echo $menu->id; ?>">Down</a>
			    <?php }else{?>
			    <a href="<?=base_url(); ?>menu/up/<?php echo $parent_menu[0]->id; ?>/<?php echo $menu->id; ?>">Up</a>
			    <a href="<?=base_url(); ?>menu/down/<?php echo $parent_menu[0]->id; ?>/<?php echo $menu->id; ?>">Down</a>
			    <?php } ?>
			    </td>
				</tr>
			<?php } else { ?>
				<tr class="rolover" <?php if ($item_counter%2 == 0){ ?>bgcolor="#f3f3f3" <?php } ?>>
				<td align="center"><?php echo $menu->id; ?></td>
				<td align="center"><input type="radio" name="menu_id" class="radio_category_id" value="<?php echo $menu->id; ?>" disabled></td>
				<td align="left"><?php echo $menu->name; ?></td>
			    <td align="left"><a href="<?=base_url(); ?>menu/create_layout/<?php echo $menu->id; ?>">Create/Edit Layout</a></td>
			    <td align="left"><?php echo $menu->home; ?></td>
			    <td align="left"><?php echo get_state_name($menu->menu_state_id); ?></td>
			    <td>
			    <?php if($maxorder == $menu->ordering){ ?>
			    <a href="<?=base_url(); ?>menu/up/<?php echo $parent_menu[0]->id; ?>/<?php echo $menu->id; ?>">Up</a>
			    <?php }elseif($minorder == $menu->ordering){ ?>
			    <a href="<?=base_url(); ?>menu/down/<?php echo $parent_menu[0]->id; ?>/<?php echo $menu->id; ?>">Down</a>
			    <?php }else{ ?>
			    <a href="<?=base_url(); ?>menu/up/<?php echo $parent_menu[0]->id; ?>/<?php echo $menu->id; ?>">Up</a>
			    <a href="<?=base_url(); ?>menu/down/<?php echo $parent_menu[0]->id; ?>/<?php echo $menu->id; ?>">Down</a>
			    <?php } ?>
			    </td>
				</tr>
			<?php } ?>
			<?php $level = ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$item_counter++;
			      if (check_menu_kids($menu->id) > 0){
		             recursion_menus_table($menu->id, $level, &$item_counter, $parent_menu[0]->id);
		          } ?>
			<?php }
		}else{ ?>
			<th colspan="3"><div><?php echo $no_items; ?></div></th>
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
	var url_edit = "<?=base_url(); ?>menu/edit_item/<?php echo $parent_menu[0]->id; ?>"+menu_id;
        $("#edit_category_button").attr("href", url_edit);
        $(".delete_category_button").attr("id", menu_id);
        $(".set-as-home").attr("id", menu_id);
});
//create ajax for deleting categories, remove href from 
$('.delete_category_button').click(function() {
	var menu_id = $("input[name='menu_id']:checked").val();
	var answer = confirm("Are you sure?");
	if (answer == true){
		var url = "<?php echo base_url(); ?>menu/delete/"+ <?php echo $parent_menu[0]->id; ?> +"/"+menu_id;
		top.location.href = url;
	}
});

$('#unpublish_story_button').click(function() {
	var menu_id = $("input[name='menu_id']:checked").val();
	if(menu_id > 0){
	
		var url = "<?php echo base_url(); ?>menu/unpublish/"+ <?php echo $parent_menu[0]->id; ?> +"/"+menu_id;
		top.location.href = url;
	
	}
});

$('#publish_story_button').click(function() {
	var menu_id = $("input[name='menu_id']:checked").val();
	if(menu_id > 0){
		var url = "<?php echo base_url(); ?>menu/publish/"+ <?php echo $parent_menu[0]->id; ?> +"/"+menu_id;
		top.location.href = url;
	}
});

$('.set-as-home').click(function() {

	var menu_id = $(this).attr('id');
	if(menu_id > 0){
		var answer = confirm("Set this menu item as Home ?");
		if (answer == true){
			var url = "<?php echo base_url(); ?>menu/set_as_home/"+ <?php echo $parent_menu[0]->id; ?> +"/"+menu_id;
			top.location.href = url;
		}
	}
});
</script>
</html>