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
   <div class="header">
   	<div class="menuContainer">
         <div class="logo"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>application/views/images/logo.png" width="306" height="110" /></a></div>
         <div class="menuBox">
             <?php echo modules::run('position', 1, $menu[0]->id); ?>
            <!-- <ul class="menu">
               <li>
               <a href="3">Šta je digitalna tv?</a>
               </li>
               <li>
               <a href="#">Digitalna tv u srbiji</a>
               </li>
               <li>
               <a href="#">Česta pitanja</a>
               </li>
               <li>
               <a href="#">Kontakt</a>
               </li>
            </ul>   -->      
         
         <?php echo modules::run('position', 2, $menu[0]->id); ?>
         <!-- <div class="forma-pretraga">
         <form method="post" action="">
                  <input type="text" value="" class="pretraga" name="keyword">
                  <input type="hidden" value="441" name="id">
                  <input type="submit" class="button" value="">
         </form>        
         </div> -->
      </div>
      
      
   </div>
   <div class="clear"></div>
<div class="container">
     <?php echo modules::run('position', 3, $menu[0]->id); ?> 
<!-- <div class="headboxContainer">
			<div class="headbox">



<div id="headboxSlider" class="royalSlider heroSlider rsMinW">
  <div class="rsContent">
    <img class="rsImg" src="<?php echo base_url();?>application/views/images/slider/4.jpg" alt="" />
    <div class="infoBlock infoBlockLeftBlack rsABlock rsNoDrag" data-fade-effect="" data-move-offset="10" data-move-effect="bottom" data-speed="200">
       <h4>Da li se vidimo?</h4>
      <p>Potražite svoj grad na listi, i pogledajte koji predajnik emituje koje kanale za vaš grad.</p>
      
 	</div>
 	<div data-delay="350" class="bigButton rsNoDrag rsAbsoluteEl" data-fade-effect="" data-move-offset="10" data-move-effect="bottom" data-speed="200"><a href="#">Više informacija</a></div>
   </div>
   
   
   
  <div class="rsContent">
    <img class="rsImg" src="<?php echo base_url();?>application/views/images/slider/2.jpg" alt="" />
    <div class="infoBlock rsABlock infoBlockLeftBlack rsNoDrag" data-fade-effect="" data-move-offset="10" data-move-effect="bottom" data-speed="200">
      <h4>Touch events are disabled over this text to allow selection</h4>
      <p>You can add this behaviour to any element inside of slide just by adding 'rsNoDrag' CSS class to it.</p>
    </div>
  </div>
 <div class="rsContent">
    <img class="rsImg" src="<?php echo base_url();?>application/views/images/slider/3.jpg" alt="" />
    <div class="infoBlock rsABlock infoBlockLeftBlack rsNoDrag" data-fade-effect="" data-move-offset="10" data-move-effect="bottom" data-speed="200">
      <h4>Touch events are disabled over this text to allow selection</h4>
      <p>You can add this behaviour to any element inside of slide just by adding 'rsNoDrag' CSS class to it.</p>
    </div>
  </div>
</div>



<img src="<?php echo base_url();?>application/views/images/slider-linija.png" width="960" height="127" style="position: absolute; bottom: 0; z-index: 110;" />


</div>
         <div class="headboxBottom">Potpuno gašenje analognog servisa izvršiće se do 17. juna 2015. godine.<br />
			<strong>Da li ste spremni za prelazak na digitalnu televiziju?</strong>
         
         </div>
      </div> -->
      
   <!-- Box -->
      <div class="roundedBox">
        <div class="threeImages">
            <?php echo modules::run('position', 4, $menu[0]->id); ?>
            <?php echo modules::run('position', 5, $menu[0]->id); ?>
            <?php echo modules::run('position', 6, $menu[0]->id); ?>
            <!-- <a href="#"><img class="rounded" src="<?php echo base_url();?>application/views/images/revolucija.jpg" width="300" height="200" /></a>
            <a href="#"><img class="rounded" src="<?php echo base_url();?>application/views/images/signal.jpg" width="300" height="200" /></a>
            <a href="#"><img class="rounded noMargin" src="<?php echo base_url();?>application/views/images/oprema.jpg" width="300" height="200" /></a> -->
      	</div>
         <?php echo modules::run('position', 7, $menu[0]->id); ?>
         <!-- <div class="newsList">
         	<h2>Najnovije informacije<a href="#" class="smallButton">Pogledaj sve</a></h2>
            	<ul>
            		<li><a href="#"><img src="<?php echo base_url();?>application/views/images/temp2.jpg" width="60" height="60" /></a> <a class="link" href="#">Ostvareno više od 15% procesa digitalizacije</a> <span>31.12.2012.</span></li>
            		<li><a href="#"><img src="<?php echo base_url();?>application/views/images/temp3.jpg" width="60" height="60" /></a><a class="link" href="#">ITU Regionalni seminar o digitalnoj 
radiodifuziji i digitalnoj dividendi </a> <span>11.12.2012.</span></li>
                  <li><a href="#"><img src="<?php echo base_url();?>application/views/images/temp4.jpg" width="60" height="60" /></a><a class="link" href="#">Novo merno vozilo, donacija ITU</a> <span>10.11.2012.</span></li>
            
            </ul>
            
            
            
            
         </div> -->
         <?php echo modules::run('position', 8, $menu[0]->id); ?>
         <!-- <div class="questionsList">
         	<h2>Najčešća pitanja<a href="#" class="smallButton">Pogledaj sve</a></h2>
            <ul>
            	<li><img src="<?php echo base_url();?>application/views/images/qm.png" width="24" height="24" /><div class="qList"><a class="link" href="#">Šta je to SET-TOP-BOX?</a></div></li>
               <li><img src="<?php echo base_url();?>application/views/images/qm.png" width="24" height="24" /><div class="qList"><a class="link" href="#">Imam kablovsku, da li treba da brinem?</a></div></li>
               <li><img src="<?php echo base_url();?>application/views/images/qm.png" width="24" height="24" /><div class="qList"><a class="link" href="#">Koji televizori mogu da prikažu digitalni signal bez STB-a?</a></div></li>
               <li><img src="<?php echo base_url();?>application/views/images/qm.png" width="24" height="24" /><div class="qList"><a class="link" href="#">Da li mogu sa STB-om da gledam program kad ja želim, a ne onda kad je po rasporedu?</a></div></li>
               
            </ul>
            
            
            

         </div> -->       
      <div class="clear"></div>
      <?php echo modules::run('position', 9, $menu[0]->id); ?>
      <!-- <div class="stationList">
      
      	<h5>TV stanice čiji programi mogu da se prate u Inicijalnoj mreži</h5>
         <img src="<?php echo base_url();?>application/views/images/stanice.jpg" width="880" height="196" />
         
         </div> -->
      
         <div class="footer">
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