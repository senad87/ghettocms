<div id="<?php echo $module_id; ?>" class="<?php if (isset($module_params['classsuffix']) && $module_params['classsuffix'] != "") echo $module_params['classsuffix']; ?>"> 
        <h2 class="title"><?php
            if ($module_params['box_title'] != "") {
                echo $module_params['box_title'];
            } ?>
            
            
                        <?php if ( isset( $module_params['link_title'] ) and  $module_params['link_title'] != "" ) { ?>
                            <a class="smallButton" href="<?php echo base_url(); ?><?php echo $story['type_name']; ?>/<?php echo $data['menu_id']; ?>/<?php echo $story['id']; ?>/<?php echo url_title($story['title']); ?>">Pogledaj sve</a>
                        <?php } ?>            
            
            
        
        
        
        </h2>
        
    

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
           
                <?php if ($module_params['title'] >= $a) { ?>
                    <span class="qm"></span>
                    
                    <div class="newsItem">
                    <div class="qList">
                        <a class="link" href="<?php echo base_url(); ?><?php echo $story['type_name']; ?>/<?php echo $data['menu_id']; ?>/<?php echo $story['id']; ?>/<?php echo url_title($story['title']); ?>">
                            <?php echo $story['title']; ?>
                        </a>
                   </div>
                <?php } ?>
                <!-- Creation Date -->    
                <?php if ($module_params['creation_date'] >= $a) { ?>
                <span class="date">
                    <?php echo srb_date($story['creation_date']); ?>
                </span>    
                <?php } ?>
                <!-- end of Creation Date -->
                <!-- Lead -->
                <?php if ( $module_params['lead'] >= $a && $story['lead'] ) { ?>
                    <div class="lead">
                        <?php echo $story['lead']; ?><br />
                    </div>
                <?php } ?>
                <!-- end of Lead -->
                </div>    
                <div class="clear"></div>
           
      </li>
      <!-- end of one news Item -->
   

<?php
$a++;
}
?>
</ul>

<?php if ( $total_rows > $module_params['number'] ) { ?>
    <div class="pagination <?php if (isset($module_params['classsuffix']) && $module_params['classsuffix'] != "") echo $module_params['classsuffix']; ?>">
        <?php echo $pagination; ?>
    </div>
     <script>
    $('html, body').animate({ scrollTop: $('.body-wrapper').offset().top }, 'slow');
</script>
<?php } ?>   

</div>
