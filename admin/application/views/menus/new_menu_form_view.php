<div class="headcont">
<h1 class="heading">Add new menu</h1>
	<?php if (isset($message)) {
		if($message <> ""){ ?>
			 <div class="message" id="message"><?php echo $message; ?></div>
		<?php } ?>
	<?php } ?>
	
<div class="clear"></div>
</div>
<div class="container">
<form method="POST" action="<?=base_url(); ?>menu/add_new/">
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
		<label for="category_name"><strong>Menu Name:</strong></label><br />
		<input class="lform2" type="text" name="name" value=""><br />
		<input type="hidden" name="menu_id" value="0"></textarea>
		<input class="button-1" type="submit" value="Add menu">
		<input class="button-1" id="btnCancel" type="button" value="Cancel">
</div>  
<div class="clear"></div>
</form>     
</div>    
</body>
<script type="text/javascript">
$('#btnCancel').click(function (){
        $(window.location).attr("href", "<?php echo base_url(); ?>menu/");
    });
</script>
</html>