<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ProGame.rs</title>
<link href="<?php echo base_url();?>application/views/css/global.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/config.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/views/js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/views/js/jquery.idTabs.min.js"></script>

<script src="<?php echo base_url(); ?>application/modules/gallery/scripts/galleria-1.2.7.js"></script>
<link href="<?php echo base_url(); ?>application/modules/gallery/themes/progamers/galleria.classic.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
    // Load the classic theme
    Galleria.loadTheme('<?php echo base_url(); ?>application/modules/gallery/themes/progamers/galleria.classic.js');
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>application/modules/gallery/scripts/gallery.include.js"></script>

<!--<script src="js/cufon-yui.js" type="text/javascript"></script>
		<script src="js/Euphemia_400.font.js" type="text/javascript"></script>
		<script type="text/javascript">
			Cufon.replace('.readmore');
		</script> -->

<meta name="description" content="<?php echo $story[0]->lead; ?>" />

<meta property="fb:app_id" content="602203836462577">
<meta property="og:type" content="article"/>
<meta property="og:title" content="<?php echo $entry[0]->title; ?>"/>
<meta property="og:image" content="<?php echo base_url(); ?><?php echo $thumb_image_path; ?>"/>
<meta property="og:url" content="<?php echo base_url();?><?php echo substr($_SERVER['REQUEST_URI'], 1); ?>"/>
<meta property="og:site_name" content="Progame.rs"/>


</head>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=602203836462577";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
 <!--<div class="menu-top">
   <div class="width1124">
    ss
    </div>
</div>-->
<div class="body-wrapper">
        <div class="content-bg">
	        <div class="content">
           	  <div class="header">
                <div class="logo"> <a href="index1.php"><img src="<?php echo base_url();?>application/views/images/logo.png" alt="ProGame.rs" title="ProGame.rs" width="260" height="110" /></a>
                </div>
                <div class="banner-top"> <a href="#"><img src="<?php echo base_url();?>application/views/images/temp728x90.jpg" alt="Banner" width="728" height="90" /></a></div>
                <div class="clear"></div>
              </div>
              <div class="menu-bg">
                	<?php echo modules::run('position', 1, $from_menu_id); ?>              
              </div>
              <div class="column-left">
                <div class="block">
                <div class="img-block2">
	                <img src="<?php echo base_url(); ?><?php echo $thumb_image_path; ?>" title="<?php echo $entry[0]->title; ?>" alt="<?php echo $entry[0]->title; ?>" width="660" height="410" />
                </div>
                
                
              <div class="news-block">  
              <div class="title"><h1><?php echo $entry[0]->title; ?></h1></div>
                        	<div class="news-block-info">
                Postavio: <a href="#"><?php echo $author; ?></a>
                <span class="separator">&nbsp;</span>
                	<?php echo srb_date($entry[0]->creation_date); ?>
                <span class="separator">&nbsp;</span>
                	<a href="<?php echo base_url(); ?><?php echo $menu_name->name; ?>/<?php echo $category->menu_id; ?>/"><?php echo $menu_name->name; ?></a>
                <span class="separator">&nbsp;</span>
                	<?php if($num_comments){?><a href="#"><?php echo $num_comments; ?>komentara</a><?php }else{ ?><a href="#">0 komentara</a><?php } ?>
                </div>
                <div class="news-block-content">
                  <p class="lead"><?php echo $story[0]->lead; ?></p>
                  <?php echo $story[0]->body; ?>
                  
                </div>
                
                  <?php echo modules::run('tags/list_tags', array("entry_id" => $entry[0]->id, "from_menu_id" => $from_menu_id)); ?>
                  <?php //echo validation_errors(); ?>
                  

					<!-- share start -->
