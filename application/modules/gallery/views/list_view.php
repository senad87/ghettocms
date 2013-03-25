<div class="jscroll_js" id="<?php echo $module_id; ?>" class="box<?php if(isset($module_params['classsuffix']) && $module_params['classsuffix'] != "") echo $module_params['classsuffix']; ?>">
	<h1 class="title"><?php if($module_params['box_title'] != ""){ echo $module_params['box_title']; }?></h1>
	<?php
	//counter of the displayed articles
	$a = 1;
	foreach( $items as $item ){ ?>
<div class="block">
    <div class="img-block2">
        <?php if( $module_params['poster_photo'] >= $a ):?>               
            <?php if( count( $item->image ) > 0 ): ?>
                <img src="<?php echo base_url(); ?><?php echo $item->image[0]->path; ?>" title="<?php echo $item->title; ?>" alt="<?php echo  $item->title; ?>" />
            <?php endif;
            endif;  
        if($module_params['title'] >= $a): ?>       
                <h2>
                    <a href="<?php echo base_url(); ?><?php echo $item->type_name; ?>/<?php echo $menu_id; ?>/<?php echo $item->id; ?>/<?php echo url_sufix_serbian( $item->title ); ?>">
                        <span><?php echo $item->title; ?></span>
                    </a>
                </h2>
        <?php endif; ?>
     </div>
     <div class="news-block">  
     <div class="news-block-info">

         <?php if ( $module_params['author'] >= $a ): 
             if ( isset($item->author_name) ): ?>
            
             Postavio: <a href="#"><?php echo $item->author_name; ?></a>
             <?php endif;
         endif; ?>
         <span class="separator">&nbsp;</span>

         <?php if ( $module_params['creation_date'] >= $a and isset($item->creation_date) ): ?>
             <?php echo srb_date( $item->creation_date ); ?>
         <?php endif; ?>

         <span class="separator">&nbsp;</span>
         <?php if ( $module_params['category_name'] >= $a && is_object( $item->menu ) ): ?>
             <a href="<?php echo base_url(); ?><?php echo $item->menu->name; ?>/<?php echo $item->menu->id; ?>/"><?php echo $item->menu->name; ?></a>
         <?php endif; ?>
         <span class="separator">&nbsp;</span>
         <?php if( $module_params['number_of_comments'] >= $a ): ?>
             <a href="<?php echo base_url(); ?><?php echo $item->type_name; ?>/<?php echo $menu_id; ?>/<?php echo $item->id; ?>/<?php echo url_sufix_serbian( $item->title ); ?>#commlist">
                 <?php echo count_comments($item->id); ?> komentara
             </a>
         <?php endif; ?>                  
    </div>
    <?php if( $module_params['lead'] >= $a && isset( $item->gallery->lead ) ){?>
        <div class="news-block-lead">
            <?php echo $item->gallery->lead; ?>
        </div>
    <?php } ?>     
    <?php if($module_params['readmore'] >= $a): ?>
    <div class="readmore">
        <?php if( count( $item->tags ) > 0): ?>
           <p class="tags2">
               <?php foreach ($item->tags as $tag): ?>
                <a href="<?php echo base_url();?>tags/index/<?php echo $menu_id; ?>/<?php echo $tag->id; ?>">
                    <?php echo $tag->tag; ?>
                </a>
               <?php endforeach; ?>
            </p>
        <?php endif; ?>	            
        <a href="<?php echo base_url(); ?><?php echo $item->type_name; ?>/<?php echo $menu_id; ?>/<?php echo $item->id; ?>/<?php echo url_title( $item->title ); ?>">
            Opširnije >
        </a>
    </div>
    <?php endif; ?>     
    </div>
</div>
<!-- end article item -->
   
	<?php $a++;
	} 
	?>
	<!-- <div><?php echo $pagination; ?></div> -->
	<?php if($module_params['link_title'] != ""){?>
		<div class="mainlink"><a href="<?php echo base_url(); ?><?php if($module_params['link_url'] != ""){ echo $module_params['link_url']; }?>" /> <?php echo $module_params['link_title']; ?> > </a></div>
	<?php } ?>
	<?php if($total_rows > $module_params['number']){?>
		<div class="pagination<?php if(isset($module_params['classsuffix']) && $module_params['classsuffix'] != "") echo $module_params['classsuffix']; ?>"><?php echo $pagination; ?></div>
	<?php } ?>
               
</div>
<script>
    $('html, body').animate({ 
                        scrollTop: $('.body-wrapper').offset().top 
                    }, 'fast');
</script>    
