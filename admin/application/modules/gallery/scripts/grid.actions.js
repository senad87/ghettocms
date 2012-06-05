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

        $("#edit").load(config.base_url+"gallery/loadEdit/", {ids: ids});
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

    $("#update").live('click',function(e){
        e.preventDefault();
        var title = $("#title").val();
        var lead = $("#lead").val();
        //console.log(lead);
        var ids = $("#ids").attr('value').split(',');

        $.each(ids, function(index, value){
            $.ajax({
                url: config.base_url+"gallery/update/",
                type: 'post',
                data: {id: value, title: title, lead: lead},
                async: false
            });
            
            //$.post(config.base_url+"gallery/update/", {id: value, title: title, lead: lead});
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