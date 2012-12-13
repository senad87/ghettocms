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
    
    
    <script src="<?php echo base_url();?>application/views/js/jquery-1.7.2.min.js"></script>      
    <script src="<?php echo base_url();?>application/views/js/slider.min.js"></script>    
    <link href="<?php echo base_url();?>application/views/css/slider.css" rel="stylesheet" />
    
    

</head>
<body>
   <div class="header">
   	<div class="menuContainer">
         <div class="logo"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>application/views/images/logo.png" width="306" height="110" /></a></div>
         <div class="menuBox">
            <?php echo modules::run('position', 1, $menu[0]->id); ?>
            <?php echo modules::run('position', 2, $menu[0]->id); ?>  
         </div>
      </div>
      
      
   </div>
   <div class="clear"></div>
<div class="container">
     <?php echo modules::run('position', 3, $menu[0]->id); ?> 
<!-- <div class="contentHeader">
   <img src="images/header-page.jpg" width="960" height="125" />
</div> -->
      
<!-- Box -->
      <div class="roundedBox2">
          <?php echo modules::run('position', 4, $menu[0]->id); ?>
      	<!-- <div class="contentTitleZone">
         	<h1>Digitalizacija u Republici Srbiji</h1>
            <p>Sve informacije o procesu digitalizacije u Republici Srbiji</p>
         </div> -->
        <?php echo modules::run('position', 5, $menu[0]->id); ?>
         <!-- <div class="listLeft">
         	<ul>
            	<li><a href="#">Digitalizacija u Republici Srbiji</a></li>
               <li><a href="#">Ko sprovodi digitalizaciju u Srbiji?</a></li>
               <li><a href="#">Kada se prelazi na digitalno emitovanje na području Srbije?</a></li>
               <li><a href="#">INICIJALNA MREŽA za digitalno emitovanje</a></li>
               <li><a href="#">Šta se menja na strani prijema?</a></li>
					<li class="noBorder"><a href="#">Gledaoci koji koriste kablovsku televiziju</a></li>
				</ul>
         </div>-->
         <?php echo modules::run('position', 6, $menu[0]->id); ?>
         <!-- <div class="contentRight">
        	   <p><img src="images/temp5.jpg" width="599" height="337" /></p>
        	   <p>Vlada Republike Srbije je usvojila Strategiju za prelazak sa analognog na digitalno emitovanje radio i televizijskog programa u Republici Srbiji, gde je za prenos digitalnog TV signala usvojen DVB-T2 sistem kao standard za digitalno zemaljsko emitovanje televizijskih signala i MPEG-4 ver.10 (H.264/AVC) kao kompresioni standard.</p>
            <p>Ministarstvo za telekomunikacije i informaciono društvo je 18.02.2011. godine donelo pravilnik o prelasku sa analognog na digitalno emitovanje televizijskog programa i pristupu multipleksu u terestričkoj digitalnoj radiodifuziji.</p>
            
          <div class="share">Ovde dodati social</div>  
            
         </div> -->
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