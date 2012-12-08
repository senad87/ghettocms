<!-- main module div -->
<div class="<?php if (isset($module_params['classsuffix']) && $module_params['classsuffix'] != "") echo $module_params['classsuffix']; ?>">
    <div class="img-block2">
        <?php if ($module_params['poster_photo'] == 1) { ?>
            <img src="<?php echo base_url(); ?><?php echo $thumb_image_path; ?>" title="<?php echo $entry->title; ?>" alt="<?php echo $entry->title; ?>" />
        <?php } ?>
    </div>         
    <div class="news-block">  
        <?php if ($module_params['title'] == 1) { ?>
            <div class="title"><h1><?php echo $entry->title; ?> </h1></div>
        <?php } ?>
        <div class="news-block-info">
            <?php if ($module_params['creation_date'] == 1) { ?>
                <div class="date"><?php echo $entry->creation_date; ?></div>
            <?php } ?>
        </div>
        <div class="news-block-content">
            <?php if ($module_params['lead'] == 1) { ?>
                <p class="lead"><?php echo $story[0]->lead; ?></p>
            <?php } ?>
            <?php if ($module_params['body'] == 1) { ?>
                <?php echo $story[0]->body; ?>
            <?php } ?>
            <?php //print_r($from_menu_id) ?>
            <?php if ($module_params['comments'] == 1) { ?>     
                <?php echo modules::run('comments', array($from_menu_id, $item_id)); ?>  
            <?php } ?>
        </div>
    </div>
</div><!-- end main module div -->