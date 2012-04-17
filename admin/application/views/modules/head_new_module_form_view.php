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
<h5>Display module on selected menus:</h5>
<div class="box-right-panel">
<div class="box-right-panel-inbox">

</div><!--end of box-right-panel-inbox -->
</div><!--end of box-right-panel -->
</div><!--end of right-panel -->

<div class="left-panel">
<?php echo validation_errors('<div class="error">', '</div>'); ?>
<label for="title"><strong>Module name:</strong></label><br />
<input class="lform2" style="width: 700px;" type="text" name="module_title" size="50" value=""><br />
<label for="lead"><strong>Module Desription:</strong></label><br />
<textarea class="lform2-textarea" style="width: 700px;" name="module_description" cols="50" rows="5" value=""></textarea><br />
<input type="hidden" name="module" value="<?php echo $module; ?>" /><br />
<p>---Ovo iznad su parametri koje ima svaki modul a ispod parametri koji se vuku iz XML i zavise od tipa modula---</p>