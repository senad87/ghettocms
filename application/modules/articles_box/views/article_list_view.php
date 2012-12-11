<?php foreach($stories_row as $story){ ?>
<div class="block">
	<div class="img-block2"><img src="<?php echo base_url(); ?><?php echo $story['photo_path']; ?>" title="<?php echo $story['title']; ?>" alt="<?php echo $story['title']; ?>" width="660" height="410" />
	<?php if($module_params['title'] == 1){?>
		<h2><a href="<?php echo base_url(); ?>page/index/<?php echo $data['menu_id']; ?>/story/<?php echo $story['id']; ?>"><span><?php echo $story['title']; ?></span></a></h2>
	<?php } ?>
	</div>
	<div class="news-block">
	<div class="news-block-info">
	<?php if($module_params['author'] == 1){?>
		Postavio: <a href="#"><?php echo $story['author_name']; ?></a>
	<?php } ?>
		<span class="separator">&nbsp;</span>02.10.2010<span class="separator">&nbsp;</span><?php if($module_params['categories'] == 1){ ?><a href="#"><?php echo $story['categories_names']; ?></a><?php } ?><span class="separator">&nbsp;</span><a href="#">90
		komentara</a></div>
		<?php if($module_params['lead'] == 1){?>
		<div class="news-block-lead"><?php echo $story['lead']; ?></div>
		<div class="readmore"><a href="<?php echo base_url(); ?>page/index/<?php echo $data['menu_id']; ?>/story/<?php echo $story['id']; ?>">Opširnije ></a></div>
		<?php } ?>
	</div>
</div>
<?php } ?>