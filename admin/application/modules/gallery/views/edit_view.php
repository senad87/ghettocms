<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>application/modules/gallery/css/gallery.css" />
<div class="headcont">
    <h1 class="heading">Edit gallery</h1>
    <?php echo modules::run('toolbar', 'gallery_title', 'gallery', array('save', 'cancel')); ?>
    <div class="clear"></div>
</div>
<div class="container">
    <div style="display:none" id="message"></div>
    <?php echo form_open_multipart('gallery/edit_post/', array('id'=>'gallery_form'));?>
    <div class="right-panel">
	<h5>Choose category:</h5>
	<div class="box-right-panel">
            <div class="box-right-panel-inbox">
                <ul class="categories_list_rc">
                    <?php foreach ($root_categories as $category) { ?>
                    <li>
                    <?php
                    if (check_category_kids($category->id) == 0) {?>
                    <input <?php if($category->id == $set_category) {?>checked="yes"<?php } ?> type="radio" name="category_id" class="radio_category_id" value="<?php echo $category->id; ?>"/>
                    <? } ?>
                    <a href="#"><?php echo $category->name; ?></a>
                    <?php recursion_categories_edit_radio($category->id, $set_category); ?>
                    </li>
                    <?php } ?>
                </ul>
            </div><!--end of box-right-panel-inbox -->
	</div><!--end of box-right-panel -->
    </div><!--end of right-panel -->
    <div class="left-panel">
        <label for="title"><strong>Title:</strong></label><br />
        <input class="lform2 required"  type="text" name="title" size="50" value="<?php echo $entry->title; ?>"><br />
        <br />
        <label for="lead"><strong>Lead:</strong></label><br />
        <textarea class="lform2-textarea required" style="width: 700px;" name="lead" cols="50" rows="5"><?php echo $gallery['lead']; ?></textarea><br />

	                
        <label for="image"><strong>Gallery Images:</strong></label><br />
        <div id="images" data-fe_href="<?php echo root_url(); ?>" data-href="<?php echo base_url(); ?>gallery/getFirstImage/">
            <div id="mainbody" class="gallMenu">
                <div id="error" ></div>	
                <div id="upload"  class="def_button green floatLeft"><span>Add image(s)</span></div>
                <a id="delete" class="def_button red floatLeft">Delete image(s)</a>
                <span id="status" ></span>
            </div>
            <div class="GallContainer">
               <div class="GallImages">
                   <!-- images grid -->
                   <ol id="selectable" class="ui-selectable">
                       <?php  foreach($images as $image){ ?>
                           <li id="<?php echo $image->id; ?>" class="ui-state-default modal" >
                               <div class="handle"><span class="ui-icon ui-icon-arrow-4"></span></div>    
                           <img src="<?php echo root_url() . $image->path; ?>" width="209" height="135" /></li>	
                       <?php }  ?>
                   </ol>
                   
               </div>
               <div class="ImageDesc">
               	<div class="subTitle">Click on the image to add description for it.</div>
               
               
                   <div id="edit"><!-- space for loading --></div>
                   <br />
                   <div id="selektovano"></div>
                   <br />
                   <!--<div id="foo" ></div>-->
               </div>
               <div class="clear"></div>
            </div>
        </div>	
        <div class="tag-filters">
        <?php if(count($topics) > 0) { ?>
            <?php 
            $i = 0;
            foreach ($topics as $topic) { ?>
                    <?php if(count($tags[$topic->id]) > 0){ ?>
                    <label for="privileges"><?php echo $topic->name; ?>:</label><br />
                    <select class="filter" name="tag_<?php echo $i; ?>">
                    <option value="0">PLEASE CHOOSE:</option>
                            <?php foreach($tags[$topic->id] as $tag) { ?>
                                    <?php if(isset($set_tags[$topic->id])) {?>
                                    <option <?php if($set_tags[$topic->id] == $tag->id){?>selected="selected"<?php } ?> value="<?php echo $tag->id; ?>"><?php echo $tag->tag; ?></option>
                                    <?php }else{ ?>
                                    <option value="<?php echo $tag->id; ?>" ><?php echo $tag->tag; ?></option>
                                    <?php } ?>
                            <?php } ?>
                    </select><br />
                    <?php } ?>
            <?php $i++; } ?>
        <?php } ?>
        </div>         
    </div><!--end of left-panel-->
    <div class="clear"></div>
        <div id="hidden-inputs" >
           <input id="images-order" type="hidden" name="imagesOrder" value="<?php echo $orderString; ?>">
            <input type="hidden" name="gallery_id" value="<?php echo $gallery['id']; ?>">
            <input  type="hidden" name="entry_id" value="<?php echo $entry_id; ?>">
            <?php foreach($images as $image){ ?>
                    <input class='<?php echo $image->id; ?>' type='hidden' name='images[]' value='<?php echo $image->id; ?>' >
            <?php } ?>
        </div>
    </form>
</div>	
</body>

<script type="text/javascript" src="<?php echo base_url();?>application/modules/gallery/scripts/grid.actions.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/modules/gallery/scripts/ajax.upload.actions.js" ></script>


</html>
