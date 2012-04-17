<div id="content">
<table class="data" border="0" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
		<th width="35" style="text-align: center;">ID</th>
		<th style="text-align: center;" width="10">#</th>
		<th width="300" align="left">Title</th>
		</tr>
		</thead>
		<?php 
		$i=0;
		if (isset($stories)){
		foreach($stories as $story) { ?>
			<tr class="rolover" <?php if ($i%2 == 0){ ?> bgcolor="#f3f3f3" <?php } ?>>
			<td align="right"><?php echo $story->id; ?></td>
			<td align="center" width="20"><input type="radio" name="story_id" value="<?php echo $story->id; ?>"></td>
			<td align="left"><?php echo $story->title; ?></td>
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
</div><br />