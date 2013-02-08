<table class="data" border="0" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
		<th width="18" style="text-align: center;">ID</th><th width="10" style="text-align: center;">#</th><th align="left">Menu</th>
		</tr>
		</thead>
		<?php $item_counter = 0;
		foreach ($root_menus as $menu) { ?>
			<tr class="rolover" <?php if ($item_counter%2 == 0){ ?>bgcolor="#f3f3f3" <?php } ?>>
			<td align="center"><?php echo $menu->id; ?></td>
			<td align="center"><input type="radio" name="menus_id" class="radio_category_id" value="<?php echo $menu->id; ?>"></td><td align="left"><?php echo $menu->name; ?></td>
			</tr>
		<?php } ?>
		<tfoot>
			<tr>
		<th colspan="3"><div></div></th>
		</tr>
		</tfoot>
	</table>