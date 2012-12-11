<!-- start holder_content -->
<div class="holder_content">


<!-- start container_left -->

<div id="container_left">

<h1>New Article</h1>

<!-- start form -->
<form method="post" action="<?php echo base_url();?>/createNew_post/">

<div class="holder_content_separator">
<label>Title:</label>
<input id="txtTitle" name="txtTitle" type="text" class="textbox" value="" />
</div>			   						   
<div class="holder_content_separator">
<label>Lead:</label>
<input id="txtName" name="txtName" type="text" class="textbox" value="" />

<div class="holder_content_separator">
<?php echo $this->ckeditor->editor("editor");?>
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
