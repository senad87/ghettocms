<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<head>
<title>Template</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo base_url(); ?>application/views/css/styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/config.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/jquery1.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/jqueryslidemenu.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>application/modules/gallery/scripts/gallery.include.js"></script>

</head>
<body>
<!-- start container -->
<div id="container">
<!-- start header -->
<div id="header">
<!-- start logo -->
<div id="logo">
</div>
<!-- end logo -->

<!-- start menu -->

<div id="myslidemenu" class="jqueryslidemenu">
<ul>
<li><a href="<?php echo base_url(); ?>">Control Panel</a>

<li><a href="<?php echo base_url(); ?>">Menus</a>
<ul>
<li><a href="<?php echo base_url(); ?>menus/">Menu Menager</a></li>
<li><a href="<?php echo base_url(); ?>menus/createNew/">Create New +</a></li>
</ul>
</li>

<!--<li><a href="<?php echo base_url(); ?>articles/">Articles</a>
<ul>
<li><a href="<?php echo base_url(); ?>articles/createNew/">New Article</a></li>
<li><a href="<?php echo base_url(); ?>articles/">Article List</a></li>
</ul>
</li>-->

<li><a href="<?php echo base_url(); ?>issues/">Content</a>
<ul>
<li><a href="<?php echo base_url(); ?>articles/">Article Manager</a></li>
<li><a href="<?php echo base_url(); ?>sections/">Section Manager</a></li>
<li><a href="<?php echo base_url(); ?>categories/">Catgegory Manager</a></li>
</ul>
</li>

<li><a href="<?php echo base_url(); ?>works/">Science Studies</a>
<ul>
<li><a href="<?php echo base_url(); ?>works/createNew/">New Studie</a></li>
<li><a href="<?php echo base_url(); ?>works/">Studies List</a></li>
</ul>
</li>

<li><a href="<?php echo base_url(); ?>issues/">Issues</a>
<ul>
<li><a href="<?php echo base_url(); ?>issues/createNew/">New Issue</a></li>
<li><a href="<?php echo base_url(); ?>issues/">Issues List</a></li>
</ul>
</li>


</li>
</ul>


<br style="clear: left" />
</div>
<!-- end menu -->

</div>
<!-- end header -->
