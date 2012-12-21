<div class="headboxContainer">
<div class="headbox">



<div id="headboxSlider" class="royalSlider heroSlider rsMinW">
  <?php foreach ( $items as $item ): ?>
   <div class="rsContent">
    <img class="rsImg" src="<?php echo fiximgsrc( $item->file_location ); ?>" alt="<?php echo $item->name; ?>" />
    <div class="infoBlock infoBlockLeftBlack rsABlock rsNoDrag" data-fade-effect="" data-move-offset="10" data-move-effect="bottom" data-speed="200">
       
      <p><?php echo $item->description; ?></p>
      
 	</div>
    <div data-delay="350" class="bigButton rsNoDrag rsAbsoluteEl" data-fade-effect="" data-move-offset="10" data-move-effect="bottom" data-speed="200">
        <a href="#">Više informacija</a>
    </div>
   </div>
   <?php endforeach; ?>
<img src="http://digitalizacija.ghetto.rs/application/views/images/slider-linija.png" width="960" height="127" style="position: absolute; bottom: 0; z-index: 110;" />


</div>
         <div class="headboxBottom">Potpuno gašenje analognog servisa izvršiće se do 17. juna 2015. godine.<br />
			<strong>Da li ste spremni za prelazak na digitalnu televiziju?</strong>
         
         </div>
    </div>
</div>