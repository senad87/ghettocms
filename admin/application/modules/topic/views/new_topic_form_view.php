<div class="headcont">
<h1 class="heading">Add New Topic</h1>
<?php echo modules::run('toolbar', 'topic_title', 'topic', array('save', 'cancel')); ?>	
<div class="clear"></div>
</div>
<div class="container">
<div class="right-panel">
<h5>Properties</h5>
<div class="box-right-panel">
<div class="box-right-panel-inbox">
There is no properties for this item.
</div>
</div>
</div>
<div class="left-panel">
	<?php echo validation_errors('<div class="error">', '</div>'); ?>
	<?php echo form_open('topic/createNew_post', array('id'=>'topic_form')); ?>
		<label for="title"><strong>Topic name:</strong></label><br />
		<input class="lform2" type="text" name="name" size="20" value=""><br />
		<label for="title"><strong>Topic description:</strong></label><br />
		<input class="lform2" type="text" name="description" size="20" value=""><br />
		<br />
	</form>    
</div>
<div class="clear"></div>     
</div>    
</body>
</html>
