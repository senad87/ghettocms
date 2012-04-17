<div class="headcont">
<h1 class="heading">Edit Group</h1>

 
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



<?php echo form_open('group/update_data/'); ?>
<label for="lead"><strong>Group name:</strong></label><br />
		<input class="lform2" type="text" name="groupname" size="20" value="<?php echo $group[0]->name; ?>"><br />
		<input type="hidden" name="groupid" value="<?php echo $group[0]->id; ?>"><br />
<label for="privileges"><strong>Selected group privileges:</strong></label><br />        
<table class="data" border="0" cellpadding="0" cellspacing="0">
<thead>
        <tr>
        <th width="16" style="text-align: center;">ID</th><th width="16" style="text-align: center;">#</th><th>Action Name</th><th>Subject Name</th><th align="left">Subject ID</th>
        </tr>
</thead>
<?php foreach($all_privileges as $privilege) { ?>
<tr>
<td style="text-align: center;"><?php echo $privilege['privilege_id']; ?></td><td width="16" style="text-align: center;"><input type="checkbox" name="privilege_id[]" value="<?php echo $privilege['privilege_id']; ?>" <?php if(in_array($privilege['privilege_id'], $user_group_privileges)){?> checked="checked" <?php } ?>></td><td><?php echo $privilege['action']->name; ?></td><td><?php echo $privilege['subject_type']->name; ?></td><td align="left"><?php echo $privilege['subject_id']; ?></td>
</tr>
<? } ?>
<tfoot>
<tr>
<th colspan="7"></th>
</tr>
</tfoot>
</table><br />

<input class="button-1" type="submit" value="Save changes" style="float: left;"> 
</form>
<input class="button-1" type="submit" id="btnCancel" value="Cancel">
</div>
   
<div class="clear"></div>  
</div>
</body>
<script type="text/javascript" src="<?php echo base_url(); ?>system/application/style/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
$('#btnCancel').click(function ()
    {
        $(window.location).attr("href", "<?php echo base_url(); ?>group");

    });
</script>
</html>
