<div class="headcont">
<h1 class="heading">Add new menu</h1>
	<?php if (isset($message)) {
		if($message <> ""){ ?>
			 <div class="message" id="message"><?php echo $message; ?></div>
		<?php } ?>
	<?php } ?>
<div class="clear"></div>
</div>
<div class="container">
<form method="POST" action="<?=base_url(); ?>menu/add_new_item/">
<div class="right-panel">
<h5>Choose Parent Menu:</h5>
<div class="box-right-panel">
<div class="box-right-panel-inbox">
<div class="table-minicat">
<table class="data" border="0" cellpadding="0" cellspacing="0">
	<thead>
	</thead>
	<tr class="rolover">
	<td width="8" align="center"><input type="radio" name="menu_id"  class="radio_category_id" value="<?php echo $parent[0]->id; ?>" checked="checked"/></td>
	<td><?php echo $parent[0]->name; ?></td>
	</tr>
	<?php foreach ($menus as $root_menu) { ?>
	<tr class="rolover">
	<?php //if (check_menu_modules($root_menu->id) == 0) {?>
	<td width="8" align="center"><input type="radio" name="menu_id" class="radio_category_id" value="<?php echo $root_menu->id; ?>"/></td>
	<td>.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $root_menu->name; ?></td>
	<? /*} else { ?>
	<td width="8" align="center"><input type="radio" name="menu_id" class="radio_category_id" value="<?php echo $root_menu->id; ?>" disabled></td>
	<td>.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $root_menu->name; ?></td>
	<?php } */?>
	</tr>
	<?php 
	$level = ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	recursion_menus_right_panel($root_menu->id, $level); 
	} ?>
	<tfoot>
	</tfoot>
</table>
</div>
</div><!--end of box-right-panel-inbox -->
</div><!--end of box-right-panel -->
</div><!--end of right-panel -->
<div class="left-panel">
	<?php echo validation_errors('<div class="error">', '</div>'); ?>
		<label for="category_name"><strong>Menu Name:</strong></label><br />
		<input class="lform2" type="text" name="name" value=""><br />
		<input type="hidden" name="root_menu_id" value="<?php echo $parent[0]->id; ?>"/>
		<select class="filter" id="menu_type" name="menu_type">
		<?php foreach($menu_types as $type){?>
		<option value="<?php echo $type->id; ?>"><?php echo $type->name; ?></option>
		<?php } ?>
		</select><br /><br />
		<div id="external_url" style="display:none;">
			<label for="category_name"><strong>Url:</strong></label><br />
			<input class="lform2" type="text" name="url" value=""></textarea><br />
			<label for="category_name"><strong>Open in new tab:</strong></label><br />
			<input type="checkbox" name="new_window" value="1"></textarea><br />			
		</div><br />
		<input class="button-1" type="submit" value="Add menu">
		<input class="button-1" id="btnCancel" type="button" value="Cancel">
</div>  
<div class="clear"></div>
</form>     
</div>    
</body>
<script type="text/javascript" src="<?php echo base_url(); ?>system/application/style/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
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
	$('#btnCancel').click(function (){
        $(window.location).attr("href", "<?php echo base_url(); ?>menu/items_list/<?php echo $parent[0]->id; ?>");
    });				
});
</script>
</html>