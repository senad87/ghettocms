<div class="headcont">
<h1 class="heading">Menu Manager</h1>
	<?php echo modules::run('toolbar', 'menu_title', 'menu', array('new', 'delete')); ?>
<div class="clear"></div>
</div>
<div class="container">
<div class="right-panel">
	<h5>Properties</h5>
	<div class="box-right-panel">
		<div class="box-right-panel-inbox">
		111
		</div>
	</div>
</div><!-- end of right panel -->

<div class="left-panel">
	<div class="submenu">
	</div>
	<?php echo modules::run('table', $entries, array('input|false|false|checkbox', 'text_link|name|Menu', 'custom_link|items|Items|false|items_list', 'text|id|ID'), 'menu'); ?>    
</div><!-- end of left panel -->
<div class="clear"></div>    
</div>  
</body>
</html>
