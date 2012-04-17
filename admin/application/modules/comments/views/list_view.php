<div class="headcont">
<h1 class="heading">Comments Management</h1>
<?php echo modules::run('toolbar', 'comments_title', 'comments', array('publish', 'unpublish', 'delete')); ?>
<div class="clear"></div>
</div>

<div class="container">
<div class="right-panel">
    <h5>Search Comments</h5> 
    <div class="box-right-panel">
        <div class="box-right-panel-inbox">
        Enter search term:
        <input class="search" name="" type="text" />
        <input class="button-1"  type="submit" value="Search">
        </div>
    </div>
</div> 
<div class="left-panel">
<div class="submenu">
</div>  
<?php echo modules::run('table', $comments, array('input|false|false|checkbox', 'text_link|entry_title|Title', 'text|createdDate|Created', 'text|name|Name', 'text|email|Email', 'text_link|body|Comment','text|ip_address|IP','text|state|Status', 'text_order|id|ID'), 'comments'); ?>
	
</div>
   
<div class="clear"></div>      
</div>
</body>
</html>



