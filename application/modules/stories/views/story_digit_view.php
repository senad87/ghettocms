<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Digitalizacija</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="<?php echo base_url();?>application/views/css/style.css" rel="stylesheet" type="text/css" />
    <!--[if IE 8]>
    <link rel="stylesheet" type="text/css" media="all" href="css/ie8style.css" />
    <![endif]-->
    <!--[if gte IE 9]>
    <link rel="stylesheet" type="text/css" media="all" href="css/ie9style.css" />
    <![endif]-->
    
    
    <link href="<?php echo base_url();?>application/views/css/slider.css" rel="stylesheet" />
    <script src="<?php echo base_url();?>application/views/js/jquery-1.7.2.min.js"></script>      
    <script src="<?php echo base_url();?>application/views/js/slider.min.js"></script>    
    <link href="<?php echo base_url();?>application/views/css/slider.css" rel="stylesheet" />
    
    

</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=290108991081687";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
   <div class="header">
   	<div class="menuContainer">
         <div class="logo"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>application/views/images/logo.png" width="306" height="110" /></a></div>
         <div class="menuBox">
            <?php echo modules::run('position', 1, $from_menu_id, $sub = false, $offset = 0, 1); ?>
         <?php echo modules::run('position', 2, $from_menu_id, $sub = false, $offset = 0, 1 ); ?>
      </div>
      
      
   </div>
   <div class="clear"></div>
<div class="container">
<?php echo modules::run('position', 3, $from_menu_id, $sub = false, $offset = 0, 1 ); ?>      
<!-- <div class="contentHeader">
   <img src="images/header-page.jpg" width="960" height="125" />
</div> -->
      
<!-- Box -->
      <div class="roundedBox3">
      	<div class="contentTitleZone">
         	<h1><?php echo $entry[0]->title; ?></h1>
            <p><?php echo srb_date($entry[0]->creation_date); ?></p>
         </div>
         <div class="listRight">
             <?php echo modules::run('position', 4, $from_menu_id, $sub = false, $offset = 0, 1 ); ?>
         	<!-- <h2>Ostale vesti:</h2>
         
         	<ul>
            	<li><a href="#">Digitalizacija u Republici Srbiji</a></li>
               <li><a href="#">Ko sprovodi digitalizaciju u Srbiji?</a></li>
               <li><a href="#">Kada se prelazi na digitalno emitovanje na području Srbije?</a></li>
               <li><a href="#">INICIJALNA MREŽA za digitalno emitovanje</a></li>
               <li><a href="#">Šta se menja na strani prijema?</a></li>
					<li class="noBorder"><a href="#">Pogledaj sve vesti »</a></li>
				</ul> -->  
         </div>
         <div class="contentLeft">
             <?php if( !empty($thumb_image_path) ): ?>
        	   <p><img src="<?php echo base_url(); ?><?php echo $thumb_image_path; ?>" width="599" height="337" /></p>
             <?php endif; ?>      
                   <p><?php echo $story[0]->lead; ?></p>
                  <p><?php echo $story[0]->body; ?></p>



<div class="socshare share">
                       

<div class="face">
	<div class="fb-like" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="arial">
   </div>
</div> 

<div class="linkedin">
<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
<script type="IN/Share" data-counter="right"></script>

</div>

<div class="gplus">
<!-- Place this tag where you want the share button to render. -->
<div class="g-plus" data-action="share" data-annotation="bubble"></div>

<!-- Place this tag after the last share tag. -->
<script type="text/javascript">
  window.___gcfg = {lang: 'sr'};

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>

</div>

<div class="twitt">
                      <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

</div>





</div>




            
            
<br />
<br />
<?php if($cat_comment_status == 1 && $entry_comment_status == 1):?>
    <?php echo modules::run('comments', array($from_menu_id, $item_id, $post)); ?>  
<?php endif; ?>


  
            
            
            
            
         </div>
      	<div class="clear"></div>      
  			
         
         
                  

      
      
         <div class="footer2">
         Copyright © 2012. Javno preduzeće "Emisiona tehnika i veze" Beograd
         <span class="pw">Produkcija <a href="http://www.amedia.co.rs" target="_blank">A-Media d.o.o.</a></span>
         </div>
      
      
      
      
      
   </div> 
         
      <!--Box end -->
      
      
</div>

 <script>
jQuery(document).ready(function($) {
  $('#headboxSlider').royalSlider({
    arrowsNav: true,
    loop: true,
    keyboardNavEnabled: true,
    controlsInside: false,
    imageScaleMode: 'fill',
    arrowsNavAutoHide: false,
    autoScaleSlider: true, 
    autoScaleSliderWidth: 960,     
    autoScaleSliderHeight: 350,
    controlNavigation: 'bullets',
    thumbsFitInViewport: false,
    navigateByClick: false,
    startSlideId: 0,
    transitionType:'fade',
    globalCaption: true,
	     	autoPlay: {
    		// autoplay options go gere
    		enabled: true,
			delay: 4000,
    		pauseOnHover: true
    	}
  });
  
    
});


</script>


</body>
</html>