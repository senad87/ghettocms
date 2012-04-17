<!-- <table class="data" border="0" cellpadding="0" cellspacing="0">
<thead>
        <tr>
        <th width="16" style="text-align: center;">ID</th><th style="text-align: center;">#</th><th align="left">Tag</th>
        </tr>
</thead>
<?php 
$i=0;
foreach($tags as $tag) { ?>
<tr class="rolover" <?php if ($i%2 == 0){ ?> bgcolor="#f3f3f3" <?php } ?>>
<td style="text-align: center;"><?php echo $tag->id; ?></td><td width="16" style="text-align: center;"><input type="checkbox" name="tag_id" value="<?php echo $tag->id; ?>"></td><td align="left"><a href="<?=base_url(); ?>tag/edit/<?php echo $tag->id; ?>/"><?php echo $tag->tag; ?></a></td>
</tr>
		<?php 
		$i++;
		 } ?>
<tfoot>
<tr>
<th colspan="7">Paginacija</th>
</tr>
</tfoot>
</table> -->
