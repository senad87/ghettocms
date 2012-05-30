<style>
#images{
       width: 98%;
       height: auto;
}
.gallery-images-li {
    display: block;
    width: 200px;
    float: left;
    margin: 10px;
}
.gallery-images{
    display: block;
    margin-bottom: 50px;
}


#feedback { font-size: 1.4em; }
#selectable .ui-selecting { background: #66A3D3; }
#selectable .ui-selected { background: #66A3D3; color: white; }
#selectable { border: 1px solid #66A3D3; list-style-type: none; margin: 0; padding: 20px; height: 600px; width: 88%;}
#selectable li { margin: 3px; padding: 1px; float: left; width: 209px; height: 135px; font-size: 4em; text-align: center; }
.ui-selected img { opacity: 0.4; }
.ui-selecting img { opacity: 0.4; }

</style>
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
        <!--
	<label for="title"><strong>Activation Date:</strong></label><br />
	<input class="lform2 required" style="width: 150px;" id="datepicker" type="text" name="creation_date" size="20" value="">
        -->
        <br />
	<label for="image"><strong>Upload Images:</strong></label><br />
        <div id="images">
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
                    <?php /* foreach($images as $image){ ?>
                            <li id="<?php echo $image->id;?>" class="ui-state-default modal" ><img src="<?php echo 'http://localhost/ghettocms'.substr($image->path, 2);?>" width="80" height="70" /></li>	
                    <?php } */ ?>
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
        
        <div id="hidden-inputs" > </div>
        
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

<script type="text/javascript" >
                    //$(function() {
                    $(document).ready(function(){
                            $( "#selectable" ).selectable({
                                    filter: 'li',
                                    stop: function(event, ui) {
                                    var qwerty = [];
                                    //var result = $( "#select-result" ).empty();
                                    $( ".ui-selected", this ).each(function() {
                                                    var index = $( "#selectable li" ).index( this );

                                                            qwerty[index] = $(this).attr('id');

                                            });
                                    var ids = cleanArray(qwerty);
          
                                    $("#edit").load("<?php echo base_url();?>gallery/loadEdit/", {ids: ids});
                                    //$("#crop_button").attr('href', '<?php  echo base_url();?>gallery/open/'+ids[0]);
                                    }

                                    });
                            $("#delete").click(function(){
                                    var ids = $("#ids").attr('value').split(',');

                                    $.each(ids, function(index,value){
                                                    //alert(index+': '+value);
                                            $("#"+value).remove();
                                            $("."+value).remove();
                                            //$.post("<?php echo base_url();?>gallery/deleteImg/", {id: value});
                                    });
                            });

                            $("#insert").click(function(){
                                    var ids = $("#ids").attr('value').split(',');
                                    var src = $('#'+ids[0]).children().attr('src');

                                    window.opener.CKEDITOR.tools.callFunction(1, src);
                                    window.close();
                            });


                            $("#update").live('click',function(){
                                    var title = $("#title").val();
                                    var tags = $("#tags").val();
                                    var ids = $("#ids").attr('value').split(',');

                                    $.each(ids, function(index,value){
                                                    //alert(index+': '+value);
                                            //$("#"+value).remove();
                                            $.post("<?php echo base_url();?>gallery/update/", {id: value, title: title, tags: tags});
                                    });
                            });
            });


function cleanArray(actual){
        var newArray = new Array();
        for(var i = 0; i<actual.length; i++){
            if (actual[i]){
                newArray.push(actual[i]);
            }
        }
        return newArray;
}

</script>

<script type="text/javascript" >
                    //$(function(){
                    $(document).ready(function(){
                            var btnUpload=$('#upload');
                            var status=$('#status');
                            //alert('test');
                            new AjaxUpload(btnUpload, {
                                    action: '<?php echo base_url();?>gallery/upload/',
                                    name: 'uploadfile',
                                    responseType: 'json',
                                    onSubmit: function(file, ext){
                                            if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                                                    //extension is not allowed 
                                                    status.text('Only JPG, PNG or GIF files are allowed');
                                                    return false;
                                            }
                                            status.text('Uploading...');
                                    },
                                    onComplete: function(file, response){
                                            //On completion clear the status
                                            status.text('');
                                            //Add uploaded file to list
                                            //alert(response);
                                            var id = uniqid();
                                            //alert(response);
                                            //console.log(response);
                                            if(response==="error"){
                                                    $('#error').prepend('<span style="color:red" id="'+id+'">'
                                                    +'Error Uploding file '+file+'<a class="close">X</a>'
                                                    +'</span>');
                                            }else if(response==="file_exists"){
                                                    $('#error').prepend('<span style="color:red" id="'+id+'">'
                                                    +'File '+file+' already exists!<a class="close">X</a>'
                                                    +'</span>');
                                            }else{
                                                    //u ovom slucaju response je json sa podacima
                                                    $('#selectable').prepend(
                                                    '<li class="ui-state-default modal" id="'+response.id+'"><img width="209" height="135" src="<?php echo root_url(); ?>'+response.filepath+'" alt="" />'
                                                    +'</li>');
                                                    $('#hidden-inputs').append("<input class='"+response.id+"' type='hidden' name='images[]' value='"+response.filepath+"' >");
                                            }



                                            $("#foo").load("<?php echo base_url(); ?>gallery/script/", {id: id, image: file });
                                    }
                            });



                    });
function uniqid(){
    var newDate = new Date;
    return newDate.getTime();
}
</script>



</html>
