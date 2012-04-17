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
<div class="right-panel">

<h5>Choose Parent Menu:</h5>
<div class="box-right-panel">
<div class="box-right-panel-inbox">
<div class="table-minicat">
<!-- <table class="data" border="0" cellpadding="0" cellspacing="0">
	<thead>
	</thead>
	<tr class="rolover">
	<td width="8" align="center"><input type="radio" name="menu_id" class="radio_category_id" value="0"/></td>
	<td>Create New Menu</td>
	</tr>
	<?php foreach ($root_menus as $root_menu) { ?>
	<tr class="rolover">
	<?php if (check_menu_modules($root_menu->id) == 0) {?>
	<td width="8" align="center"><input type="radio" name="menu_id" class="radio_category_id" <?php if($root_menu->id == $menu->parent_id){?>checked="checked"<?php }?> value="<?php echo $root_menu->id; ?>"/></td>
	<td><?php echo $root_menu->name; ?></td>
	<? } else { ?>
	<td width="8" align="center"><input type="radio" name="menu_id" class="radio_category_id" <?php if($root_menu->id == $menu->parent_id){?>checked="checked"<?php }?> value="<?php echo $root_menu->id; ?>" disabled></td>
	<td><?php echo $root_menu->name; ?></td>
	<?php } ?>
	</tr>
	<?php 
	$level = ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	recursion_menus_right_panel_edit($root_menu->id, $level); 
	} ?>
	<tfoot>
	</tfoot>
</table> -->
</div>
</div>
</div>
</div> <!-- end of right-panel -->
<div class="left-panel">
	<form method="POST" action="<?=base_url(); ?>menu/update_data/">
	<label for="category_name"><strong>Name:</strong></label><br>
	<input class="lform2" type="text" name="name" value="<?php echo $menu->name; ?>"><br />
	<input type="hidden" name="menu_id" value="<?php echo $menu->id; ?>"><br />
	<input class="button-1" type="submit" value="Save changes" style="float: left;"> 
	<input class="button-1" id="btnCancel" type="button" value="Cancel">
	</form>
	
</div> 
<div class="clear"></div>   
</div>    
</body>
<script type="text/javascript" src="<?php echo base_url(); ?>system/application/style/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
$('#btnCancel').click(function ()
    {
        $(window.location).attr("href", "<?php echo base_url(); ?>menu");

    });
</script>
</html>