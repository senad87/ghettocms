Кључна реч: <strong><?php echo $keyword;?></strong><br />
<?php if(isset($results)){?>
	<ul class="rubrike">
	<?php foreach($results as $result){?>
	<li>
	<h2 class="title"><a href="<?php echo base_url(); ?>page/index/<?php echo $menu_id; ?>/story/<?php echo $result->id; ?>"><span><?php echo $result->title; ?></span></a></h2>
	<span class="date"><?php echo srb_date($result->creation_date);?></span>
	<div class="lead">
	<?php echo $result->lead; ?>
	</div>
	</li>
	<?php } ?>
	</ul>
	<div class="pagination"><?php echo $pagination; ?><div>
	</div>
	</div>
<?php }else{?>
	<?php echo $message;?>
<?php }?>

	
