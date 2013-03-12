$(document).ready(function(){
    var galleries = $('.gallery');
    //console.log(galleries);
    if(galleries){
        $.each(galleries, function(index, gallery){
            //console.log(gallery.id);
            $.ajax({
                //url: config.base_url+'/gallery/getImages/',
                url: gallery.data('href'),
                type: 'post',
                data: {gallery_id: gallery.id}
            }).done(function(response){
                //console.log(response);
                $('#'+gallery.id).replaceWith(response);
            });
            
        });
    }
});