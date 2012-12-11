<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>НСЗ - Послови</title>
<link href="<?php echo base_url();?>application/views/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo"><a href="http://www.nsz.gov.rs/"><img src="<?php echo base_url();?>application/modules/menu/views/images/logo.png" title="Национална служба за запошљавање" alt="Национална служба за запошљавање" width="159" height="130" /></a></div>
        <div class="logoposlovi"><a href="/"><img src="<?php echo base_url();?>application/modules/menu/views/images/logo-poslovi.png" width="340" height="79" /></a></div>
        <div class="uovombroju">
            <div class="brojposlova"><a href="http://www.nsz.gov.rs/page/info/sr/expiringItem.html"><?php echo modules::run('position', 1, $menu[0]->id); ?></a></div>
            <!--380 -->
        </div>
        <div class="datumi-soc">
            <!-- <div class="hd-broj">Број 414</div> -->
            <div class="hd-broj"><?php echo modules::run('position', 2, $menu[0]->id); ?></div>
            <!-- 25.05.2011.</div> -->
            <div class="hd-datum"><?php echo modules::run('position', 3, $menu[0]->id); ?></div>
            <div class="hd-soc"> 
       
            
<div class="ico-fb"><iframe src="http://www.facebook.com/plugins/like.php?href=poslovi.nsz.gov.rs&amp;send=false&amp;layout=box_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=segoe+ui&amp;height=90" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:55px; height:63px;" allowTransparency="true"></iframe></div>
<a href="<?php echo base_url();?>newsletter/sub/497/" class="ico-news" title="Newsletter"></a>               
            </div>  
            
            
            
        </div>
    </div><!--end header -->
	<div class="body-container">
        <div class="menu-container">
            <?php echo modules::run('position', 4, $menu[0]->id); ?>
        </div>
        <div class="levipanel">
        	<div class="content">
        	<?php //var_dump($sub); ?>
        		<?php echo modules::run('position', 5, $menu[0]->id, $sub, $offset); ?>
              
            </div><!-- end content -->
        </div><!-- end levipanel -->
		<div class="desnipanel">
			<?php echo modules::run('position', 6, $menu[0]->id); ?>
			 
			    <div class="box-desno" style="height: 349px;"><!-- start box-desno -->
                	<?php echo modules::run('position', 7, $menu[0]->id); ?>
                	<div class="clear" style="border-top: 1px solid #f2f2f2; height: 7px;"></div>
                    <?php echo modules::run('position', 8, $menu[0]->id); ?>
                    <div class="clear" style="border-top: 1px solid #f2f2f2; height: 7px;"></div>
                    <?php echo modules::run('position', 9, $menu[0]->id); ?>
                    
                </div><!-- end box-desno -->
				<?php echo modules::run('position', 10, $menu[0]->id); ?>
        <div class="clear"></div>
		</div><!-- end desnipanel -->
        <div class="clear"></div>
        <div class="izdvajamo"><!-- start izdvajamo -->
			<div class="box-name">ИЗДВАЈАМО</div>
            <div class="box-mini">
                <?php echo modules::run('position', 11, $menu[0]->id); ?>
            </div>

            <div class="box-mini">
                <?php echo modules::run('position', 12, $menu[0]->id); ?>
            </div>

            <div class="box-mini" style="margin-right: 0;">
                <?php echo modules::run('position', 13, $menu[0]->id); ?>
            </div>
            <div class="clear"></div>
            <div class="box-mini">
                <?php echo modules::run('position', 14, $menu[0]->id); ?>
            </div>

            <div class="box-mini">
                <?php echo modules::run('position', 15, $menu[0]->id); ?>
            </div>
        
            <div class="box-mini" style="margin-right: 0;">
                <?php echo modules::run('position', 16, $menu[0]->id); ?>
            </div>
            <div class="clear"></div>

		</div><!-- end izdvajamo -->
        <div class="footer"></div>
        </div>
        <div class="footer-copyright">&copy;НСЗ 2011 Сва права задржана.</div>        
        
	<div class="clear"></div>
	</div><!--body container -->
</div>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-1431699-20']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>


</body>
</html>
<?php //error_log("You messed up!", 3, "/var/tmp/my-errors.log"); ?>
<?php die;?>