<div class="headcont">
<h1 class="heading">Add new module</h1>
	<?php if (isset($message)) {
		if($message <> ""){ ?>
			 <div class="message" id="message"><?php echo $message; ?></div>
		<?php } ?>
	<?php } ?>
	
<div class="clear"></div>
</div>
<div class="container">
<form method="POST" action="<?=base_url(); ?>module/add_new/">
<div class="right-panel">
<h5>Properties</h5>
<div class="box-right-panel">
<div class="box-right-panel-inbox">
<div class="table-minicat">

</div>
</div><!--end of box-right-panel-inbox -->
</div><!--end of box-right-panel -->
</div><!--end of right-panel -->

<div class="left-panel">
	<?php echo validation_errors('<div class="error">', '</div>'); ?>
		<label for="category_name"><strong>Module Name:</strong></label><br />
		<input class="lform2" type="text" name="name" value=""><br />
		<label for="category_name"><strong>Default params:</strong></label><br />
		<textarea class="lform2-textarea" style="width: 700px;" name="params" cols="50" rows="5" value=""></textarea><br />
		<label for="category_name">*format of params must be param_name1=value;param_name2=value;</label><br />
		<label for="client"><strong>Choose Client:</strong></label><br />
		<select class="filter" name="client">
			  <option value="0">Choose client ...</option>
			  <?php foreach($clients as $client) { ?>
			  <option value="<?php echo $client->id; ?>"><?php echo $client->table_name; ?></option>
			  <?php } ?>
		    </select><br />
		<label for="category_name"><strong>Description:</strong></label><br />
		<input class="lform2" type="text" name="description" value=""></textarea><br />
		<input class="button-1" type="submit" value="Add module">
	
</div>  
<div class="clear"></div>
</form>     
</div>    
</body>
</html>