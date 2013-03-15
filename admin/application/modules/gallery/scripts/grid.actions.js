//$(function() {
$(document).ready(function(){
    $( "#selectable" )
        .sortable({
            handle: ".handle",
            stop: function(){
                var sOrder = '';
                var count = $( "#selectable" ).children('li').length;
                $.each($( "#selectable" ).children('li'), function(index, item){
                    var li = $(item);
                    index += 1;//increment index because it starts from 0
                    sOrder += li.attr('id')+ ":" + index;
                    
                    if(index < count){
                        sOrder += "|"; 
                    }
                });

                $('#hidden-inputs').children('#images-order').attr('value', sOrder);

            }
        })
        .selectable({
        filter: 'li',
        stop: function(event, ui) {
            var qwerty = [];
            //var result = $( "#select-result" ).empty();
            $( ".ui-selected", this ).each(function() {
                var index = $( "#selectable li" ).index( this );
                qwerty[index] = $(this).attr('id');
            });
            //console.log( qwerty );
            var ids = cleanArray(qwerty);
            //console.log( ids );
            //console.log('Edit image name and lead');
            //$("#edit").load(config.base_url+"gallery/loadEdit/", {ids: ids});
            $("#edit").load( $('#edit').data('href'), {ids: ids});
            //$("#crop_button").attr('href', '<?php  echo base_url();?>gallery/open/'+ids[0]);
        }
    });
    
    $("#delete").click(function(){
        //TODO: delete images from file ssystem THIS IS IMPORTANT!!!
        var ids = $("#ids").attr('value').split(',');
        $.each(ids, function(index,value){
            $("#"+value).remove(); //removes <li>
            $("."+value).remove();//removes hidden input
        });
    });

    //$("#update").live('click',function(e){
    //$(".instant-update").live('input',function(e){
    //edit by damir, update on focusout
    $(".instant-update").live('focusout',function(e){
        e.preventDefault();
        saveImageData();
    });
    
    $('.GallImages').on('mouseenter', function(){
        saveImageData();
    });
    
    //saving image lead and title
    function saveImageData(){
        var title = $("#title").val();
        var lead = $("#lead").val();
        //console.log(lead);
        var ids = $("#ids").attr('value').split(',');

        $.each(ids, function(index, value){
            $.ajax({
                //url: config.base_url+"gallery/update/",
                url: $('#images').data('update_href'),
                type: 'post',
                data: {id: value, title: title, lead: lead},
                async: false
            });
        });
    }
    
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