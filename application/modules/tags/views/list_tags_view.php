<?php
if($tags){ ?>
	<strong>Tagovi:</strong>
	<br />
	<p class="tags">
	<?php foreach($tags as $tag){ ?>
		<a href="<?php echo base_url();?>tag/<?php echo $from_menu_id; ?>/<?php echo $tag->id; ?>/<?php echo url_title($tag->tag); ?>"><?php echo $tag->tag; ?></a> 
	<?php } ?>
	</p>
<?php } ?>