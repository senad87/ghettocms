<div class="headcont">
<h1 class="heading">Banners Management</h1>
<?php echo modules::run('toolbar', 'banners_title', 'banners', array('new', 'publish', 'unpublish', 'delete')); ?>	
<div class="clear"></div>
</div>
<div class="container">
<div class="right-panel">
</div> 

<div class="left-panel">
<?php echo modules::run('table', $items, array('input|false|false|checkbox', 'text_link|name|Title', 'text|creation_date|Created', 'text|url|Destionation Url', 'text|state|Status', 'text|id|ID'), 'banners'); ?>
</div>
   
<div class="clear"></div>      
</div>
</body>
</html>
