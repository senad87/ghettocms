$(document).ready(function(){
    var checked = Array();

    $("#gallery-dialog").dialog({
        resizable: false,
        autoOpen: false,
        width:850,
        modal: true,
        buttons: {
            "Add": function(){
                var $body = $('body'),
                galleryId = $("input[name=story_id]:checked").val(),
                $url = $body.data('base_href') + 'gallery/getFirstImage/',
                $fe_url = $body.data('fe_href'),
                $get_gallery = $fe_url + 'gallery/getImages/';          
                $.ajax({
                    type: 'post',
                    //url: config.base_url+'gallery/getFirstImage/',
                    url: $url,
                    data: {
                        gallery_id: galleryId
                    },
                    success: function(response) {
                        //CKEDITOR.instances.editor1.insertHtml("<div class='gallery' id='gallery-"+galleryId+"'><img src='"+config.frontend_url+response.image_path+"' /></div>");
                        CKEDITOR.instances.editor1.insertHtml("<img width='200px' height='100px' class='gallery' data-href='"+$get_gallery+"' id='"+galleryId+"' src='"+$fe_url+response.image_path+"' />");
                    }
                });
                $(this).dialog( "close" );
            },
            Cancel: function() {
                $(this).dialog( "close" );
            }
        }
    });
});