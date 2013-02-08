<div class="headcont">
<h1 class="heading">Select template</h1>
	<?php if (isset($message)) {
		if($message <> ""){ ?>
			 <div class="message" id="message"><?php echo $message; ?></div>
		<?php } ?>
	<?php } ?>	
<div class="clear"></div>
</div>
<div class="container">
<div class="right-panel">

<h5>Properties:</h5>
<div class="box-right-panel">
<div class="box-right-panel-inbox">
<div class="table-minicat">
</div>
</div>
</div>
</div> <!-- end of right-panel -->
<div class="left-panel">
	<form method="POST" action="<?=base_url(); ?>menu/create_layout/<?php echo $menu_id; ?>">
	<label for="template">Select template:</label><br />
		    <select class="filter" name="template">
		      <option value="0">Select...</option>
			  <?php foreach($templates as $template) { ?>
			  <option value="<?php echo $template->id; ?>"><?php echo $template->name; ?></option>
			  <?php } ?>
		    </select><br />
	<input class="button-1" type="submit" value="Select" style="float: left;"> 
	<input class="button-1" id="btnCancel" type="button" value="Cancel">
	</form>
	
</div> 
<div class="clear"></div>   
</div>    
</body>
<script type="text/javascript" src="<?php echo base_url(); ?>system/application/style/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
$('#btnCancel').click(function ()
    {
        $(window.location).attr("href", "<?php echo base_url(); ?>menu");

    });
</script>
</html>
