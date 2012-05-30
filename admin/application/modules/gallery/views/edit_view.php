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

	                
        <label for="image"><strong>Upload Images:</strong></label><br />
        <div id="images">
            <div id="mainbody" >
                <div id="error" ></div>	
                <div id="upload" ><span>+</span></div>
                <a id="delete" >Delete</a>
                <span id="status" ></span>
            </div>
            <div  style="width: 100%; float: left;">
                <!-- images grid -->
                <ol id="selectable" class="ui-selectable">
                    <?php  foreach($images as $image){ ?>
                        <li id="<?php echo $image->id;?>" class="ui-state-default modal" ><img src="<?php echo 'http://localhost/ghettocms'.$image->path; ?>" width="209" height="135" /></li>	
                    <?php }  ?>
                </ol>
            </div>
            <div style="width: 380px; float: right;">
                <div id="edit"><!-- space for loading --></div>
                <br />
                <div id="selektovano"></div>
                <br />
                <div id="foo" ></div>
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
            <input type="hidden" name="gallery_id" value="<?php echo $gallery['id']; ?>">
            <input  type="hidden" name="entry_id" value="<?php echo $entry_id; ?>">
            <?php foreach($images as $image){ ?>
                    <input class='<?php echo $image->id; ?>' type='hidden' name='images[]' value='<?php echo $image->id; ?>' >
            <?php } ?>
        </div>
    </form>
</div>	
</body>

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
            $("#"+value).remove();
            $("."+value).remove();
        });
    });

//    $("#insert").click(function(){
//        var ids = $("#ids").attr('value').split(',');
//        var src = $('#'+ids[0]).children().attr('src');
//
//        window.opener.CKEDITOR.tools.callFunction(1, src);
//        window.close();
//    });


    $("#update").live('click',function(){
        var title = $("#title").val();
        var tags = $("#tags").val();
        var ids = $("#ids").attr('value').split(',');

        $.each(ids, function(index, value){
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
$(document).ready(function(){
        var btnUpload=$('#upload');
        var status=$('#status');
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
                        var id = uniqid();
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
                                $('#selectable').append(
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
