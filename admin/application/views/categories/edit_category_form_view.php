<div class="headcont">
<h1 class="heading">Edit category</h1>
	<?php if (isset($message)) {
		if($message <> ""){ ?>
			 <div class="message" id="message"><?php echo $message; ?></div>
		<?php } ?>
	<?php } ?>
	
<div class="clear"></div>
</div>
<div class="container">
<form method="POST" action="<?=base_url(); ?>category/update_data/">
<div class="right-panel">
<h5>Move to category:</h5>
<div class="box-right-panel">
<div class="box-right-panel-inbox">
<div class="table-minicat">
<table class="data" border="0" cellpadding="0" cellspacing="0">
	<thead>
	</thead>
	<?php foreach ($root_categories as $root_category) { ?>
	<tr class="rolover">
	<?php if (check_category_entries($root_category->id) == 0 && $root_category->id != $category->id) {?>
	<td width="8" align="center"><input type="radio" name="parent_category_id" class="radio_category_id" <?php if($root_category->id == $category->parent_id){?>checked="true"<?php } ?> value="<?php echo $root_category->id; ?>"/></td>
	<td><a href="<?=base_url(); ?>category/edit/<?php echo $root_category->id; ?>"><?php echo $root_category->name; ?></a></td>
	<? } else { ?>
	<td width="8" align="center"><input type="radio" name="parent_category_id" class="radio_category_id" value="<?php echo $root_category->id; ?>" disabled></td>
	<td><a href="<?=base_url(); ?>category/edit/<?php echo $root_category->id; ?>"><?php echo $root_category->name; ?>(<?php check_category_entries($root_category->id); ?>)</a></td>
	<?php } ?>
	</tr>
	<?php 
	$level = ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	recursion_categories($root_category->id, $level, $category); 
	} ?>
	<tfoot>
	</tfoot>
</table>
</div>
</div><!--end of box-right-panel-inbox -->
</div><!--end of box-right-panel -->
</div>
<div class="left-panel">
	
	<label for="category_name"><strong>Name:</strong></label>
	<br>
	<input class="lform2" type="text" name="category_name" value="<?php echo $category->name; ?>"><br />
	<label for="category_name"><strong>Description:</strong></label>
	<br>
    <textarea class="lform2-textarea" name="description"><?php echo $category->description; ?></textarea>
    <br />
	<input type="hidden" name="category_id" value="<?php echo $category->id; ?>"><br />
	<input class="button-1" type="submit" value="Save changes" style="float: left;">
	<input class="button-1" id="btnCancel" type="button" value="Cancel">
</div> 
<div class="clear"></div>   
</form>
</div>    
</body>
<script type="text/javascript">
$('#btnCancel').click(function ()
    {
        $(window.location).attr("href", "<?php echo base_url(); ?>category");

    });
</script>
</html>