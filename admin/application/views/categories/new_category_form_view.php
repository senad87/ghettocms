<div class="headcont">
<h1 class="heading">Add new category</h1>

 
	<?php if (isset($message)) {
		if($message <> ""){ ?>
			 <div class="message" id="message"><?php echo $message; ?></div>
		<?php } ?>
	<?php } ?>
	
<div class="clear"></div>
</div>
<div class="container">
<form method="POST" action="<?=base_url(); ?>category/add_new/">
<div class="right-panel">
<h5>Choose category:</h5>
<div class="box-right-panel">
<div class="box-right-panel-inbox">
<div class="table-minicat">
<table class="data" border="0" cellpadding="0" cellspacing="0">
	<thead>
	</thead>
	<?php foreach ($root_categories as $root_category) { ?>
	<tr class="rolover">
	<?php if (check_category_entries($root_category->id) == 0 ) {?>
	<td width="8" align="center"><input type="radio" name="parent_category_id" class="radio_category_id" value="<?php echo $root_category->id; ?>"/></td>
	<td><a href="<?=base_url(); ?>category/edit/<?php echo $root_category->id; ?>"><?php echo $root_category->name; ?></a></td>
	<? } else { ?>
	<td width="8" align="center"><input type="radio" name="parent_category_id" class="radio_category_id" value="<?php echo $root_category->id; ?>" disabled></td>
	<td><a href="<?=base_url(); ?>category/edit/<?php echo $root_category->id; ?>"><?php echo $root_category->name; ?></a></td>
	<?php } ?>
	</tr>
	<?php 
	$level = ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	recursion_categories_new($root_category->id, $level); 
	} ?>
	<tfoot>
	</tfoot>
</table>
</div>
</div><!--end of box-right-panel-inbox -->
</div><!--end of box-right-panel -->
</div><!--end of right-panel -->
<div class="left-panel">
	<?php echo validation_errors('<div class="error">', '</div>'); ?>
	
		<label for="category_name"><strong>Name:</strong></label><br />
		<input class="lform2" type="text" name="category_name" value=""><br />
		<label for="category_name"><strong>Description:</strong></label><br />
		<textarea class="lform2-textarea" type="text" name="description" value=""></textarea><br />
		<input class="button-1" type="submit" value="Add category">
	
</div>
</form>
<div class="clear"></div>      
</div>    
</body>
</html>