<div class="forma-pretraga">

<form action="<?php echo base_url(); ?>tags/post/" method="post" >
		<?php if(count($topics) > 0) { ?>
		  <?php $i = 0;
		  //foreach system topic display tags as select
		  foreach ($topics as $topic) { ?>
		  	<?php 
		  	//this is temporary to find out design issue
		  	if($i < 1){?>
		    <label><?php echo $topic->name; ?>:</label>
		    <select class="pretraga" name="tag_<?php echo $i; ?>">
			  <?php foreach($tags[$topic->id] as $tag) { ?>
			  <option value="<?php echo $tag->id; ?>"><?php echo $tag->tag; ?></option>
			  <?php } ?>
		    </select>
		  	<?php } ?>
			<?php $i++; } ?>
            <?php } ?>
         <input name="id" type="hidden" value="<?php echo $module_id; ?>" />
        <input type="submit" value="ИЗАБЕРИ" class="button">
</form>
</div>



