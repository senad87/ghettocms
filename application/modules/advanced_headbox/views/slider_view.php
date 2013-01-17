<div class="headboxContainer">
<div class="headbox">
    <div id="headboxSlider" class="royalSlider heroSlider rsMinW">
      <?php foreach ( $items as $item ): ?>
       <div class="rsContent">
            <img class="rsImg" src="<?php echo base_url(); ?><?php echo $item->image_path; ?>" alt="<?php echo $item->title; ?>" />
            <div class="infoBlock infoBlockLeftBlack rsABlock rsNoDrag" data-fade-effect="" data-move-offset="10" data-move-effect="bottom" data-speed="200">
               <?php if( isset($module_params['title']) and $module_params['title'] == 1 ): ?>
                <h4><?php echo $item->title; ?></h4>
                <?php  endif; ?>
            </div>
            <div data-delay="350" class="bigButton rsNoDrag rsAbsoluteEl" data-fade-effect="" data-move-offset="10" data-move-effect="bottom" data-speed="200">
                <a href="<?php echo base_url(); ?><?php echo $item->entry_type->type_name; ?>/<?php echo $menu_id; ?>/<?php echo $item->type_id; ?>/<?php echo url_title( $item->title ); ?>">Više informacija</a>
            </div>
       </div>
       <?php endforeach; ?>
    </div>
    <img src="http://digitalizacija.ghetto.rs/application/views/images/slider-linija.png" width="960" height="127" style="position: absolute; bottom: 0; z-index: 110;" />
         <div class="headboxBottom">Potpuno gašenje analognog servisa izvršiće se do 17. juna 2015. godine.<br />
			<strong>Da li ste spremni za prelazak na digitalnu televiziju?</strong>
         
         </div>
    </div>
</div>