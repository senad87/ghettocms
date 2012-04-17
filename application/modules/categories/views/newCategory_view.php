<!-- start holder_content -->
<div class="holder_content">
<!-- start container_left -->
<div id="container_left">
<h1><?php echo $this->lang->line('new_category_title'); ?></h1>
<!-- start form -->
<form method="post" action="<?php echo base_url();?>categories/createNew_post/">

<div class="holder_content_separator">
<label>Title:</label>
<input id="txtTitle" name="title" type="text" class="textbox" value="" />
</div>	
		   						   
<div class="holder_content_separator">
<label>Description:</label>
<input id="txtName" name="description" type="text" class="textbox" value="" /></div>

<div class="holder_content_separator">
<label>Select section:</label>
<select name="section_id">
<?php foreach($sections as $section){ ?>
<option value="<?php echo $section->id;?>"><?php echo $section->title;?></option>
<?php } ?>
</select>
</div>

<div class="holder_content_separator">
<input name="Submit" type="submit" class="submit_button" value="Submit" />
</div>
</div>
</form>
<!-- end form -->
</div>
<!-- end container_right -->
</div>
<!-- end holder_content -->
</div>
<!-- end container -->
