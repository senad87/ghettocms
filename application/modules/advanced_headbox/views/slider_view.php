
<div class="headbox">
    <div id="headboxSlider" class="royalSlider heroSlider rsMinW">
      <?php foreach ( $items as $item ): ?>
       <div class="rsContent">
            <img class="rsImg" src="<?php echo base_url(); ?><?php echo $item->image_path; ?>" alt="<?php echo $item->title; ?>" />
            <div class="infoBlock infoBlockLeftBlack rsABlock rsNoDrag" data-fade-effect="" data-move-offset="10" data-move-effect="bottom" data-speed="200">
               <?php if( isset($module_params['title']) and $module_params['title'] == 1 ): ?>
                <h4> <a href="<?php echo base_url(); ?><?php echo $item->entry_type->type_name; ?>/<?php echo $menu_id; ?>/<?php echo $item->type_id; ?>/<?php echo url_title( $item->title ); ?>"><?php echo $item->title; ?></a></h4>
                <?php  endif; ?>
            </div>

       </div>
       <?php endforeach; ?>
    </div>
    

    </div>

      
      
      
      
 <script>
jQuery(document).ready(function($) {
  $('#headboxSlider').royalSlider({
    arrowsNav: true,
    loop: true,
    keyboardNavEnabled: true,
    controlsInside: false,
    imageScaleMode: 'fit-if-smaller',
    arrowsNavAutoHide: false,
    autoScaleSlider: false, 
    autoScaleSliderWidth: 660,     
    autoScaleSliderHeight: 410,
    controlNavigation: 'bullets',
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