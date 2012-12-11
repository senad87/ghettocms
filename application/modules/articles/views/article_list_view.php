<div id="<?php echo $module_id; ?>" class="roundedBox4 <?php if (isset($module_params['classsuffix']) && $module_params['classsuffix'] != "") echo $module_params['classsuffix']; ?>">
    <div class="contentTitleZone">  
        <h1 class="title"><?php
            if ($module_params['box_title'] != "") {
                echo $module_params['box_title'];
            } ?>
        </h1>
        <p>Najnovije vesti vezane za prelazak na digitalnu televiziju</p>
    </div>
    
    <div class="contentList">
        <ul>
        <?php
        //counter of the displayed articles
        $a = 1;
        foreach ($stories_row as $story) { ?>
        <!-- one new Item -->
        <li>
            <?php if ($module_params['poster_photo'] >= $a) { ?>               
                <?php if (count($story['photo_path']) > 0) { ?>
                <a href="<?php echo base_url(); ?><?php echo $story['type_name']; ?>/<?php echo $data['menu_id']; ?>/<?php echo $story['id']; ?>/<?php echo url_title($story['title']); ?>">    
                    <img src="<?php echo base_url(); ?><?php echo $story['photo_path']; ?>" title="<?php echo $story['title']; ?>" alt="<?php echo $story['title']; ?>" />
                </a>    
                <?php } ?>
            <?php } ?>                
            <div class="newsItem">
                <?php if ($module_params['title'] >= $a) { ?>
                    <div class="title">
                        <a href="<?php echo base_url(); ?><?php echo $story['type_name']; ?>/<?php echo $data['menu_id']; ?>/<?php echo $story['id']; ?>/<?php echo url_title($story['title']); ?>">
                            <?php echo $story['title']; ?>
                        </a>
                    </div>
                <?php } ?>
                <!-- Creation Date -->    
                <?php if ($module_params['creation_date'] >= $a) { ?>
                <div class="date">
                    <?php echo srb_date($story['creation_date']); ?>
                </div>    
                <?php } ?>
                <!-- end of Creation Date -->
                <!-- Lead -->
                <?php if ( $module_params['lead'] >= $a && $story['lead'] ) { ?>
                    <div class="lead">
                        <?php echo $story['lead']; ?><br />

                        <?php if ( $module_params['readmore'] >= $a ) { ?>
                            <a href="<?php echo base_url(); ?><?php echo $story['type_name']; ?>/<?php echo $data['menu_id']; ?>/<?php echo $story['id']; ?>/<?php echo url_title($story['title']); ?>">Opširnije ></a>
                        <?php } ?>
                    </div>
                <?php } ?>
                <!-- end of Lead -->    
                <div class="clear"></div>
            </div><!-- end of newsItem -->
      </li>
      <!-- end of one news Item -->
        <!-- NO NEED TO USE THIS FOR DIGITALIZACIJA            
       <div class="news-block">  
       <div class="news-block-info">
       <?php if ($module_params['author'] >= $a) { ?>
       Postavio: <a href="#"><?php echo $story['author_name']; ?></a>
       <?php } ?>                
       <span class="separator">&nbsp;</span>
       <span class="separator">&nbsp;</span>
       <?php if ($module_params['category_name'] >= $a && $story['menu_name']) { ?>
       <a href="<?php echo base_url(); ?><?php echo $story['menu_name']->name; ?>/<?php echo $story['category']->menu_id; ?>/"><?php echo $story['menu_name']->name; ?></a>
       <?php } ?>
       <span class="separator">&nbsp;</span>
       <?php if ($module_params['number_of_comments'] >= $a) { ?>
       <a href="<?php echo base_url(); ?><?php echo $story['type_name']; ?>/<?php echo $data['menu_id']; ?>/<?php echo $story['id']; ?>/<?php echo url_title($story['title']); ?>#commlist"><?php echo count_comments($story['id']); ?> komentara</a>
       <?php } ?>                  
       </div>
       <?php if ($module_params['readmore'] >= $a) { ?>
       <div class="readmore">
       <?php if ($story['tag_id'] > 0) { ?>
       <p class="tags2">
       <a href="<?php echo base_url(); ?>tags/index/<?php echo $data['menu_id']; ?>/<?php echo $story['tag_id']; ?>"><?php echo $story['tag']; ?></a>
       </p>
       <?php } ?>
       <a href="<?php echo base_url(); ?><?php echo $story['type_name']; ?>/<?php echo $data['menu_id']; ?>/<?php echo $story['id']; ?>/<?php echo url_title($story['title']); ?>">Opširnije ></a>
       </div>
           <?php } ?>              
       </div> -->

<?php
$a++;
}
?>
</ul>
            <!-- <div><?php echo $pagination; ?></div> -->
                   <!-- <?php if ($module_params['link_title'] != "") { ?>
                   <div class="mainlink"><a href="<?php echo base_url(); ?><?php
                                        if ($module_params['link_url'] != "") {
                                            echo $module_params['link_url'];
                                        }
                                        ?>" /> <?php echo $module_params['link_title']; ?> > </a></div>
             <?php } ?> -->
<?php if ( $total_rows > $module_params['number'] ) { ?>
    <div class="pagination<?php if (isset($module_params['classsuffix']) && $module_params['classsuffix'] != "") echo $module_params['classsuffix']; ?>">
        <?php echo $pagination; ?>
    </div>
<?php } ?>   
    </div> <!-- end of content list -->
</div>  <!-- end of roundedBox4 --> 
<script>
    $('html, body').animate({ scrollTop: $('.body-wrapper').offset().top }, 'slow');
</script>    