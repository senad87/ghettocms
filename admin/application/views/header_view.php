<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ModularCMS</title>
<link href="<?php echo base_url();?>application/views/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>application/views/css/smoothness/jquery-ui.custom.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>application/views/css/colorbox.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url();?>application/style/js/jquery.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url();?>application/style/js/jquery-ui.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/style/js/ajaxupload.3.5.js" ></script>
<script type="text/javascript" src="<?php echo base_url();?>application/views/scripts/custom.js" ></script>
<script type="text/javascript" src="<?php echo base_url();?>application/style/js/custom.js" ></script>
<script type="text/javascript" src="<?php echo base_url();?>application/style/js/jquery.colorbox-min.js" ></script>
	<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
	</script>
</head>
<body>
<!--  <div class="header">
</div>-->
<div class="menubar">
<div class="userbox"> 
<?php if ($this->session->userdata('username')){ ?>
	<?php echo $this->session->userdata('username'); ?> | <a href="<?php echo base_url(); ?>access/logout/">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp;
	<small>Current language: <?php echo $this->session->userdata('language'); ?></small>
<?php } ?>
</div>
    <ul class="menu">
        <li><a <?php if (current_url() == base_url()."index.php"){ ?>id="current"<?php } ?> href="<?php echo base_url(); ?>">Home</a></li>
        <li><a class="hide" <?php if (current_url() == base_url()."language"){ ?>id="current"<?php } ?>  href="javascript:;">Languages</a>
        <?php $languages = getLanguages(); ?>
        <ul>
        <?php foreach($languages as $language){ ?>
            <li><a href="<?php echo base_url(); ?>language/change/<?php echo $language->id; ?>"><?php echo $language->language; ?></a></li>
        <?php } ?>
            <!-- <li><a href="<?php echo base_url(); ?>language/change/2">Serbian Latin</a></li>
            <li><a href="<?php echo base_url(); ?>language/change/3">English</a> -->   
        </ul>
        
        </li>
	<?php if(in_array(1, $this->session->userdata('user_privileges'))){ ?>
	<li><a class="hide" <?php if (current_url() == base_url()."story"){ ?>id="current"<?php } ?> href="javascript:;">Stories</a>
                <ul>
                	<?php if(in_array(6, $this->session->userdata('user_privileges'))){ ?>
                	<li>
                		<a href="<?php echo base_url(); ?>story/createNew/">New story</a>
                	</li>
                	<?php } ?>
                	<li>
                		<a href="<?php echo base_url(); ?>story">Manage</a>
                	</li>
        	       	<li>
        	       		<a href="<?php echo base_url(); ?>story/trash/">Trash</a>
                   	</li>
               </ul>
        </li>
        <?php } ?>
        <?php if(in_array(1, $this->session->userdata('user_privileges'))){ ?>
	<li><a class="hide" <?php if (current_url() == base_url()."game"){ ?>id="current"<?php } ?> href="javascript:;">Games</a>
                <ul>
                	<?php if(in_array(6, $this->session->userdata('user_privileges'))){ ?>
                	<li>
                		<a href="<?php echo base_url(); ?>game/createNew/">New game</a>
                	</li>
                	<?php } ?>
                	<li>
                		<a href="<?php echo base_url(); ?>game">Manage</a>
                	</li>
        	       	<li>
        	       		<a href="<?php echo base_url(); ?>game/trash/">Trash</a>
                   	</li>
               </ul>
        </li>
        <?php } ?>
      	<li><a href="<?php echo base_url();?>comments/" >Comments</a></li>
        <?php if(in_array(5, $this->session->userdata('user_privileges'))){ ?>
        <li><a <?php if (current_url() == base_url()."category"){ ?>id="current"<?php } ?> href="<?php echo base_url(); ?>category">Categories</a></li>
        <?php } ?>
        <?php if(in_array(10, $this->session->userdata('user_privileges'))){ ?>
        <li><a <?php if (current_url() == base_url()."admin_user"){ ?>id="current"<?php } ?> href="<?php echo base_url(); ?>admin_user">Users</a></li>
        <?php } ?>
        <?php if(in_array(16, $this->session->userdata('user_privileges'))){ ?>
        <li><a class="hide" <?php if (current_url() == base_url()."group"){ ?>id="current"<?php } ?>  href="javascript:;">Groups</a>
        <ul>
        	<?php if(in_array(19, $this->session->userdata('user_privileges'))){ ?>
            <li><a href="<?php echo base_url(); ?>group/new_group/">Create New</a></li>
            <?php } ?>
            <li><a href="<?php echo base_url(); ?>group">Manage</a></li>               
        </ul>
        </li>
         <?php } ?>
         <?php if(in_array(27, $this->session->userdata('user_privileges'))){ ?>
        <li><a <?php if (current_url() == base_url()."menu"){ ?>id="current"<?php } ?> href="<?=base_url(); ?>menu">Menus</a></li>
        <?php } ?>
        <?php if(in_array(28, $this->session->userdata('user_privileges'))){ ?>
        <li><a class="hide" <?php if (current_url() == base_url()."template"){ ?>id="current"<?php } ?> href="javascript:;">Templates</a>
        <ul>
        <?php if(in_array(29, $this->session->userdata('user_privileges'))){ ?>
            <li><a href="<?php echo base_url(); ?>template/new_template/">New template</a></li>
         <?php } ?>
            <li><a href="<?php echo base_url(); ?>template">Manage</a></li>
        </ul>
        </li>
        <?php } ?>
        <?php if(in_array(28, $this->session->userdata('user_privileges'))){ ?>
        <li><a class="hide" <?php if (current_url() == base_url()."topic"){ ?>id="current"<?php } ?> href="javascript:;">Topics</a>
        <ul>
        <?php if(in_array(29, $this->session->userdata('user_privileges'))){ ?>
            <li><a href="<?php echo base_url(); ?>topic/createNew/">New topic</a></li>
         <?php } ?>
            <li><a href="<?php echo base_url(); ?>topic">Manage</a></li>
        </ul>
        </li>
        <?php } ?>
        <?php if(in_array(28, $this->session->userdata('user_privileges'))){ ?>
        <li><a class="hide" <?php if (current_url() == base_url()."tag"){ ?>id="current"<?php } ?> href="javascript:;">Tags</a>
        <ul>
        <?php if(in_array(29, $this->session->userdata('user_privileges'))){ ?>
            <li><a href="<?php echo base_url(); ?>tag/createNew/">New tag</a></li>
         <?php } ?>
            <li><a href="<?php echo base_url(); ?>tag">Manage</a></li>
        </ul>
        </li>
        <?php } ?>
        <li><a href="<?php echo base_url();?>newsletter/" >Newsletter</a></li>
        <?php if(in_array(1, $this->session->userdata('user_privileges'))){ ?>
	<li><a class="hide" <?php if (current_url() == base_url()."gallery"){ ?>id="current"<?php } ?> href="javascript:;">Galleries</a>
                <ul>
                	<?php if(in_array(6, $this->session->userdata('user_privileges'))){ ?>
                	<li>
                		<a href="<?php echo base_url(); ?>gallery/createNew/">New gallery</a>
                	</li>
                	<?php } ?>
                	<li>
                		<a href="<?php echo base_url(); ?>gallery">Manage</a>
                	</li>
        	       	<li>
        	       		<a href="<?php echo base_url(); ?>gallery/trash/">Trash</a>
                   	</li>
               </ul>
        </li>
        <?php } ?>
    </ul> 
</div>