<div class="utilbar">    
          <div class="social">
            <span class="btn-fb">
				<div class="fb-like" data-send="false" data-layout="button_count" data-show-faces="false" data-font="segoe ui"></div>
				
            </span>
                
            <span class="btn-tw">
               <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            
            </span>
            <span class="btn-gplus">
            
               <!-- Place this tag where you want the +1 button to render. -->
               <div class="g-plusone" data-size="medium"></div>
               
               <!-- Place this tag after the last +1 button tag. -->
               <script type="text/javascript">
                 window.___gcfg = {lang: 'en-GB'};
               
                 (function() {
                   var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                   po.src = 'https://apis.google.com/js/plusone.js';
                   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                 })();
               </script>
            
            </span>



		    <span class="btn-blank"></span>            
            
          </div>
           <!-- <div class="utils">
            	<span class="print"><a href="javascript:;"></a></span>
            	<span class="pdf"><a href="javascript:;"></a></span>
            </div>-->
		<div class="clear"></div>          
      </div>               
               <!-- share end -->




























                  
                  
                  <div class="subcontent">
                  
                  <?php if($cat_comment_status == 1 && $entry_comment_status == 1){?>
				       <?php echo modules::run('comments', array($from_menu_id, $item_id, $post)); ?>  
                    <?php } ?>
                  <div class="clear"></div>
                </div>
              </div>
              </div>

              </div>
              <div class="column-right">
              
              
              
                  <div class="box-classic">
                  <h3>Vesti</h3>
                  <div class="box-inside"> <a href="#"><img src="images/temp-v.jpg" alt="Izlazak LEGO Star Wars 3: The Clone Wars odložen za 22. mart" width="385" height="210" /></a>
				  <h4><a href="#">Izlazak LEGO Star Wars 3: The Clone Wars odložen za 22. mart</a></h4>
                  <p>Očigledno, LucasArts treba  malo više vremena nego što je predviđeno da se adekvatno pripremi LEGO Star Wars 3: The Clone Wars - Izlazak je pomeren sa 15. februara na 22. mart.</p>
                  
                  <ul class="type2">
                  	<li><a href="#">Uskoro Homefront trejler</a></li>
                  	<li><a href="#">OnLive in-game voice chat dostupan za preuzimanje - prvi utisci</a></li>
                  	<li><a href="#">Call of Duty: Black Ops najprodavanija igra u Americi ikada</a></li>
                  	<li><a href="#">Crysis 2 vs. Crysis 2: PC i Xbox vizuelna uporedba</a></li>
                  </ul>
                  
                  
                  <div class="box-classic-bottom">
                  	<div class="left"><a href="#">Još^</a><span class="separator-small">&nbsp;</span></div>
                  	<div class="clear"></div>
                  </div>
                  </div>
              </div><!--end box classic-->
              
               <div class="box-banner"> <a href="#"><img src="images/temp300x250.jpg" alt="EVE Online" width="300" height="250" /></a>
              </div><!--end box banner-->             
              
                <div class="box-classic">
                  <h3>Igra meseca</h3>
                  <div class="box-inside"> <a href="#"><img src="images/temp-im.jpg" alt="Igra meseca: HALO Reach" width="385" height="210" /></a>
				  <h4><a href="#">HALO Reach</a></h4>
                  <p>The game takes place in the year 2552, where humanity is locked in a war with the alien Covenant on the human colony of Reach weeks prior to the events of Halo: Combat Evolved. Players control Noble 6, a member of an elite supersoldier squad, during the battle for the world of Reach.</p>
                  
                  <div class="box-classic-bottom">
                  	<div class="left"><a href="#">Još^</a><span class="separator-small">&nbsp;</span></div>
                    <div class="right"><span class="separator-small">&nbsp;</span><a href="#">25 komentara</a></div>
                    <div class="clear"></div>
                  </div>
                  </div>
              </div><!--end box classic-->
              

              
              
