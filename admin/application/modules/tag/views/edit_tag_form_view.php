<div class="headcont">
<h1 class="heading">Edit Tag</h1>
<?php echo modules::run('toolbar', 'tag_title', 'tag', array('save', 'cancel')); ?>	
	
<div class="clear"></div>
</div>
<div class="container">
<div class="right-panel">
<h5>Properties</h5>
<div class="box-right-panel">
<div class="box-right-panel-inbox">
No properties

</div>
</div>
</div>
<div class="left-panel">
	<?php echo validation_errors('<div class="error">', '</div>'); ?>
	<?php echo form_open('tag/edit_post/',  array('id'=>'tag_form')); ?>
		<label for="title"><strong>Tag:</strong></label><br />
		<input class="lform2" type="text" name="tag" size="20" value="<?php echo $tag->tag; ?>">
		<input type="hidden" name="id" size="20" value="<?php echo $tag->id; ?>">
		<div class="tag-filters" style="margin-top: 10px;">
        <label for="privileges"><strong>Select topic:</strong></label><br />
		<select class="filter" name="topic_id">
			<?php foreach($topics as $topic){ ?>
			<option <?php if($topic->id == $tag->topic_id){ ?> selected="selected" <?php } ?>value="<?php echo $topic->id; ?>"><?php echo $topic->name; ?></option>
			<?php } ?>
		</select>
        </div>
        <br />
		<!--  <input class="button-1" type="submit" value="Save changes" style="float: left;"> 
	</form> <input class="button-1" type="submit" id="btnCancel" value="Cancel">-->
</div>
<div class="clear"></div>      
</div>    
</body>
</html>
<script type="text/javascript">
$('#btnCancel').click(function ()
{
	$(window.location).attr("href", "<?php echo base_url(); ?>tag");

});
</script> 