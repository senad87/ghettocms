<div class="headcont">
<h1 class="heading">Edit menu</h1>
	<?php if (isset($message)) {
		if($message <> ""){ ?>
			 <div class="message" id="message"><?php echo $message; ?></div>
		<?php } ?>
	<?php } ?>	
<div class="clear"></div>
</div>
<div class="container">
<form method="POST" action="<?=base_url(); ?>menu/update_menuitem_data/">
	<div class="right-panel">
	<h5>Choose Parent Menu:</h5>
	<div class="box-right-panel">
	<div class="box-right-panel-inbox">
	<div class="table-minicat">
	
	<table class="data" border="0" cellpadding="0" cellspacing="0">
		<thead>
		</thead>
		<?php foreach ($root_menus as $root_menu) { ?>
			<tr class="rolover">
			<td width="8" align="center"><input type="radio" name="menu_id" class="radio_category_id"  value="<?php echo $root_menu->id; ?>"></td>
			<td><?php echo $root_menu->name; ?></td>
			</tr>
		<?php  $level = ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		recursion_menus_right_panel_edit($root_menu->id, $level); 
		} ?>
		<tfoot>
		</tfoot>
	</table>
	</div>
	</div>
	</div>
	</div> <!-- end of right-panel -->
	<div class="left-panel">
		<label for="category_name"><strong>Name:</strong></label><br>
		<input class="lform2" type="text" name="name" value="<?php echo $menu->name; ?>"><br />
		<input type="hidden" name="root_menu_id" value="<?php echo $root_parent_id; ?>"/>
		<select class="filter" id="menu_type" name="menu_type">
			<?php foreach($menu_types as $type){?>
			<option value="<?php echo $type->id; ?>" <?php if($type->id == $menu->menu_type_id){ ?>selected="selected"<?php }?>><?php echo $type->name; ?></option>
			<?php } ?>
			</select><br /><br />
			<div id="external_url" <?php if($menu->menu_type_id != 3){?>style="display:none;"<?php } ?>>
				<label for="category_name"><strong>Url:</strong></label><br />
				<input class="lform2" type="text" name="url" value="<?php echo $menu->url; ?>"></textarea><br />
				<label for="category_name"><strong>Open in new tab:</strong></label><br />
				<input type="checkbox" name="new_window" value="1" <?php if($menu->open_in == 1){?>checked="checked"<?php } ?>></textarea><br />			
			</div><br />
		<input type="hidden" name="menu_id" value="<?php echo $menu->id; ?>"><br />
		<input class="button-1" type="submit" value="Save changes" style="float: left;"> 
		<input class="button-1" id="btnCancel" type="button" value="Cancel">	
	</div> 
	<div class="clear"></div>
</form>   
</div>
</body>
<script type="text/javascript">
$('#btnCancel').click(function ()
    {
        $(window.location).attr("href", "<?php echo base_url(); ?>menu/items_list/<?php echo $root_parent_id; ?>");

    });

//select all checkboxes in the list
$(document).ready(function()
{
	$("#menu_type").change(function()				
	{
		var type_id = $(this).val();
		if(type_id == 3){
			$("#external_url").removeAttr("style");
		}else{
			$("#external_url").attr("style","display:none;");
		}
	});					
});
</script>
</html>