<div class="box-classic">
                  <h3>Demo izlog</h3>
                  <div class="box-inside">
                  	<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam!</p>
                    <h5><a href="#">Pro Evolution Soccer 2011</a></h5>
                  	<p class="item"><a href="#"><img src="images/temp-pes.jpg" alt="Demo: Pro Evolution Soccer 2011" width="140" height="87" /></a>This updated demo includes major changes to team stacking, bug fixes and more.</p>
                    <div class="clear"></div>
                    <h5><a href="#">Football Manager 2011 Strawberry</a></h5>                  
                  	<p class="item"><a href="#"><img src="images/temp-fm2011.jpg" alt="Demo: Football Manager 2011 Strawberry" width="140" height="87" /></a>This updated demo includes major changes to team stacking, bug fixes and more.</p>
                    <div class="clear"></div>
                  
                  <div class="box-classic-bottom">
                  	<div class="left"><a href="#">Još^</a><span class="separator-small">&nbsp;</span></div>
                    <div class="clear"></div>
                  </div>
          </div>
              </div><!--end box classic-->
              
              
              <div class="div-box-tab-list">


                    <ul class="idTabs"> 
                      <li><a href="#top10mesec">Top 10 Meseca</a></li> 
                      <li><a href="#top10godina">Top 10 2011</a></li> 
                    </ul> 
                    <div id="top10mesec">
                    	<ul class="toplist">
                        	<li><a href="#"><span>1</span>Pro Evolution Soccer 2011</a></li>
                        	<li class="odd"><a href="#"><span>2</span>F.E.A.R. 3</a></li>
                        	<li><a href="#"><span>3</span>Diablo III</a></li>
                        	<li class="odd"><a href="#"><span>4</span>Mafia II: Joe's Adventures</a></li>
                        	<li><a href="#"><span>5</span>Medal of Honor</a></li>
                        	<li class="odd"><a href="#"><span>6</span>Fallout: New Vegas</a></li>
                        	<li><a href="#"><span>7</span>Fable III</a></li>
                        	<li class="odd"><a href="#"><span>8</span>Lionheart: Kings' Crusade</a></li>
                        	<li><a href="#"><span>9</span>Starcraft II: Wings of Liberty</a></li>
                        	<li class="odd"><a href="#"><span>10</span>Star Wars: The Force Unleashed II</a></li>
                        </ul>
                        <div class="box-toplist-bottom">
                            <div class="left"><a href="#">Još^</a><span class="separator-small">&nbsp;</span></div>
                            <div class="right"><span class="separator-small">&nbsp;</span><a href="#">25 komentara</a></div>
                            <div class="clear"></div>
                     	</div>
					</div> 
                    <div id="top10godina">
                    	<ul class="toplist">
                        	<li><a href="#"><span>1</span>Starcraft II: Wings of Liberty</a></li>
                        	<li class="odd"><a href="#"><span>2</span>Star Wars: The Force Unleashed II</a></li>
                        	<li><a href="#"><span>3</span>Lionheart: Kings' Crusade</a></li>
                        	<li class="odd"><a href="#"><span>4</span>Fable III</a></li>
                        	<li><a href="#"><span>5</span>Fallout: New Vegas</a></li>
                        	<li class="odd"><a href="#"><span>6</span>Medal of Honor</a></li>
                        	<li><a href="#"><span>7</span>Mafia II: Joe's Adventures</a></li>
                        	<li class="odd"><a href="#"><span>8</span>Diablo III</a></li>
                        	<li><a href="#"><span>9</span>F.E.A.R. 3</a></li>
                        	<li class="odd"><a href="#"><span>10</span>Pro Evolution Soccer 2011</a></li>
                        </ul>
                        <div class="box-toplist-bottom">
                            <div class="left"><a href="#">Još^</a><span class="separator-small">&nbsp;</span></div>
                           
                            <div class="clear"></div>
                     	</div>
                    </div>

              </div>
              <div class="box-classic">
              	<h3>HOT GAME</h3>
                <div class="foto"> <a href="#"><img src="images/temp-foto.jpg" alt="Foto" width="300" height="350" /></a></div>
          <div class="box-bottom">
                  	<div class="left"><a href="#">Još^</a><span class="separator-small">&nbsp;</span></div>
                    <div class="right"><span class="separator-small">&nbsp;</span><a href="#">25 komentara</a></div>
                    <div class="clear"></div>
                </div>
              </div>
              
              
              </div>
              <div class="clear"></div>
                      
            <div class="footer">
            	<h3>ZABAVA</h3>
                <div class="footer-inner">
   	  <div class="left">
                		<iframe title="YouTube video player" width="640" height="390" src="http://www.youtube.com/embed/S5pJ1tAWQ8s" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <div class="right">
                    	<h2>Pošalji nam i ti link sa smešnim videom!</h2>
                        <p>Ukoliko želite da podelite smešan video sa ostalima, unesite njegov URL u predviđeno polje i kliknite na Pošalji!
                        
                        </p>
                   	  <label>YouTube URL:*</label><br />
                   	  <input class="entryfield" name="" type="text" /><br />
					  <input class="button" name="" type="submit" value="Pošalji!" /><br />
						<span>*Trenutno podržavamo linkove samo sa <a href="http://www.youtube.com/" target="_blank">YouTube</a> video servisa. <br />
					  ProGame.rs zadržava pravo da ne objavi ili ukloni linkove bez ikakvog objašnjenja.</span>                        
                  </div>
                    <div class="clear"></div>
                    
                    
                </div>            
            </div>
            
            <div class="bottom-menu"> 
            			<a href="#"><img src="images/foot-pg.png" alt="ProGame.rs" width="42" height="32" /></a>
                      <ul>
                   	    	<li><a href="#">Igre</a></li>
                            <li><a href="#">Hardware</a></li>
                            <li><a href="#">Forum</a></li>
                            <li><a href="#">Galerija</a></li>
                            <li><a href="#">Video</a></li>
                            <li><a href="#">Download</a></li>
                        </ul>
                    	<div class="clear"></div>
                    </div>
            
        	<div class="finish">
            &copy;2011 ProGame.rs. Sva prava zadržana.
            
            </div>
            </div>
            
            
        </div>




</div>
</body>
</html>
