<div class="headcont">
<h1 class="heading">Topics Management</h1>
<?php echo modules::run('toolbar', 'topic_title', 'topic', array('new', 'delete')); ?>
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
<div class="submenu">
</div>
<?php echo modules::run('table', $topics, array('input|false|false|checkbox', 'text_link|name|Title', 'text|description|Description', 'text|id|ID'), 'topic'); ?>
</div>
<div class="clear"></div> 
</div>
</body>
</html>
