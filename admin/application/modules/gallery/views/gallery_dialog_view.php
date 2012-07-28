<div id="gallery-dialog" style="display: none;" title="Choose Gallery">
<div id="content">
<table class="data" border="0" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
		<th width="35" style="text-align: center;">ID</th>
		<th style="text-align: center;" width="10">#</th>
		<th width="300" align="left">Title</th>
		</tr>
		</thead>
		<?php $i=0; ?>
		<?php if (isset($galleries)){ ?>
		<?php foreach($galleries as $gallery) { ?>
			<tr class="rolover" <?php if ($i%2 == 0){ ?> bgcolor="#f3f3f3" <?php } ?>>
			<td align="right"><?php echo $gallery['id']; ?></td>
			<td align="center" width="20"><input type="radio" name="story_id" value="<?php echo $gallery['id']; ?>"></td>
			<td align="left"><?php echo $gallery['title']; ?></td>
			</tr>
		<?php $i++; ?>
		<?php } ?>
		<?php }else{ ?>
   			<tr><td colspan="8"><?php echo $no_entries; ?></td></tr>
   	 	<?php } ?>
		<tfoot>
			<tr>
		<th colspan="8"><div><?php echo $pagination; ?></div></th>
		</tr>
		</tfoot>
</table>
</div>
</div>

<script src="<?php echo base_url(); ?>application/modules/gallery/scripts/gallery.dialog.js" type="text/javascript" ></script>