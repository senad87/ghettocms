	<h1 class="title"><?php echo $tag; ?></h1>
	<?php
	//counter of the displayed articles
	$a = 1;
	foreach($stories_row as $story){ ?>
		<div class="block">
		<div class="img-block2"><img
			src="<?php echo base_url(); ?><?php echo $story['photo_path']; ?>"
			title="<?php echo $story['title']; ?>"
			alt="<?php echo $story['title']; ?>" />
		<h2>
		<a href="<?php echo base_url(); ?><?php echo $story['type_name']; ?>/<?php echo $from_menu_id; ?>/<?php echo $story['id']; ?>/<?php echo url_title($story['title']); ?>">
		<span><?php echo $story['title']; ?></span>
		</a>
		</h2>
		</div>
		<div class="news-block">
		<div class="news-block-info">Postavio: <a href="#"><?php echo $story['author_name']; ?></a>
		<span class="separator">&nbsp;</span> <?php echo srb_date($story['creation_date']); ?>
		<span class="separator">&nbsp;</span> <a
			href="<?php echo base_url();?><?php echo $story['menu_name']->name; ?>/<?php echo $story['category']->menu_id; ?>/"><?php echo $story['menu_name']->name; ?></a>
		<span class="separator">&nbsp;</span> <a
			href="<?php echo base_url(); ?>page/index/<?php echo $from_menu_id; ?>/<?php echo $story['type_name']; ?>/<?php echo $story['id']; ?>"><?php echo count_comments($story['id']);?>
		komentara</a></div>
		<div class="news-block-lead"><?php echo $story['lead']; ?></div>
		<div class="readmore"><a
			href="<?php echo base_url(); ?><?php echo $story['type_name']; ?>/<?php echo $from_menu_id; ?>/<?php echo $story['id']; ?>/<?php echo url_title($story['title']); ?>">
		Opširnije > </a></div>
		
		
		</div>
		
		</div>
		
		<!-- end article item --> <?php $a++;
	}
	?>
	<?php if($total_rows > $per_page ){ ?>
	<div class="pagination"><?php echo $pagination; ?></div>
	<?php } ?>
