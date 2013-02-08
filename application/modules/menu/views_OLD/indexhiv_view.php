<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HIV Podrska</title>
<link href="<?php echo base_url();?>application/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>application/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/js/slider.js"></script>
</head>

<body>
<div class="wrapper">
	<div class="container">
	    <div class="header">
	        	
	        	<div class="logo"><a href="/"><img src="<?php echo base_url();?>application/modules/menu/views/images/logo.jpg" width="207" height="88" alt="ХИВ Подршка" title="ХИВ Подршка" /></a>
	        	</div>
	        	
	        	<div class="socnet">            
					
					<div class="fb-btn">
	                	<iframe src="http://www.facebook.com/plugins/like.php?href&amp;send=false&amp;layout=box_count&amp;width=62&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=63" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:62px; height:63px;" allowTransparency="true"></iframe>
	                </div>
	                
	                <div class="fb"> <a href="#"><img src="<?php echo base_url();?>application/modules/menu/views/images/soc-fb.png" width="40" height="61" /></a></div>
	                <div class="tw"> <a href="#"><img src="<?php echo base_url();?>application/modules/menu/views/images/soc-tw.png" width="40" height="61" /></a></div>
	                <div class="yt"> <a href="#"><img src="<?php echo base_url();?>application/modules/menu/views/images/soc-yt.png" width="62" height="61" /></a></div>                
	                
		      	</div>
	        
	        
	    </div><!-- end of header -->
        
        <div class="menu-container">
        	<?php echo modules::run('position', 1, $menu[0]->id); ?>
        </div>
        
        <div class="content">
        <div class="panel-left">
	        <div class="content-box">
	        	<?php echo modules::run('position', 2, $menu[0]->id); ?>
	        </div>
				<?php echo modules::run('position', 7, $menu[0]->id); ?>
                <?php echo modules::run('position', 8, $menu[0]->id); ?>
        </div>
        <div class="panel-right">
	        <div class="content-box-desno">
            <?php echo modules::run('position', 3, $menu[0]->id); ?>
             
             <div class="banners">
             <?php echo modules::run('position', 4, $menu[0]->id); ?>
              <!-- <div class="boxname-desno-inner">Кампање</div>
               <div class="banner"><a href="#"><img src="<?php echo base_url();?>application/modules/menu/views/images/baner1.jpg" width="180" height="265" /></a></div>
               <div class="banner"><a href="#"><img src="<?php echo base_url();?>application/modules/menu/views/images/baner2.jpg" width="180" height="265" /></a></div> -->
             </div>
             <?php echo modules::run('position', 5, $menu[0]->id); ?>
             <!-- <div class="btnlnk"><a href="#"><img src="<?php echo base_url();?>application/modules/menu/views/images/link1.jpg" width="220" height="110" /></a></div>
             <div class="btnlnk"><a href="#"><img src="<?php echo base_url();?>application/modules/menu/views/images/link2.jpg" width="220" height="110" /></a></div>
             <div class="btnlnk"><a href="#"><img src="<?php echo base_url();?>application/modules/menu/views/images/link3.jpg" width="220" height="110" /></a></div>             
             -->
          </div>
        </div>
        <div class="clear"></div>
        
        <div class="footerG"><a href="http://www.zdravlje.gov.rs" target="_blank"><img src="<?php echo base_url();?>application/modules/menu/views/images/logo-mzs.png" width="134" height="78" /></a><a href="http://www.theglobalfund.org/en/" target="_blank"><img src="<?php echo base_url();?>application/modules/menu/views/images/logo-tgf.png" width="249" height="78" /></a><a href="http://www.batut.org.rs/" target="_blank"><img src="<?php echo base_url();?>application/modules/menu/views/images/logo-batut.png" width="233" height="78" /></a><a href="http://www.un.org/en/" target="_blank"><img src="<?php echo base_url();?>application/modules/menu/views/images/logo-un.png" width="75" height="78" /></a><a href="http://www.unicef.org/" target="_blank"><img src="<?php echo base_url();?>application/modules/menu/views/images/logo-unicef.png" width="79" height="78" /></a></div>
        <div class="footer">
        	© 2011 ХИВ Подршка. Сва права задржана.
        </div>

        </div>

        



	</div>

</div>
</body>
</html>