<div style="width: 592px; height:143px; background-color: #553d7a;> <a href="http://poslovi.nsz.gov.rs" target="_blank"><img style="border: 0;" src="http://poslovi.nsz.gov.rs/images/newsletter/header.jpg" width="592" height="145" /></a></div>


<div class="box" style="width: 590px; background: #faf9fc; padding-top: 25px; padding-bottom: 25px; border: 1px solid #f1f1f1; border-top: 0; color: #333333;">
<div style="margin-left: 25px; font-size: 15px; color: #000; font-weight: bold;">У новом броју:</div>

<?php foreach($stories as $story){?>
<div style="margin-top: 25px; margin-left: 25px; margin-right: 20px; padding-bottom: 15px; border-bottom: 1px dashed #f1f1f1;">
		<!-- start slika -->
<a href="<?php echo root_url();?>page/index/<?php echo $home_id;?>/story/<?php echo $story->id; ?>" target="_blank">
							<img width="150px;" height="100px;" alt="<?php echo $story->title; ?>" title="<?php echo $story->title; ?>" src="<?php echo root_url().substr($thumb_images[$story->id][0]->path, 2); ?>"  style=" float: left; position: relative; margin-right: 10px; border: 1px solid #f1f1f1;">
				</a>
        <!-- end slika -->


	<h4 style="font-size: 15px; margin-bottom: 5px;"><a style="text-decoration: none; color: #333333;" href="<?php echo root_url();?>page/index/<?php echo $home_id;?>/story/<?php echo $story->id; ?>" target="_blank" ><?php echo $story->title; ?></a></h4>

						<div style="font-size: 13px; overflow: auto;"><?php echo $story->lead; ?> </div>
        <div style="clear: both;"></div>
	</div>
	<?php $ids[]=$story->id; ?>
<?php } ?>	
</div>
<input type="hidden" value=<?php echo serialize($ids);?> name="ids" />