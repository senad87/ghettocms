<?php $messages = $this->messages->get();?>
<?php if(is_array($messages)){ ?>
	<?php foreach($messages as $key=>$message){ ?>
		<?php if(!empty($message)){ ?>
			<div id="message" class="<?php echo $key; ?>"><?php echo $message;?><span id="close_mess"></span></div>
		<?php } ?>
	<?php } ?>
<?php } ?>
<div style="display:none" id="message"></div>
<table class="data" border="0">
<tr>
<?php foreach($table as $column){ ?>
	<?php $that->set_th($column, $module_name, $offset, $orderColumn, $order, $link); ?>
<?php } ?>
</tr>
<?php $i=1; ?>
<?php foreach($items as $product){ ?>
<tr <?php echo ($i%2==0?'class="rowColor"':'class="rowColorLight"'); ?>>
<?php foreach($table as $column){ ?>
	<?php $that->set_td($column, $product, $module_name, $link); ?>
<?php } ?>
</tr>
<?php $i++; ?>
<?php } ?>
<?php if(isset($pagination) && $pagination != ""){ ?>
<tr class="rowColor" ><td colspan="<?php echo $column_count; ?>" class="last-cell"><?php echo $pagination; ?></td></tr>
<?php } ?>
</table>
