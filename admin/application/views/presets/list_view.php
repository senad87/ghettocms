<table class="data" border="0" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
		<th width="35" style="text-align: center;">ID</th>
		<th style="text-align: center;" width="10">#</th>
		<th width="300" align="left">Preset name</th>
		<th width="300" align="left">Description</th>
		<th width="300" align="left">Used template</th>
		</tr>
		</thead>
		<?php 
		$i=0;
		if (isset($items)){
		foreach($items as $item) { ?>
			<tr class="rolover" <?php if ($i%2 == 0){ ?> bgcolor="#f3f3f3" <?php } ?>>
			<td align="right"><?php echo $item['id']; ?></td>
			<td align="center" width="20"><input type="radio" name="item_id" data-tpl="<?php echo $item['tpl_id']; ?>" value="<?php echo $item['id']; ?>"></td>
			<td align="left"><?php echo $item['name']; ?></td>
			<td align="left"><?php echo $item['description']; ?></td>
			<td align="left"><?php echo $item['tpl_name']; ?></td>
			</tr>
		<?php 
		$i++;
		 } ?>
		 <?php } else { ?>
    <tr><td colspan="8"><?php echo $no_entries; ?></td></tr>
    <?php } ?>
		<tfoot>
			<tr>
		<th colspan="8"><div><?php echo $pagination; ?></div></th>
		</tr>
		</tfoot>
</table>
<br />