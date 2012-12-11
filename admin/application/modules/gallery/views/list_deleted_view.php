<div class="headcont">
<h1 class="heading">Stories Trash</h1>
<?php echo modules::run('toolbar', 'gallery_title', 'gallery', array('restore')); ?>

<div class="clear"></div>
</div>
<div class="container">
<div class="right-panel">
</div>
</div>

<div class="left-panel">

<?php echo modules::run('table', $entries, array('input|false|false|checkbox', 'text_link|title|Title', 'text|creation_date|Created', 'text|modified_date|Modified', 'text|category|Category', 'text|entry_state_id|Status', 'text|type_id|ID'), 'game'); ?>
</div>  
<div class="clear"></div>       
</div>
</body>
</html>
