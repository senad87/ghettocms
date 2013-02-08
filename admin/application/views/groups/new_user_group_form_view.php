<div class="headcont">
<h1 class="heading">Add New Group</h1>

 
	<?php if (isset($message)) {
		if($message <> ""){ ?>
			 <div class="message" id="message"><?php echo $message; ?></div>
		<?php } ?>
	<?php } ?>
	
<div class="clear"></div>
</div>
<div class="container">
<div class="right-panel">
<h5>Properties</h5>
<div class="box-right-panel">
<div class="box-right-panel-inbox">
There is no properties for this item.

</div>
</div>

</div>
<div class="left-panel">


	<?php echo validation_errors('<div class="error">', '</div>'); ?>
	<?php echo form_open('group/add/'); ?>
		<label for="title"><strong>Group name:</strong></label><br />
		<input class="lform2" type="text" name="name" size="20" value=""><br />
		
		<label for="privileges"><strong>Select group privilegies:</strong></label><br />
                <table class="data" border="0" cellpadding="0" cellspacing="0">
                <thead>
                        <tr>
                        <th width="16" style="text-align: center;">ID</th><th width="16" style="text-align: center;"><input id="all_privileges" type="checkbox" value=""></th><th>Action Name</th><th>Subject Name</th><th align="left">Subject ID</th>
                        </tr>
                </thead>
                <?php foreach($all_privileges as $privilege) { ?>
                <tr>
                <td style="text-align: center;"><?php echo $privilege['privilege_id']; ?></td><td width="16" style="text-align: center;"><input type="checkbox" name="privilege_id[]" value="<?php echo $privilege['privilege_id']; ?>"></td><td><?php echo $privilege['action']->name; ?></td><td><?php echo $privilege['subject_type']->name; ?></td><td align="left"><?php echo $privilege['subject_id']; ?></td>
                </tr>
                <? } ?>
                <tfoot>
                <tr>
                <th colspan="7">Privilegies <-sta je ovo? :)</th>
                </tr>
                </tfoot>
                </table><br />
		<input class="button-1" type="submit" id="submit_story_button" value="Add Group"><input type="button" class="button-1" id="btnCancel"  value="Cancel" />
	</form>
    
</div>
   
<div class="clear"></div>     
</div>    
</body>
<script type="text/javascript" src="<?php echo base_url(); ?>system/application/style/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
//select all checkboxes
$(document).ready(function()
{
	$("#all_privileges").click(function()				
	{
		var checked_status = this.checked;
		$("input[name=privilege_id[]]").each(function()
		{
			this.checked = checked_status;
		});
	});
	$('#btnCancel').click(function (){
        $(window.location).attr("href", "<?php echo base_url(); ?>group");
    });					
});
</script>
</html>
