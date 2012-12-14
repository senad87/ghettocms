
<div class="contentTitleZone" style="margin: -10px; border-radius: 5px 5px 0 0;">
         	<h1>Pretraga</h1>
            <p>Rezultati za reč: <strong><?php echo $keyword;?></strong></p>
         </div>


<?php //var_dump($results);?>
<?php if(isset($results) && $results){?>
<div class="contentList">
	<ul class="rubrike">
	<?php foreach($results as $result){?>
	<li>
	<h2 class="title"><a href="<?php echo base_url(); ?>page/index/<?php echo $menu_id; ?>/story/<?php echo $result->id; ?>"><span><strong><?php echo $result->title; ?></strong></span></a></h2>
	<span class="date"><?php echo srb_date($result->creation_date);?></span>
	<div class="lead">
	<?php echo $result->lead; ?>
	</div>
	</li>
	<?php } ?>
	</ul>
   </div>
	<div class="pagination"><?php //echo $pagination; ?><div>
	</div>
	</div>
<?php }else{?>
	<div class="noResults"><?php echo $message;?></div>
<?php }?>

	
