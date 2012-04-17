<select name="" class="filter">
	<option selected="selected">Select subcategory...</option>
	<?php foreach($categories as $category){ ?>
		<option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
	<?php } ?>
</select>
