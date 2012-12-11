<?php if(isset($message) && $message !=""){?>
	<div><?php echo $message; ?></div>
<?php }else{ ?>
<div id="<?php echo $module_id; ?>" class="box<?php if(isset($module_params['classsuffix']) && $module_params['classsuffix'] != "") echo $module_params['classsuffix']; ?>">
	<h1 class="title"><?php if($module_params['box_title'] != ""){ echo $module_params['box_title']; }?></h1>
	<?php
	//counter of the displayed articles
	$a = 1;
	foreach($stories_row as $story){ ?>
	<div class="article-item">
		<!-- start slika -->
		<?php if($module_params['poster_photo'] >= $a){?>
		<a href="<?php echo base_url(); ?>page/index/<?php echo $data['menu_id']; ?>/story/<?php echo $story['id']; ?>">
			<?php if(count($story['photo_path']) > 0){ ?>
				<img src="<?php echo base_url(); ?><?php echo $story['photo_path']; ?>" title="<?php echo $story['title']; ?>" alt="<?php echo $story['title']; ?>" />
			<?php } ?>
			</a>
        <!-- end slika -->
		<?php } ?>
		<?php if($module_params['title'] >= $a){?>
			<h2 class="title"><a href="<?php echo base_url(); ?>page/index/<?php echo $data['menu_id']; ?>/story/<?php echo $story['id']; ?>"><span><?php echo $story['title']; ?></span></a></h2>
		<?php } ?>
			<div class="infoline">
				
                <?php if($module_params['category_name'] >= $a){ ?>
				<?php echo $story['categories_names']; ?> :
				<?php } ?>
			    <?php if($module_params['author'] >= $a){?>
					Postavio: <a href="#"><?php echo $story['author_name']; ?></a>
				<?php } ?>
				
				<?php if($module_params['creation_date'] >= $a){ ?>
				<span class="date"><?php echo srb_date($story['creation_date']); ?></span>
				<?php } ?>
				<?php if($story['tag_id'] > 0){?>
				<a href="<?php echo base_url();?>tags/index/<?php echo $data['menu_id']; ?>/<?php echo $story['tag_id']; ?>"><?php echo $story['tag']; ?></a>
				<?php } ?>
                
			<?php if($module_params['number_of_comments'] >= $a){ ?>
			<span class="article_comments_number">| <a href="<?php echo base_url(); ?>page/index/<?php echo $data['menu_id']; ?>/story/<?php echo $story['id']; ?>"><?php echo count_comments($story['id']);?> komentara</a></span>
			<?php } ?>                

			</div>    
			<?php if($module_params['lead'] >= $a){?>
			<div class="lead"><?php echo $story['lead']; ?></div>
			<?php } ?>
			<?php if($module_params['readmore'] >= $a){?>
			<div class="readmore"><a href="<?php echo base_url(); ?>page/index/<?php echo $data['menu_id']; ?>/story/<?php echo $story['id']; ?>">Opširnije ></a></div>
			<?php } ?>

		
        <div class="clear separator"></div>
	</div><!-- end article item -->
	<?php $a++;
	} 
	?>
	<?php if($module_params['link_title'] != ""){?>
		<div class="mainlink"><a href="<?php echo base_url(); ?><?php if($module_params['link_url'] != ""){ echo $module_params['link_url']; }?>" /> <?php echo $module_params['link_title']; ?> > </a></div>
	<?php } ?>
	<?php if($total_rows > $module_params['number']){?>
		<div class="pagination<?php if(isset($module_params['classsuffix']) && $module_params['classsuffix'] != "") echo $module_params['classsuffix']; ?>"><?php echo $pagination; ?></div>
	<?php } ?>
</div>
<?php } ?>