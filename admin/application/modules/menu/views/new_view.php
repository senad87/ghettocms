<div class="headcont">
<h1 class="heading">Add new menu</h1>
	<?php echo modules::run('toolbar', 'menu_title', 'menu', array('save', 'cancel')); ?>
<div class="clear"></div>
</div>
<div class="container">

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
<form method="POST" action="<?=base_url(); ?>menu/createNew_post/" id="menu_form">
	<?php echo validation_errors('<div class="error">', '</div>'); ?>
		<label for="category_name"><strong>Menu Name:</strong></label><br />
		<input class="lform2" type="text" name="name" value=""><br />
		<input type="hidden" name="menu_id" value="0"></textarea>
</form>
</div>  
<div class="clear"></div>
     
</div>    
</body>

</html>
