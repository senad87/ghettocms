<h5>Choose parent menu item:</h5>
<div class="box-right-panel">
	<div class="box-right-panel-inbox">
		<div class="table-minicat">
		<table class="data" border="0" cellpadding="0" cellspacing="0">
			<thead>
			</thead>
			<?php foreach ($root_menus as $root_menu) { ?>
				<tr class="rolover">
				<td width="8" align="center"><input type="radio" name="parent_id" class="radio_category_id"  value="<?php echo $root_menu->id; ?>" <?php if($parent_menu_id == $root_menu->id){?>checked="checked"<?php } ?>></td>
				<td><?php echo $root_menu->name; ?></td>
				</tr>
			<?php  $level = ".&nbsp;&nbsp;&nbsp;&nbsp;";
			recursion_menus_right_panel_edit($root_menu->id, $level, $parent_menu_id); 
			} ?>
			<tfoot>
			</tfoot>
		</table>
		</div>
	</div>
</div>