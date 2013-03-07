<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>application/modules/gallery/css/gallery.css" />
<div class="headcont">
<h1 class="heading">Add New gallery</h1>
<?php echo modules::run('toolbar', 'gallery_title', 'gallery', array('save', 'cancel')); ?>
<div class="clear"></div>
</div>
<?php echo form_open_multipart('gallery/createNew_post/', array('id'=>'gallery_form'));?>
<div class="container">
    <div class="right-panel">
    <h5>Choose category:</h5>
        <div class="box-right-panel">
            <div class="box-right-panel-inbox" style="padding:0;">
                <div class="table-minicat">
                    <table class="data" border="0" cellpadding="0" cellspacing="0">
                    <thead></thead>
                    <?php foreach ($root_categories as $category) { ?>
                    <tr class="rolover">
                    <?php if (check_category_kids($category->id) == 0) {?>
                    <td width="8" align="center"><input type="radio" name="category_id" class="radio_category_id" value="<?php echo $category->id; ?>"/></td>
                    <td><a href="<?=base_url(); ?>category/edit/<?php echo $category->id; ?>"><?php echo $category->name; ?></a></td>
                    <? } else { ?>
                    <td width="8" align="center"><input type="radio" name="category_id" class="radio_category_id" value="<?php echo $category->id; ?>" disabled></td>
                    <td><a href="<?=base_url(); ?>category/edit/<?php echo $category->id; ?>"><?php echo $category->name; ?></a></td>
                    <?php } ?>
                    </tr>
                    <?php 
                    $level = $level = ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    recursion_categories_checkbox($category->id, $level); ?>
                    <?php } ?>
                    <tfoot></tfoot>
                    </table>
                </div><!--end of table-minicat -->
            </div><!--end of box-right-panel-inbox -->
        </div><!--end of box-right-panel -->    
    </div><!--end of right-panel -->
<div class="left-panel">
	<label for="title"><strong>Title:</strong></label><br />
	<input class="lform2" style="width: 700px;" type="text" name="title" size="50" value="">
        <br />
	<label for="lead"><strong>Lead:</strong></label><br />
	<textarea class="lform2-textarea" style="width: 700px;" name="lead" cols="50" rows="5"></textarea>
        <br />
	<label for="image"><strong>Upload Images:</strong></label><br />
        <div id="images" data-fe_href="<?php echo root_url(); ?>" data-href="<?php echo base_url(); ?>gallery/getFirstImage/">
            <div id="mainbody" >
                <div id="error" ></div>	
                    <div id="upload" >
                        <span>+</span>
                    </div>
                    <a id="delete" >Delete</a>  
                <span id="status" ></span>
            </div>
            
            <div style="width: 1280px;">
            <div  style="width: 100%; float: left;">
                <!-- images grid -->
                <ol id="selectable" class="ui-selectable">
                    <!--this area is populated when user adds images to gallery -->
                </ol>
            </div>
            <div style="width: 380px; float: right;">
            <div id="edit"><!-- space for loading --></div>
            
            <br />
            <!--<a id="insert" >Insert</a>
            <br />
            <a id="crop_button" href="#" class="modal">Crop</a>

            <div style="clear: both;"></div>
            </div>
            <br />

            <br />
            -->
            <div id="selektovano"></div>
            <!-- End demo -->
            <br />

            <div id="foo" ></div>
            </div>
        <label><small>Dimensions: <?php echo $largest_image->width;?> x <?php echo $largest_image->height;?></small></label>
        <br />
        
        
	<div class="tag-filters">
	<?php if(isset($topics)){ ?>
		<?php if(count($topics) > 0) { ?>
		<?php 
		  $i = 0;
		  foreach ($topics as $topic) { ?>
			  <?php if(count($tags[$topic->id]) > 0){ ?>
			    <label for="privileges"><?php echo $topic->name; ?>:</label><br />
			    <select class="filter" name="tag_<?php echo $i; ?>">
				  <option value="0">Please choose:</option>
			  	  <?php foreach($tags[$topic->id] as $tag) { ?>
				  <option value="<?php echo $tag->id; ?>"><?php echo $tag->tag; ?></option>
				  <?php } ?>
			    </select><br />
			  <?php } ?>
		  <?php $i++; } ?>
        <?php } ?>
<?php } ?>
</div>
<!-- system tags selection -->
</div><!--end of left-panel-->
<div class="clear"></div>        
</div>
        
        <div id="hidden-inputs" >
           <input id="images-order" type="hidden" name="imagesOrder" value="">
        </div>
        
</form>    
</body>
<script type="text/javascript" src="<?php echo base_url(); ?>system/application/style/js/tag-it.js"></script>
  
<div id="gallery-dialog" style="display: none;" title="Choose Gallery">
<div id="content">
<table class="data" border="0" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
		<th width="35" style="text-align: center;">ID</th>
		<th style="text-align: center;" width="10">#</th>
		<th width="300" align="left">Title</th>
		</tr>
		</thead>
		<?php $i=0; ?>
		<?php if (isset($stories)){ ?>
		<?php foreach($stories as $gallery) { ?>
			<tr class="rolover" <?php if ($i%2 == 0){ ?> bgcolor="#f3f3f3" <?php } ?>>
			<td align="right"><?php echo $gallery->id; ?></td>
			<td align="center" width="20"><input type="checkbox" name="gallery_id" value="<?php echo $gallery->id; ?>"></td>
			<td align="left"><?php echo $gallery->title; ?></td>
			</tr>
		<?php $i++; ?>
		<?php } ?>
		<?php }else{ ?>
   			<tr><td colspan="8"><?php echo $no_entries; ?></td></tr>
   	 	<?php } ?>
		<tfoot>
			<tr>
		<th colspan="8"><div><?php echo $pagination; ?></div></th>
		</tr>
		</tfoot>
</table>
</div>
</div>

<script type="text/javascript" src="<?php echo base_url();?>application/modules/gallery/scripts/grid.actions.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/modules/gallery/scripts/ajax.upload.actions.js" ></script>
</html>