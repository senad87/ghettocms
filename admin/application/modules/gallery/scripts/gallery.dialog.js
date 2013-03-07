$(document).ready(function(){
	var checked = Array();

	$("#gallery-dialog").dialog({
			resizable: false,
                        autoOpen: false,
			width:850,
			modal: true,
			buttons: {
				"Add": function(){
                                    var $images = $('#images'),
                                        galleryId = $("input[name=story_id]:checked").val(),
                                        $url = $images.data('href'),
                                        $fe_url = $images.data('fe_href');
                                    
                                    $.ajax({
                                        type: 'post',
                                        //url: config.base_url+'gallery/getFirstImage/',
                                        url: $url,
                                        data: { gallery_id: galleryId },
                                        success: function(response) {
                                            //CKEDITOR.instances.editor1.insertHtml("<div class='gallery' id='gallery-"+galleryId+"'><img src='"+config.frontend_url+response.image_path+"' /></div>");
                                            CKEDITOR.instances.editor1.insertHtml("<img width='200px' height='100px' class='gallery' id='"+galleryId+"' src='"+$fe_url+response.image_path+"' />");
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